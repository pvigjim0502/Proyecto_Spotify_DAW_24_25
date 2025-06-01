async function iniciarSesion() {
    // obtener el nombre de usuario y la contraseña desde los campos de entrada
    var nombreUsuario = document.getElementById('nombreUsuario').value.trim();
    var contrasena = document.getElementById('contrasena').value.trim();

    // si esta vacio da error
    if (!nombreUsuario || !contrasena) {
        mostrarToast('Por favor, completa todos los campos.', 'error');
        return;
    }

    try {
        // crear un objeto formData para enviar los datos al servidor
        var formData = new FormData();
        formData.append('nombreUsuario', nombreUsuario);
        formData.append('contrasena', contrasena);

        var respuesta = await fetch('./controladores/LoginControlador.php', {
            method: 'POST',
            body: formData
        });

        var datos = await respuesta.json();

        if (datos.exito) {
            mostrarToast("Inicio de sesión exitoso", 'exito');

            // guardar información en cookies para recordar la sesión del usuario
            crearCookie('sesionActiva', 'true', 7);
            crearCookie('usuarioNombre', nombreUsuario, 7);

            // verificar si el usuario es administrador y guardar esta información en una cookie
            if (datos.esAdmin) {
                crearCookie('esAdmin', 'true', 7);
            } else {
                crearCookie('esAdmin', 'false', 7);
            }

            // actualizar la interfaz de usuario para mostrar que el usuario ha iniciado sesion
            document.getElementById('formularioLogin').style.display = 'none';
            document.getElementById('cabecera').style.display = 'block';
            document.getElementById('pagina-inicio').style.display = 'block';
            document.getElementById('usuario-nombre').textContent = nombreUsuario;
            document.getElementById('pieDePagina').style.display = 'block';

            // mostrar el menú de administrador si el usuario es administrador
            if (datos.esAdmin) {
                document.getElementById('admin-nav-item').style.display = 'block';
            }

            cargarMenu();
        } else {
            // mostrar un mensaje de error si el inicio de sesión falla
            mostrarToast(datos.mensaje, 'error');
        }
    } catch (error) {
        // mostrar un mensaje de error si hay un problema con la conexion
        mostrarToast('Error de conexión: ' + error.message, 'error');
    }
}

async function registrarUsuario() {
    // obtener los valores escritos en los campos de usuario, correo y contraseña
    var nuevoUsuario = document.getElementById('nuevoUsuario').value;
    var nuevoCorreo = document.getElementById('nuevoCorreo').value;
    var nuevaContrasena = document.getElementById('nuevaContrasena').value;

    if (!nuevoUsuario || !nuevoCorreo || !nuevaContrasena) {
        mostrarToast('Todos los campos son obligatorios.', 'error');
        return;
    }

    // expresiones regulares:
    var regexEmail = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
    var regexContrasena = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+{}|:"<>?])[A-Za-z\d!@#$%^&*()_+{}|:"<>?]{8,}$/;

    // que de aviso si esta mal el correo
    if (!regexEmail.test(nuevoCorreo)) {
        mostrarToast('El correo debe tener un formato válido.', 'error');
        return;
    }

    // que de aviso si esta mal la contraseña
    if (!regexContrasena.test(nuevaContrasena)) {
        mostrarToast('La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.', 'error');
        return;
    }

    // crear un objeto con los datos del usuario para enviarlos al servidor
    var datosEnvio = {
        nuevoUsuario: nuevoUsuario, // guardar el nombre de usuario
        nuevoCorreo: nuevoCorreo, // guardar el correo
        nuevaContrasena: nuevaContrasena // guardar la contraseña
    };

    try {
        // enviar los datos al servidor usando una petición HTTP POST
        var respuesta = await fetch('./controladores/RegistrarControlador.php', {
            method: 'POST', // usar el método POST porque estamos enviando datos
            headers: {
                'Content-Type': 'application/json' // indicar que los datos están en formato JSON
            },
            body: JSON.stringify(datosEnvio) // convertir el objeto en JSON y enviarlo
        });

        var datos = await respuesta.json();

        // si el registro fue exitoso
        if (datos.exito) {
            mostrarToast("Registro exitoso", 'exito'); // mostrar mensaje de éxito
            mostrarLogin(); // mostrar el formulario de inicio de sesión
        } else {
            // si hubo un error en el registro, mostrar el mensaje de error
            mostrarToast(datos.mensaje, 'error');
        }
    } catch (error) {
        // si hay un problema con la conexión, mostrar un mensaje de error
        mostrarToast('Error de conexión: ' + error.message, 'error');
    }
}

