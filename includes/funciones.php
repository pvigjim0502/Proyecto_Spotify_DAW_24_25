<?php
// funcion para limpiar la entrada de datos
function limpiarEntrada($data) {
    $data = trim($data); // quitar espacios en blanco
    $data = stripslashes($data); // quitar barras invertidas o comillas
    $data = htmlspecialchars($data); // los caracteres especiales los convierte directamente a HTML
    return $data;
}

// funcion para validar el usuario y la contraseña
function validarUsuario($nombreUsuario, $contrasena) {
    // si alguno de estos campos esta vacio dará un error
    if (empty($nombreUsuario) || empty($contrasena)) {
        return false;
    }
    return true;
}
