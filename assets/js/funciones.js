// funcion para mostrar mensajes de aviso en pantalla
function mostrarToast(mensaje, tipo) {
    var configuracion = { icono: '❌', clase: 'bg-danger' };
    var tiposValidos = ['exito', 'error'];

    // revisamos que tipo de mensaje es para poner el icono correcto
    for (var i = 0; i < tiposValidos.length; i++) {
        if (tiposValidos[i] === tipo) {
            if (tipo === 'exito') {
                configuracion = { icono: '✅', clase: 'bg-success' };
            }
            break;
        }
    }

    var toast = document.getElementById('toast-success');
    var clasesToast = toast.classList;

    // quitamos cualquier color de fondo que tenga antes
    for (var j = 0; j < clasesToast.length; j++) {
        if (clasesToast[j].indexOf('bg-') !== -1) {
            toast.classList.remove(clasesToast[j]);
        }
    }

    // ponemos la nueva configuracion
    toast.classList.add(configuracion.clase);
    document.getElementById('toast-icon').textContent = configuracion.icono;
    document.getElementById('toast-text').textContent = mensaje;

    // ponemos la primera letra en mayuscula
    var titulo = tipo.charAt(0).toUpperCase() + tipo.slice(1);
    document.getElementById('toast-title').textContent = titulo + ': ';

    // mostramos el mensaje en pantalla
    new bootstrap.Toast(toast).show();
}

// funcion para enviar correo de recuperacion de contraseña
function enviarCorreoRecuperacion() {
    var email = document.getElementById('emailOlvido').value;
    alert('Correo enviado a ' + email + ' con instrucciones de recuperación.');
}

// funcion para mostrar la pantalla de login
function mostrarLogin() {
    document.getElementById('formularioRegistro').style.display = 'none';
    document.getElementById('formularioLogin').style.display = 'block';
    document.getElementById('formularioOlvidoContrasena').style.display = 'none';
}

// funcion para mostrar la pantalla de registro
function mostrarRegistro() {
    document.getElementById('formularioLogin').style.display = 'none';
    document.getElementById('formularioRegistro').style.display = 'block';
    document.getElementById('formularioOlvidoContrasena').style.display = 'none';
}

// funcion para mostrar la pantalla de olvide mi contraseña
function mostrarOlvidoContrasena() {
    document.getElementById('formularioLogin').style.display = 'none';
    document.getElementById('formularioOlvidoContrasena').style.display = 'block';
    document.getElementById('formularioRegistro').style.display = 'none';
}