function enviarCorreoRecuperacion() {
    // guardamos el email que escribio el usuario
    var email = document.getElementById('emailOlvido').value;

    // revisamos si el usuario escribio algo
    if (!email) {
        document.getElementById('mensaje-error-recuperacion').textContent = 'Por favor, ingresa tu correo electrónico.';
        return;
    }

    // enviamos el correo al servidor
    fetch('./PHPMailer/enviarCorreoRecuperacion.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            accion: 'recuperar_contrasena',
            correo: email
        })
    })
        .then(function (response) {
            if (!response.ok) {
                throw new Error('Error HTTP: ' + response.status);
            }
            return response.json();
        })
        .then(function (data) {
            if (data.exito) {
                alert(data.mensaje);
                mostrarLogin();
            } else {
                document.getElementById('mensaje-error-recuperacion').textContent = data.mensaje;
            }
        })
        .catch(function (error) {
            console.error('Error:', error);
            document.getElementById('mensaje-error-recuperacion').textContent = 'Error de red o servidor: ' + error.message;
        });
}

async function cargarMenu() {
    try {
        const respuesta = await fetch('./controladores/ObtenerMenuControlador.php');

        const datos = await respuesta.json();
        const adminItem = document.getElementById('admin-nav-item');

        // si es administrador, se muestra la opcion de poder administrar la pagina o no en el otro caso
        if (datos.esAdmin) {
            adminItem.style.display = 'block';
        } else {
            adminItem.style.display = 'none';
        }

    } catch (error) {
        console.error('Error al cargar el menú:', error);
    }
}

async function cargarMiPerfil(evento) {
    if (evento) {
        evento.preventDefault();
    }

    document.getElementById('pagina-inicio').style.display = 'none';
    document.getElementById('contenidoPerfil').style.display = 'block';
    document.getElementById('contenidoAdministracion').style.display = 'none';
    crearCookie('ultimaPagina', 'perfil', 7);

    // mostrar al usuario en la pagina de mi perfil sus datos
    try {
        var respuesta = await fetch('controladores/ObtenerPerfilControlador.php');
        var datosPerfil = await respuesta.json();
        
        document.getElementById('perfil-usuario-nombre').innerText = datosPerfil.usuario.nombreUsuario;
        document.getElementById('perfil-rol').innerText = datosPerfil.usuario.rol;
        document.getElementById('perfil-email').innerText = datosPerfil.usuario.email;
        document.getElementById('perfil-fecha-registro').innerText = datosPerfil.usuario.fechaRegistro;

    } catch (error) {
        mostrarToast('error al cargar el perfil', 'error');
    }
}

async function obtenerDatos(url) {
    try {
        const respuesta = await fetch(url);
        const datos = await respuesta.json();
        
        if (Array.isArray(datos.data)) {
            return datos.data;
        } else {
            return [];
        }
        
    } catch (error) {
        console.error('Error en obtenerDatos:', error);
        mostrarToast(error.message, 'error');
        return [];
    }
}

async function cargarArtistasAdmin() {
    try {
        // conseguir la informacion de los artistas
        const artistas = await obtenerDatos('./controladores/AdministrarControlador.php?accion=obtener_artistas');

        // titulos de la tabla
        const headers = ['ID', 'Nombre', 'Biografía', 'Fecha de Nacimiento', 'País de Origen', 'Imagen'];

        const tabla = crearTabla(headers, artistas, function (fila, artista) {
            // hacer la celda del id
            const celdaId = document.createElement('td');
            celdaId.textContent = artista.CODARTISTA;
            celdaId.className = 'celda-id';
            fila.appendChild(celdaId);

            // hacer la celda del nombre
            const celdaNombre = document.createElement('td');
            celdaNombre.textContent = artista.NOMBRE;
            celdaNombre.className = 'celda-nombre';
            fila.appendChild(celdaNombre);

            // hacer la celda de la biografia
            const celdaBio = document.createElement('td');
            celdaBio.textContent = artista.BIOGRAFIA || 'Sin biografía';
            celdaBio.className = 'celda-bio';
            fila.appendChild(celdaBio);

            // hacer la celda de la fecha de nacimiento
            const celdaFecha = document.createElement('td');
            celdaFecha.textContent = artista.FECHA_NACIMIENTO;
            celdaFecha.className = 'celda-fecha';
            fila.appendChild(celdaFecha);

            // hacer la celda del pais de origen
            const celdaPais = document.createElement('td');
            celdaPais.textContent = artista.PAIS_ORIGEN;
            celdaPais.className = 'celda-pais';
            fila.appendChild(celdaPais);

            // hacer la celda de la imagen
            const celdaImagen = document.createElement('td');
            celdaImagen.innerHTML = '<img src="' + artista.IMAGEN + '" class="img-tabla">';
            celdaImagen.className = 'celda-imagen';
            fila.appendChild(celdaImagen);
        });

        mostrarTabla('listaArtistasAdmin', tabla);
    } catch (error) {
        console.log(error);
        mostrarToast(error.message, 'error');
    }
}

