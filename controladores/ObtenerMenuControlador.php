<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/funciones.php';

function verificarRol($rolUsuario)
{
    // limpiar la entrada del rol
    $rolUsuario = limpiarEntrada($rolUsuario);
    $respuesta = [
        'exito' => false,
        'esAdmin' => false
    ];

    if ($rolUsuario) {
        $respuesta['exito'] = true;
        // si el rol es 'administrador'
        if ($rolUsuario === 'administrador') {
            $respuesta['esAdmin'] = true;
        }
    }

    return $respuesta;
}

try {
    session_start();
    // obtener el rol desde la sesion
    if (isset($_SESSION['rol'])) {
        $rolUsuario = $_SESSION['rol'];
    } else {
        $rolUsuario = null;
    }
    // llamar la funcion de verificacion
    $resultado = verificarRol($rolUsuario);
} catch (Exception $e) {
    // en caso de error
    $resultado = [
        'exito' => false,
        'mensaje' => 'error interno del servidor: ' . $e->getMessage()
    ];
}

// devolver la respuesta en formato json
echo json_encode($resultado);
exit;