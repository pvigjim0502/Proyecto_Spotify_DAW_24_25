// función para crear una cookie con un nombre, valor y tiempo de caducidad en días
// recibe el nombre, valor y los días para establecer la cookie
// establece la caducidad y otras opciones como el path y el sameSite
// al final guarda la cookie en el documento
function crearCookie(nombre, valor, dias) {
    var fecha = new Date();
    fecha.setTime(fecha.getTime() + (dias * 24 * 60 * 60 * 1000));
    var caducidad = "expires=" + fecha.toUTCString();
    var cookie = nombre + "=" + valor + ";" + caducidad + ";path=/;samesite=Lax";
    document.cookie = cookie;
}

// función para obtener una cookie por su nombre
// recorre todas las cookies almacenadas y devuelve el valor si encuentra la cookie
function obtenerCookie(nombre) {
    const cookies = document.cookie.split(';');
    for (let i = 0; i < cookies.length; i++) {
        let cookie = cookies[i].trim();
        if (cookie.startsWith(nombre + "=")) {
            return cookie.substring(nombre.length + 1);
        }
    }
    return null;
}

// función para borrar una cookie por su nombre
// establece la fecha de expiración en el pasado para eliminarla
function borrarCookie(nombre) {
    document.cookie = nombre + "=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/;samesite=Lax;secure";
}

// función para iniciar sesión con nombre de usuario y contraseña
// verifica si los campos están completos y hace una solicitud al servidor
// si la autenticación es correcta, guarda cookies y muestra la página de inicio
async function iniciarSesion() {
    var nombreUsuario = document.getElementById('nombreUsuario').value.trim();
    var contrasena = document.getElementById('contrasena').value.trim();

    if (!nombreUsuario || !contrasena) {
        mostrarToast('Por favor, completa todos los campos.', 'error');
        return;
    }

    try {
        var formData = new FormData();
        formData.append('nombreUsuario', nombreUsuario);
        formData.append('contrasena', contrasena);

        var respuesta = await fetch('./controladores/LoginControlador.php', {
            method: 'POST',
            body: formData
        });

        if (!respuesta.ok) {
            throw new Error('Error en la red: ' + respuesta.statusText);
        }

        var datos = await respuesta.json();

        if (datos.exito) {
            mostrarToast("Inicio de sesión exitoso", 'exito');
            crearCookie('sesionActiva', 'true', 7);
            crearCookie('usuarioNombre', nombreUsuario, 7);
            crearCookie('esAdmin', datos.esAdmin ? 'true' : 'false', 7);

            document.getElementById('formularioLogin').style.display = 'none';
            document.getElementById('cabecera').style.display = 'block';
            document.getElementById('pagina-inicio').style.display = 'block';
            document.getElementById('usuario-nombre').textContent = nombreUsuario;
            document.getElementById('pieDePagina').style.display = 'block';

            if (datos.esAdmin) {
                document.getElementById('admin-nav-item').style.display = 'block';
            }

            cargarMenu();
        } else {
            mostrarToast(datos.mensaje, 'error');
        }
    } catch (error) {
        mostrarToast('Error de conexión: ' + error.message, 'error');
    }
}

// función para registrar un nuevo usuario
// valida el correo y la contraseña antes de enviar los datos al servidor
// si el registro es exitoso, muestra un mensaje de éxito y oculta el formulario de registro
async function registrarUsuario() {
    var nuevoUsuario = document.getElementById('nuevoUsuario').value;
    var nuevoCorreo = document.getElementById('nuevoCorreo').value;
    var nuevaContrasena = document.getElementById('nuevaContrasena').value;

    if (!nuevoUsuario || !nuevoCorreo || !nuevaContrasena) {
        mostrarToast('Todos los campos son obligatorios.', 'error');
        return;
    }

    var regexEmail = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
    var regexContrasena = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+{}|:"<>?])[A-Za-z\d!@#$%^&*()_+{}|:"<>?]{8,}$/;

    if (!regexEmail.test(nuevoCorreo)) {
        mostrarToast('El correo debe tener un formato válido.', 'error');
        return;
    }

    if (!regexContrasena.test(nuevaContrasena)) {
        mostrarToast('La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.', 'error');
        return;
    }

    var datosEnvio = {
        nuevoUsuario: nuevoUsuario,
        nuevoCorreo: nuevoCorreo,
        nuevaContrasena: nuevaContrasena
    };

    try {
        var respuesta = await fetch('./controladores/RegistrarControlador.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(datosEnvio)
        });

        if (respuesta.status !== 200) {
            mostrarToast('Error HTTP: ' + respuesta.status, 'error');
            return;
        }

        var datos = await respuesta.json();

        if (datos.exito) {
            mostrarToast("Registro exitoso", 'exito');
            mostrarLogin();
        } else {
            mostrarToast(datos.mensaje, 'error');
        }
    } catch (error) {
        mostrarToast('Error de conexión: ' + error.message, 'error');
    }
}

// función para enviar un correo de recuperación de contraseña
// obtiene el correo desde el formulario y hace una solicitud al servidor para enviar el correo de recuperación
// muestra mensajes dependiendo del éxito o error
function enviarCorreoRecuperacion() {
    var email = document.getElementById('emailOlvido').value;

    if (!email) {
        document.getElementById('mensaje-error-recuperacion').textContent = 'Por favor, ingresa tu correo electrónico.';
        return;
    }

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
        .then(response => {
            if (!response.ok) {
                throw new Error('Error HTTP: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (data.exito) {
                alert(data.mensaje);
                mostrarLogin();
            } else {
                document.getElementById('mensaje-error-recuperacion').textContent = data.mensaje;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('mensaje-error-recuperacion').textContent = 'Error de red o servidor: ' + error.message;
        });
}

function mostrarLogin() {
    document.getElementById('formularioRegistro').style.display = 'none';
    document.getElementById('formularioLogin').style.display = 'block';
    document.getElementById('formularioOlvidoContrasena').style.display = 'none';
}

function mostrarRegistro() {
    document.getElementById('formularioLogin').style.display = 'none';
    document.getElementById('formularioRegistro').style.display = 'block';
    document.getElementById('formularioOlvidoContrasena').style.display = 'none';
}

function mostrarOlvidoContrasena() {
    document.getElementById('formularioLogin').style.display = 'none';
    document.getElementById('formularioOlvidoContrasena').style.display = 'block';
    document.getElementById('formularioRegistro').style.display = 'none';
}