async function cargarAlbumesAdmin() {
    try {
        // conseguir la informacion de los albumes
        const albumes = await obtenerDatos('./controladores/AdministrarControlador.php?accion=obtener_albumes');

        // titulos de la tabla
        const headers = ['ID', 'Nombre', 'Artista', 'Fecha de Lanzamiento', 'Carátula'];

        const tabla = crearTabla(headers, albumes, function (fila, album) {
            const celdaId = document.createElement('td');
            celdaId.textContent = album.CODALBUM;
            celdaId.className = 'celda-id';
            fila.appendChild(celdaId);

            const celdaNombre = document.createElement('td');
            celdaNombre.textContent = album.NOMBRE;
            celdaNombre.className = 'celda-nombre';
            fila.appendChild(celdaNombre);

            const celdaArtista = document.createElement('td');
            celdaArtista.textContent = album.ARTISTA;
            celdaArtista.className = 'celda-artista';
            fila.appendChild(celdaArtista);

            const celdaFecha = document.createElement('td');
            celdaFecha.textContent = album.FECHA_LANZAMIENTO;
            celdaFecha.className = 'celda-fecha';
            fila.appendChild(celdaFecha);

            const celdaImagen = document.createElement('td');
            celdaImagen.innerHTML = '<img src="' + album.CARATULA + '" class="img-tabla">';
            celdaImagen.className = 'celda-imagen';
            fila.appendChild(celdaImagen);
        });

        mostrarTabla('listaAlbumesAdmin', tabla);
    } catch (error) {
        mostrarToast(error.message, 'error');
    }
}

async function cargarCancionesAdmin() {
    try {
        // conseguir la informacion de las canciones
        const canciones = await obtenerDatos('./controladores/AdministrarControlador.php?accion=obtener_canciones');

        // titulos de la tabla
        const headers = ['ID', 'Nombre', 'Duración', 'Álbum', 'Imagen'];

        const tabla = crearTabla(headers, canciones, function (fila, cancion) {
            const celdaId = document.createElement('td');
            celdaId.textContent = cancion.CODCANCION;
            celdaId.className = 'celda-id';
            fila.appendChild(celdaId);

            const celdaNombre = document.createElement('td');
            celdaNombre.textContent = cancion.NOMBRE;
            celdaNombre.className = 'celda-nombre';
            fila.appendChild(celdaNombre);

            const celdaDuracion = document.createElement('td');
            celdaDuracion.textContent = cancion.DURACION;
            celdaDuracion.className = 'celda-duracion';
            fila.appendChild(celdaDuracion);

            const celdaAlbum = document.createElement('td');
            celdaAlbum.textContent = cancion.NOMBRE_ALBUM;
            celdaAlbum.className = 'celda-album';
            fila.appendChild(celdaAlbum);

            // la de las imagenes
            const celdaImagen = document.createElement('td');
            const rutaImagen = cancion.IMAGEN;
            celdaImagen.innerHTML = '<img src="' + rutaImagen + '" class="img-tabla">';
            celdaImagen.className = 'celda-imagen';
            fila.appendChild(celdaImagen);
        });

        mostrarTabla('listaCancionesAdmin', tabla);
    } catch (error) {
        mostrarToast(error.message, 'error');
    }
}

async function llenarSelectCanciones() {
    const selects = [
        document.getElementById('cancionEliminar'),
        document.getElementById('selectCancionModificar')
    ];

    try {
        // Obtener el array de canciones
        const canciones = await obtenerDatos(
            './controladores/AdministrarControlador.php?accion=obtener_canciones'
        );

        selects.forEach(select => {
            if (!select) return;

            // Limpia y añade opción por defecto
            select.innerHTML = '';
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Seleccione una canción';
            defaultOption.disabled = true;
            defaultOption.selected = true;
            select.appendChild(defaultOption);

            // Rellena con las canciones
            canciones.forEach(cancion => {
                const option = document.createElement('option');
                option.value = cancion.CODCANCION;
                option.textContent = cancion.NOMBRE;
                option.dataset.albumId = cancion.CODALBUM;
                select.appendChild(option);
            });
        });
    } catch (error) {
        console.error('Error al cargar las canciones:', error);
        mostrarToast(error.message, 'error');
    }
}

