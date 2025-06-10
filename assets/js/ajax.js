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
    var regexContrasena = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+{}|:"<>?.])[A-Za-z\d!@#$%^&*()_+{}|:"<>?.]{8,}$/;

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
    var datosEnvio = new FormData();
    datosEnvio.append('nuevoUsuario', nuevoUsuario); // guardar el nombre de usuario
    datosEnvio.append('nuevoCorreo', nuevoCorreo); // guardar el correo
    datosEnvio.append('nuevaContrasena', nuevaContrasena); // guardar la contraseña

    try {
        // enviar los datos al servidor usando una petición HTTP POST
        var respuesta = await fetch('./controladores/RegistrarControlador.php', {
            method: 'POST', // usar el método POST porque estamos enviando datos
            body: datosEnvio // enviar los datos como FormData
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

async function cerrarSesion() {
    const respuesta = await fetch('./controladores/CerrarSesionControlador.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    });

    const datos = await respuesta.json();

    if (datos.success) {
        borrarCookie('sesionActiva');
        borrarCookie('usuarioNombre');
        borrarCookie('esAdmin');
        borrarCookie('ultimaPagina');

        window.location.href = './index.php';
    } else {
        mostrarToast('Error al cerrar la sesión: ' + datos.error, 'error');
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

async function cargarMusica() {
    const datos = await obtenerDatos('./controladores/MusicaControlador.php');

    if (datos.length > 0) {
        mostrarAlbumes(datos);
    } else {
        const contenedor = document.getElementById('contenedorAlbum');
        contenedor.innerHTML =
            '<div class="col-12">' +
            '<div class="alert alert-danger shadow-sm rounded-4 p-4 text-center" role="alert">' +
            '<i class="bi bi-exclamation-triangle-fill me-2"></i>' +
            'No se pudo cargar la música o no hay álbumes disponibles.' +
            '</div>' +
            '</div>';
    }
}

cargarMusica();

var albumSeleccionadoId = 0;

async function cargarCanciones(albumId) {
    albumSeleccionadoId = albumId;

    const datos = await obtenerDatos('./controladores/MusicaControlador.php');

    // si los datos tienen albums, seguimos
    if (datos.length && datos[0].albums) {
        const todosLosAlbums = datos[0].albums;

        var albumSeleccionado = null;
        for (var i = 0; i < todosLosAlbums.length; i++) {
            if (todosLosAlbums[i].CODALBUM == albumId) {
                albumSeleccionado = todosLosAlbums[i];
                break;
            }
        }

        if (albumSeleccionado) {
            mostrarDetalleAlbum(albumSeleccionado);
        } else {
            mostrarToast('No se encontró el álbum', 'error');
        }
    } else {
        mostrarToast('Error al cargar los datos del álbum', 'error');
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

// funcion para añadir el album
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
        mostrarToast('Seleccione un álbum', 'error');
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

// funcion para modificar el album
function modificarAlbum(evento) {
    evento.preventDefault();

    let id = document.getElementById('albumSeleccionado').value; // guarda el id del album
    let nombre = document.getElementById('albumNombreModificar').value.trim(); // guarda el nuevo nombre
    let artista = document.getElementById('artistaAlbumModificar').value; // guarda el nuevo artista
    let fecha = document.getElementById('albumFechaLanzamientoModificar').value; // guarda la nueva fecha
    let imagen = document.getElementById('imagen').files[0]; // guarda la nueva imagen si hay

    // si falta nombre, artista o id, se muestra mensaje
    if (!id || !nombre || !artista) {
        mostrarToast('Rellene los campos obligatorios', 'error');
        return;
    }

    let datos = new FormData();
    datos.append('accion', 'modificar_album');
    datos.append('id', id);
    datos.append('nombre', nombre);
    datos.append('artista', artista);
    datos.append('fecha', fecha);

    if (imagen) {
    datos.append('imagen', imagen); // si hay imagen nueva, se añade
    }
    
    fetch('./controladores/AdministrarControlador.php', {
        method: 'POST',
        body: datos
    })
    .then(respuesta => respuesta.json())
    .then(info => {
        if (info.exito) {
            mostrarToast('álbum modificado', 'exito');
            document.getElementById('form-modificar-album').reset();
        } else {
            mostrarToast(info.mensaje, 'error');
        }
    });
}

// funcion para cargar artistas en el select de eliminar
async function cargarArtistasParaEliminar() {
    // buscamos el select que tiene el id artistaEliminar
    const selectElement = document.getElementById('artistaEliminar');

    try {
        // pedimos los artistas al archivo php con fetch
        const respuesta = await fetch('./controladores/AdministrarControlador.php?accion=obtener_artistas');
        const datos = await respuesta.json();

        // si todo salio bien y hay datos
        if (datos.exito && datos.data) {
            // ponemos una opcion por defecto para que elija uno
            selectElement.innerHTML = '<option value="" disabled selected>Seleccione un artista</option>';

            // recorremos la lista de artistas
            datos.data.forEach(function(artista) {
                // creamos una opcion nueva
                const opcion = document.createElement('option');
                opcion.value = artista.CODARTISTA;
                opcion.textContent = artista.NOMBRE;
                // metemos la opcion en el select
                selectElement.appendChild(opcion);
            });
        } else {
            // si hubo un problema mostramos mensaje de error
            selectElement.innerHTML = '<option value="" disabled selected>Error al cargar artistas</option>';
            console.error('Error al cargar artistas:', datos.mensaje);
        }
    } catch (error) {
        // si algo fallo con la conexion mostramos mensaje
        selectElement.innerHTML = '<option value="" disabled selected>Error de conexion</option>';
        console.error('Error al cargar artistas para eliminar:', error);
    }
}

// funcion para crear artista
async function crearArtista(evento) {
    // evitamos que la pagina se recargue
    evento.preventDefault();

    // agarramos el formulario y los datos
    const formulario = evento.target;
    const datos = new FormData(formulario);
    datos.append('accion', 'crear_artista');

    // agarramos el boton para desactivarlo mientras se envia
    const boton = formulario.querySelector('button[type="submit"]');
    const textoOriginal = boton.textContent;

    try {
        // desactivamos el boton para que no se pueda hacer click muchas veces
        boton.disabled = true;

        // mandamos los datos al servidor
        const respuesta = await fetch('./controladores/AdministrarControlador.php', {
            method: 'POST',
            body: datos
        });

        // leemos la respuesta del servidor
        const resultado = await respuesta.json();

        // si todo salio bien
        if (resultado.exito) {
            mostrarToast('Artista creado correctamente', 'exito');
            formulario.reset();

            // actualizamos las listas
            await cargarArtistasParaEliminar();
            await llenarSelectArtistas();
            await cargarArtistasAdmin();
        } else {
            mostrarToast(resultado.mensaje || 'Error al crear artista', 'error');
        }

        // volvemos a activar el boton
        boton.disabled = false;
        boton.textContent = textoOriginal;

    } catch (error) {
        // mostramos error si algo falla
        console.error('error en crearArtista:', error);
        mostrarToast('Error al comunicarse con el servidor', 'error');

        // si hay error tambien volvemos a activar el boton
        boton.disabled = false;
        boton.textContent = textoOriginal;
    }

    return false;
}

// funcion para modificar artista
async function modificarArtista(evento) {
    // evitamos que se recargue la pagina
    evento.preventDefault();

    // agarramos los campos necesarios
    const id = document.getElementById('selectArtistaModificar')?.value;
    const nombre = document.getElementById('nombreArtistaModificar')?.value.trim();
    const imagen = document.getElementById('imagenArtistaModificar');
    const formulario = document.getElementById('form-modificar-artista');

    // si falta id o nombre, no seguimos
    if (!id || !nombre) {
        mostrarToast('complete los campos obligatorios', 'error');
        return;
    }

    try {
        const datos = new FormData(formulario);
        datos.append('accion', 'modificar_artista');

        // si hay imagen nueva y es valida la agregamos
        if (imagen && imagen.files && imagen.files.length > 0) {
            const archivo = imagen.files[0];
            const tipo = archivo.type;
        
            let esImagen = true;
            const texto = "image/";
        
            for (let i = 0; i < texto.length; i++) {
                if (tipo[i] !== texto[i]) {
                    esImagen = false;
                    break;
                }
            }
        
            if (esImagen) {
                datos.append('imagenArtista', archivo);
            }
        }

        const respuesta = await fetch('./controladores/AdministrarControlador.php', {
            method: 'POST',
            body: datos
        });

        const resultado = await respuesta.json();

        if (resultado.exito) {
            mostrarToast('artista modificado', 'exito');
            formulario.reset();
            const artistas = await obtenerDatos('./controladores/AdministrarControlador.php?accion=obtener_artistas');
            mostrarArtistas(artistas);
        } else {
            if (resultado.mensaje) {
                mostrarToast(resultado.mensaje, 'error');
            } else {
                mostrarToast('Error al modificar', 'error');
            }
        }
    } catch (error) {
        mostrarToast('Error al comunicarse con el servidor', 'error');
    }
}

// funcion para eliminar artista
async function eliminarArtista(evento) {
    evento.preventDefault();

    const id = document.getElementById('artistaEliminar').value;
    if (!id) {
        mostrarToast('seleccione un artista', 'error');
        return;
    }

    try {
        const datos = new FormData();
        datos.append('accion', 'eliminar_artista');
        datos.append('id', id);

        const respuesta = await fetch('./controladores/AdministrarControlador.php', {
            method: 'POST',
            body: datos
        });

        const resultado = await respuesta.json();

        if (resultado.exito) {
            mostrarToast('artista eliminado', 'exito');
            document.getElementById('form-eliminar-artista').reset();
            await cargarArtistasParaEliminar();
            await cargarArtistasAdmin();
        } else {
            if (resultado.mensaje) {
                mostrarToast(resultado.mensaje, 'error');
            } else {
                mostrarToast('error al eliminar', 'error');
            }
        }
    } catch (error) {
        mostrarToast('error: ' + error.message, 'error');
    }
}

// esta variable guarda la ultima palabra que escribio el usuario para buscar
// asi cuando el usuario escribe la misma palabra otra vez no hace la busqueda otra vez
let ultimaBusqueda = '';

// funcion para buscar todo lo que escriba el usuario y mostrar resultados
async function buscarTodo() {
    const inputBusqueda = document.getElementById('buscar');
    const resultadosBusqueda = document.getElementById('resultadosBusqueda');
    const contenedorResultados = document.getElementById('contenedorResultados');
    const termino = inputBusqueda.value.trim();

    // si la palabra que escribio el usuario es menor que 2 no se busca
    if (termino.length < 2) {
        resultadosBusqueda.style.display = 'none';
        return;
    }

    // evitar busquedas duplicadas del mismo término
    if (termino === ultimaBusqueda) {
        return;
    }
    ultimaBusqueda = termino;

    try {
        // mostrar el cargando resultados
        contenedorResultados.innerHTML = `
            <div class="text-center py-3">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Buscando...</span>
                </div>
                <p class="mt-2 mb-0 text-light">Buscando "${termino}"...</p>
            </div>
        `;
        resultadosBusqueda.style.display = 'block';

        // crear la url con el termino para buscar en el servidor
        const url = `./controladores/BuscarControlador.php?termino=${encodeURIComponent(termino)}`;
        const respuesta = await fetch(url);

        const datos = await respuesta.json();

        if (datos.exito) {
            mostrarResultados(datos, termino);
        } else {
            mostrarError(datos.mensaje || 'Error en la búsqueda');
        }
    } catch (error) {
        mostrarError(`Error al realizar la búsqueda: ${error.message}`);
    }
}

function mostrarResultados(datos, termino) {
    const contenedorResultados = document.getElementById('contenedorResultados');
    let html = '';

    // mostrar canciones encontradas, si hay canciones
    if (datos.canciones && datos.canciones.length > 0) {
        html = `
        <div class="mb-3">
            <h6 class="fw-bold mb-2 text-light">Canciones</h6>
            <ul class="list-unstyled">
        `;
        for (let i = 0; i < datos.canciones.length; i++) {
            let cancion = datos.canciones[i];
            html += `
                <li class="search-result-item">
                    <a href="#" onclick="cargarCancionDesdeBusqueda(${cancion.CODALBUM}, ${cancion.CODCANCION}); return false;"
                       class="text-decoration-none text-light">
                        <div class="d-flex align-items-center">
                            <img src="${cancion.IMAGEN}"
                                 alt="${cancion.NOMBRE}"
                                 class="rounded me-3 search-item-image"
                                 style="object-fit: cover;">
                            <div>
                                <p class="mb-0 fw-bold search-item-title">${resaltarTermino(cancion.NOMBRE, termino)}</p>
                                <small class="text-muted search-item-subtitle">
                                    ${resaltarTermino(cancion.ARTISTA, termino)} - ${resaltarTermino(cancion.ALBUM, termino)}
                                </small>
                            </div>
                        </div>
                    </a>
                </li>
            `;
        }
        html += `
            </ul>
        </div>
        `;
    }

    // mostrar albumes encontrados, si hay albumes
    if (datos.albumes && datos.albumes.length > 0) {
        html += `
        <div class="mb-3">
            <h6 class="fw-bold mb-2 text-light">Álbumes</h6>
            <div class="row g-2">
        `;
        for (let i = 0; i < datos.albumes.length; i++) {
            let album = datos.albumes[i];
            html += `
                <div class="col-6 col-md-4">
                    <a href="#" onclick="cargarCanciones(${album.CODALBUM}); return false;"
                       class="text-decoration-none search-album-link">
                        <div class="card border-0 bg-transparent search-album-card">
                            <img src="${album.CARATULA}"
                                 alt="${album.NOMBRE}"
                                 class="card-img-top rounded shadow-sm"
                                 style="aspect-ratio: 1/1; object-fit: cover;">
                            <div class="card-body px-0 py-2">
                                <h6 class="card-title mb-0 text-truncate">${resaltarTermino(album.NOMBRE, termino)}</h6>
                                <small class="text-muted">${resaltarTermino(album.ARTISTA, termino)}</small>
                            </div>
                        </div>
                    </a>
                </div>
            `;
        }
        html += `
            </div>
        </div>
        `;
    }

    // mostrar artistas encontrados, si hay artistas
    if (datos.artistas && datos.artistas.length > 0) {
        html += `
        <div class="mb-2">
            <h6 class="fw-bold mb-2 text-light">Artistas</h6>
            <div class="d-flex flex-wrap gap-3">
        `;
        for (let i = 0; i < datos.artistas.length; i++) {
            let artista = datos.artistas[i];
            html += `
                <a href="#" onclick="cargarArtistaDesdeBusqueda(${artista.CODARTISTA}); return false;"
                   class="text-decoration-none text-center search-artist-link" style="width: 80px;">
                    <div class="rounded-circle overflow-hidden mb-2 search-artist-image-container">
                        <img src="${artista.IMAGEN}"
                             alt="${artista.NOMBRE}"
                             class="w-100 h-100 object-fit-cover">
                    </div>
                    <p class="mb-0 small text-truncate text-light">${resaltarTermino(artista.NOMBRE, termino)}</p>
                </a>
            `;
        }
        html += `
            </div>
        </div>
        `;
    }

    // mostrar mensaje si no hay resultados
    if (html === '') {
        html = `
        <div class="text-center py-4 text-light">
            <i class="fas fa-search fa-2x mb-3 text-muted"></i>
            <p class="mb-0">No se encontraron resultados para "${termino}"</p>
            <small class="text-muted">intenta con otros terminos de busqueda</small>
        </div>
        `;
    }

    contenedorResultados.innerHTML = html;
}

function mostrarError(mensaje) {
    const contenedorResultados = document.getElementById('contenedorResultados');
    contenedorResultados.innerHTML = `
        <div class="alert alert-danger mb-0">
            <i class="fas fa-exclamation-circle me-2"></i>
            ${mensaje}
        </div>
    `;
}

function resaltarTermino(texto, termino) {
    if (!texto || !termino) {
        return texto;
    } else {
        const regex = new RegExp(`(${termino})`, 'gi'); // la g significa global y la i significa que es indiferente a mayusculas y minusculas
        return texto.replace(regex, '<span class="fw-bold text-primary">$1</span>');
    }
}

function limpiarBusqueda() {
    document.getElementById('buscar').value = '';
    document.getElementById('resultadosBusqueda').style.display = 'none';
    ultimaBusqueda = '';
}

document.addEventListener('click', function (event) {
    const buscador = document.getElementById('buscador');
    const resultados = document.getElementById('resultadosBusqueda');

    if (!buscador.contains(event.target)) {
        resultados.style.display = 'none';
    }
});

function cargarCancionDesdeBusqueda(albumId) {
    cargarCanciones(albumId);
    document.getElementById('resultadosBusqueda').style.display = 'none';
}

// funcion modificada para cargar artista desde busqueda
function cargarArtistaDesdeBusqueda(codArtista) {
    // ocultar resultados de busqueda
    document.getElementById('resultadosBusqueda').style.display = 'none';

    // llamar a la funcion de carga de detalle
    cargarDetalleArtista(codArtista);
}
