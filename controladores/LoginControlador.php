<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/funciones.php';

function procesarLogin()
{
    try {
        $nombreUsuario = '';
        if (isset($_POST['nombreUsuario'])) {
            $nombreUsuario = limpiarEntrada($_POST['nombreUsuario']);
        }

        $contrasena = '';
        if (isset($_POST['contrasena'])) {
            $contrasena = limpiarEntrada($_POST['contrasena']);
        }

        if (!validarUsuario($nombreUsuario, $contrasena)) {
            return [
                'exito' => false,
                'mensaje' => 'Por favor, complete todos los campos'
            ];
        }

        $db = obtenerConexion();
        $stmt = $db->prepare('SELECT * FROM USUARIOS WHERE NOMBRE_USUARIO = ?');
        $stmt->execute([$nombreUsuario]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            return [
                'exito' => false,
                'mensaje' => 'Usuario no encontrado'
            ];
        }

        if (!password_verify($contrasena, $usuario['CONTRASENA'])) {
            return [
                'exito' => false,
                'mensaje' => 'Contraseña incorrecta'
            ];
        }

        session_start();
        $_SESSION['id_usuario'] = $usuario['ID'];
        $_SESSION['nombre_usuario'] = $usuario['NOMBRE_USUARIO'];
        $_SESSION['rol'] = $usuario['ROL'];

        setcookie('sesionActiva', 'true', time() + (7 * 24 * 60 * 60), "/");
        setcookie('usuarioNombre', $usuario['NOMBRE_USUARIO'], time() + (7 * 24 * 60 * 60), "/");

        return [
            'exito' => true,
            'mensaje' => 'Login exitoso',
            'usuario' => [
                'nombreUsuario' => $usuario['NOMBRE_USUARIO'],
                'rol' => $usuario['ROL']
            ]
        ];
    } catch (Exception $e) {
        return [
            'exito' => false,
            'mensaje' => 'Error al procesar la solicitud: ' . $e->getMessage()
        ];
    }
}

// procesamos el login
try {
    $resultado = procesarLogin();
} catch (Exception $e) {
    $resultado = [
        'exito' => false,
        'mensaje' => 'Error interno del servidor: ' . $e->getMessage()
    ];
}

echo json_encode($resultado);
exit;
