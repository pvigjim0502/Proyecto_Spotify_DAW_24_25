<?php
// esto dice que la respuesta sera en formato json
header('Content-Type: application/json');
// esto muestra los errores si algo sale mal
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/funciones.php';

$db = obtenerConexion();

// funcion para registrar el usuario
function registrarUsuario($data) {
    global $db;

    $respuesta = [
        'exito' => false,
        'mensaje' => ''
    ];

    // si falta algun dato, informar del error al usuario
    if (!isset($data['nuevoUsuario']) || !isset($data['nuevoCorreo']) || !isset($data['nuevaContrasena'])) {
        $respuesta['mensaje'] = 'Faltan datos del formulario';
        return $respuesta;
    }

    $nuevoUsuario = limpiarEntrada($data['nuevoUsuario']); // limpiamos la entrada del usuario
    $nuevoCorreo = limpiarEntrada($data['nuevoCorreo']); // limpiamos la entrada del correo
    $nuevaContrasena = limpiarEntrada($data['nuevaContrasena']); // limpiamos la entrada de la contraseña

    // informar si el usuario no introdujo el usuario y la contraseña
    if (!validarUsuario($nuevoUsuario, $nuevaContrasena)) {
        $respuesta['mensaje'] = 'El nombre de usuario y la contraseña son obligatorios.';
        return $respuesta;
    }

    try {
        // verificar si el nombre de usuario ya está en uso
        $stmt = $db->prepare("SELECT * FROM USUARIOS WHERE NOMBRE_USUARIO = :nombreUsuario");
        $stmt->bindParam(':nombreUsuario', $nuevoUsuario);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $respuesta['mensaje'] = 'El nombre de usuario ya está en uso.';
            return $respuesta;
        }

        // verificar si el correo ya está registrado
        $stmt = $db->prepare("SELECT * FROM USUARIOS WHERE EMAIL = :correo");
        $stmt->bindParam(':correo', $nuevoCorreo);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $respuesta['mensaje'] = 'El correo electrónico ya está registrado.';
            return $respuesta;
        }

        // cifrar la contraseña
        $hashedPassword = password_hash($nuevaContrasena, PASSWORD_DEFAULT);

        // insertar el nuevo usuario
        $stmt = $db->prepare("INSERT INTO USUARIOS (NOMBRE_USUARIO, EMAIL, CONTRASENA) VALUES (:nombreUsuario, :correo, :contrasena)");
        $stmt->bindParam(':nombreUsuario', $nuevoUsuario);
        $stmt->bindParam(':correo', $nuevoCorreo);
        $stmt->bindParam(':contrasena', $hashedPassword);

        // mostrar mensaje de usuario registrado correctamente o si dio algun error
        if ($stmt->execute()) {
            $respuesta['exito'] = true;
            $respuesta['mensaje'] = 'Usuario registrado exitosamente.';
        } else {
            $respuesta['mensaje'] = 'Error al registrar el usuario.';
        }

    } catch (Exception $e) {
        $respuesta['mensaje'] = 'Error de base de datos: ' . $e->getMessage();
    }

    return $respuesta;
}

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

try {
    $resultado = registrarUsuario($data);
} catch (Exception $e) {
    $resultado = [
        'exito' => false,
        'mensaje' => 'Error interno del servidor: ' . $e->getMessage()
    ];
}

echo json_encode($resultado);
exit;
