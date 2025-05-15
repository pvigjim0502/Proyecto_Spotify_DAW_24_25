function crearCookie(nombre, valor, dias) {
    var fecha = new Date();
    fecha.setTime(fecha.getTime() + (dias * 24 * 60 * 60 * 1000));
    var caducidad = "expires=" + fecha.toUTCString();
    var cookie = nombre + "=" + valor + ";" + caducidad + ";path=/;samesite=Lax";
    document.cookie = cookie;
}

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

function borrarCookie(nombre) {
    document.cookie = nombre + "=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/;samesite=Lax;secure";
}

function cargarUltimaPagina() {
    var ultimaPagina = obtenerCookie('ultimaPagina');

    if (ultimaPagina === 'perfil') {
        document.getElementById('pagina-inicio').style.display = 'none';
        document.getElementById('contenidoPerfil').style.display = 'block';
        cargarMiPerfil();
    } else {
        document.getElementById('contenidoPerfil').style.display = 'none';
        document.getElementById('pagina-inicio').style.display = 'block';
    }
}

window.onload = function () {
    var sesionActiva = obtenerCookie('sesionActiva');

    if (sesionActiva === 'true') {
        document.getElementById('cabecera').style.display = 'block';
        document.getElementById('formularioLogin').style.display = 'none';
        document.getElementById('pieDePagina').style.display = 'block';

        var usuarioNombre = obtenerCookie('usuarioNombre');
        if (usuarioNombre) {
            document.getElementById('usuario-nombre').textContent = usuarioNombre;
        }

        cargarUltimaPagina();
        cargarMenu();
    } else {
        document.getElementById('formularioLogin').style.display = 'block';
        document.getElementById('cabecera').style.display = 'none';
        document.getElementById('pagina-inicio').style.display = 'none';
    }
};
