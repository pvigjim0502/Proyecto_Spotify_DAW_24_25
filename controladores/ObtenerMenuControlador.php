<?php
// esto dice que la respuesta sera en formato json
header('Content-Type: application/json');
// esto muestra los errores si algo sale mal
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/funciones.php';

// funcion para verificar el rol del usuario (admin o usuario)
function verificarRol($rolUsuario) {
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
