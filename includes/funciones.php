<?php
function limpiarEntrada($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function validarUsuario($nombreUsuario, $contrasena)
{
    if (empty($nombreUsuario) || empty($contrasena)) {
        return false;
    }
    return true;
}