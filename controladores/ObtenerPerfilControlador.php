<?php
// esto dice que la respuesta sera en formato json
header('Content-Type: application/json');
// esto muestra los errores si algo sale mal
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/funciones.php';

$db = obtenerConexion();

function obtenerDatosUsuario($nombreUsuario)
{
    global $db;

    // limpiar la entrada del nombre de usuario
    $nombreUsuario = limpiarEntrada($nombreUsuario);

    // preparar la consulta para obtener datos del usuario
    try {
        $stmt = $db->prepare("SELECT NOMBRE_USUARIO, ROL, EMAIL, FECHA_REGISTRO FROM usuarios WHERE NOMBRE_USUARIO = :nombreUsuario");
        $stmt->bindParam(':nombreUsuario', $nombreUsuario, PDO::PARAM_STR);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            return [
                'exito' => true,
                'usuario' => [
                    'nombreUsuario' => $usuario['NOMBRE_USUARIO'],
                    'rol' => $usuario['ROL'],
                    'email' => $usuario['EMAIL'],
                    'fechaRegistro' => $usuario['FECHA_REGISTRO']
                ]
            ];
        } else {
            return [
                'exito' => false,
                'mensaje' => 'usuario no encontrado'
            ];
        }
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return [
            'exito' => false,
            'mensaje' => 'error al consultar la base de datos'
        ];
    }
}

// iniciar la sesión
session_start();

// verificar si el usuario esta autenticado
if (!isset($_SESSION['nombre_usuario'])) {
    echo json_encode(['exito' => false, 'mensaje' => 'no autorizado']);
    exit;
}

try {
    // obtener los datos del usuario desde la sesión
    $resultado = obtenerDatosUsuario($_SESSION['nombre_usuario']);
} catch (Exception $e) {
    // manejar errores internos
    $resultado = [
        'exito' => false,
        'mensaje' => 'error interno del servidor: ' . $e->getMessage()
    ];
}

// devolver los resultados en formato json
echo json_encode($resultado);
exit;