async function llenarSelectAlbumes() {
    const selects = [
        document.getElementById('albumSeleccionado'),
        document.getElementById('cancionAlbum'),
        document.getElementById('albumModificar'),
        document.getElementById('albumEliminar')
    ];

    try {
        const albumes = await obtenerDatos('./controladores/AdministrarControlador.php?accion=obtener_albumes');

        selects.forEach(select => {
            if (!select) return;

            select.innerHTML = ''; // Limpiar los valores existentes

            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Seleccione un álbum';
            defaultOption.disabled = true;
            defaultOption.selected = true;
            select.appendChild(defaultOption);

            // Si los álbumes existen, llenar los selects
            albumes.forEach(album => {
                const option = document.createElement('option');
                option.value = album.CODALBUM;
                option.textContent = album.NOMBRE;
                select.appendChild(option);
            });
        });

    } catch (error) {
        console.error('Error al cargar los álbumes:', error);
        mostrarToast(error.message, 'error');
    }
}

llenarSelectAlbumes();

async function llenarSelectArtistas() {
    const selects = [
        document.getElementById('artistaAlbum'),
        document.getElementById('artistaAlbumModificar'),
        document.getElementById('selectArtistaModificar')
    ];

    try {
        const artistas = await obtenerDatos('./controladores/AdministrarControlador.php?accion=obtener_artistas');

        selects.forEach(select => {
            if (select) {
                select.innerHTML = '';

                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Seleccione un artista';
                defaultOption.disabled = true;
                defaultOption.selected = true;
                select.appendChild(defaultOption);

                // añadir artistas al select
                artistas.forEach(artista => {
                    const option = document.createElement('option');
                    option.value = artista.CODARTISTA;
                    option.textContent = artista.NOMBRE;
                    select.appendChild(option);
                });
            }
        });
    } catch (error) {
        console.error('Error al cargar los artistas:', error);
        mostrarToast(error.message, 'error');
    }
}

llenarSelectArtistas();

function subirCancion(evento) {
    evento.preventDefault();

    const nombre = document.getElementById('cancionNombre').value;
    const idAlbum = document.getElementById('cancionAlbum').value;
    const duracion = document.getElementById('cancionDuracion').value;
    const archivoAudio = document.getElementById('cancionAudio');
    const archivoImagen = document.getElementById('cancionImagen');

    // si falta algun campo se muestra un mensaje
    if (!nombre || !idAlbum || !duracion) {
        mostrarToast('Por favor complete todos los campos requeridos', 'error');
        return false;
    }

    // si no hay audio se muestra un mensaje
    if (!archivoAudio.files[0]) {
        mostrarToast('Debe seleccionar un archivo de audio', 'error');
        return false;
    }

    const datos = new FormData();
    datos.append('nombre', nombre);
    datos.append('album_id', idAlbum);
    datos.append('duracion', duracion);
    datos.append('accion', 'crear_cancion');

    // si hay imagen se agrega
    if (archivoImagen.files[0]) {
        datos.append('imagen', archivoImagen.files[0]);
    }

    datos.append('archivo_audio', archivoAudio.files[0]);

    mostrarToast('Subiendo canción...', 'info');

    fetch('./controladores/AdministrarControlador.php', {
        method: 'POST',
        body: datos
    })
    .then(respuesta => respuesta.json())
    .then(datos => {
        // si todo sale bien se muestra mensaje
        if (datos.exito) {
            mostrarToast('Canción subida correctamente', 'exito');
            document.getElementById('form-cancion').reset();
            llenarSelectCanciones();
        } else {
            mostrarToast(datos.mensaje || 'Error al subir la canción', 'error');
        }
    })
    .catch(error => {
        mostrarToast('Error al procesar la solicitud: ' + error.message, 'error');
    });

    return false;
}

async function eliminarCancion(evento) {
    evento.preventDefault();

    const idCancion = document.getElementById('cancionEliminar').value;

    // si no se selecciona ninguna cancion se muestra un mensaje
    if (!idCancion) {
        mostrarToast('Por favor, selecciona una canción.', 'error');
        return;
    }

    try {
        const respuesta = await fetch('./controladores/AdministrarControlador.php?accion=eliminar_cancion', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: idCancion })
        });

        const datos = await respuesta.json();

        // si todo sale bien se muestra un mensaje de exito
        if (datos.exito) {
            mostrarToast('Canción eliminada correctamente', 'exito');
            llenarSelectCanciones();
        } else {
            mostrarToast('Error: ' + datos.mensaje, 'error');
        }

    } catch (error) {
        // si algo falla se muestra el error
        mostrarToast('Error al eliminar la canción: ' + error.message, 'error');
    }
}

