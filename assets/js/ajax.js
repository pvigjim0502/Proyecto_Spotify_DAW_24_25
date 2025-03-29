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
