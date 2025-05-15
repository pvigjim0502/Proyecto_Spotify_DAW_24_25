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