async function modificarCancion(evento) {
    evento.preventDefault();

    const selectorCancion = document.getElementById('selectCancionModificar');
    const campoNombre = document.getElementById('nombreCancionModificar');
    const campoDuracion = document.getElementById('duracionCancionModificar');
    const campoAudio = document.getElementById('audioCancionModificar');
    const campoImagen = document.getElementById('imagenCancionModificar');
    const formulario = document.getElementById('form-modificar-cancion');

    try {
        const idCancion = selectorCancion.value;
        const nombre = campoNombre.value.trim();
        const duracion = campoDuracion.value;

        // si faltan datos obligatorios se muestra un mensaje
        if (!idCancion || !nombre || !duracion) {
            mostrarToast('Faltan datos obligatorios', 'error');
            return;
        }

        const datosFormulario = new FormData(formulario);
        datosFormulario.set('accion', 'modificar_cancion');
        datosFormulario.set('id', idCancion);
        datosFormulario.set('nombre', nombre);
        datosFormulario.set('duracion', duracion);

        // si hay audio se agrega al formulario
        if (campoAudio.files.length > 0) {
            const archivoAudio = campoAudio.files[0];
            if (archivoAudio.type.startsWith('audio/')) {
                datosFormulario.set('archivo_audio', archivoAudio);
            } else {
                mostrarToast('El archivo de audio no es válido', 'error');
                return;
            }
        }

        // si hay imagen se agrega al formulario
        if (campoImagen.files.length > 0) {
            const archivoImagen = campoImagen.files[0];
            if (archivoImagen.type.startsWith('image/')) {
                datosFormulario.set('imagen', archivoImagen);
            } else {
                mostrarToast('La imagen no es válida', 'error');
                return;
            }
        }

        mostrarToast('Modificando canción...', 'info');

        const respuesta = await fetch('./controladores/AdministrarControlador.php', {
            method: 'POST',
            body: datosFormulario
        });

        const textoPlano = await respuesta.text();
        let datos;

        try {
            datos = JSON.parse(textoPlano);
        } catch (error) {
            mostrarToast('La respuesta del servidor no es válida', 'error');
            return;
        }

        // si todo sale bien se muestra un mensaje
        if (datos.exito) {
            mostrarToast('Canción modificada correctamente', 'exito');
            formulario.reset();
            llenarSelectCanciones();
        } else {
            mostrarToast('Error: ' + datos.mensaje, 'error');
        }

    } catch (error) {
        mostrarToast('Error: ' + error.message, 'error');
    }
}

function añadirAlbum(evento) {
    evento.preventDefault();

    let nombre = document.getElementById('albumNombre').value.trim(); // guarda el nombre del album
    let artista = document.getElementById('artistaAlbum').value; // guarda el artista del album
    let fecha = document.getElementById('albumFechaLanzamiento').value; // guarda la fecha del album
    let imagen = document.getElementById('albumImagen').files[0]; // guarda la imagen del album

    // si falta algo importante, muestra mensaje y se detiene
    if (!nombre || !artista || !fecha || !imagen) {
        mostrarToast('rellene todos los campos', 'error');
        return;
    }

    // se preparan los datos para enviar al servidor
    let datos = new FormData();
    datos.append('accion', 'crear_album');
    datos.append('nombre', nombre);
    datos.append('artista', artista);
    datos.append('fecha', fecha);
    datos.append('imagen', imagen);

    fetch('./controladores/AdministrarControlador.php', {
        method: 'POST',
        body: datos
    })
    .then(respuesta => respuesta.json())
    .then(info => {
        if (info.exito) {
            mostrarToast('álbum añadido', 'exito');
            document.getElementById('form-album').reset();
        } else {
            mostrarToast(info.mensaje, 'error');
        }
    });
}

function eliminarAlbum(evento) {
    evento.preventDefault();

    let id = document.getElementById('albumEliminar').value; // guarda el id del album a eliminar

    // si no se eligio album, muestra mensaje
    if (!id) {
        mostrarToast('seleccione un álbum', 'error');
        return;
    }

    // se preparan los datos para enviar
    let datos = new FormData();
    datos.append('accion', 'eliminar_album');
    datos.append('id', id);

    // se manda al servidor
    fetch('./controladores/AdministrarControlador.php', {
        method: 'POST',
        body: datos
    })
    .then(respuesta => respuesta.json())
    .then(info => {
        if (info.exito) {
            mostrarToast('álbum eliminado', 'exito');
            document.getElementById('form-eliminar-album').reset();
        } else {
            mostrarToast(info.mensaje, 'error');
        }
    });
}
