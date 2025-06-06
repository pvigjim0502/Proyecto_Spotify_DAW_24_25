<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__ . '/../includes/db.php';
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$db = obtenerConexion();

function generarContrasenaAleatoria($longitud = 8)
{
    // estos son los caracteres que puede tener la contrasena
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $caracteresEspeciales = '!@#$%^&*()_+{}|:"<>?.';

    // se combinan todos los caracteres disponibles
    $todosLosCaracteres = $caracteres . $caracteresEspeciales;
    $contrasena = '';

    // se repite hasta que la contrasena tenga la longitud que queremos
    for ($i = 0; $i < $longitud; $i++) {
        // se elige un caracter al azar y se agrega a la contrasena
        $numero = rand(0, strlen($todosLosCaracteres) - 1);
        $contrasena .= $todosLosCaracteres[$numero];
    }

    return $contrasena;
}

function recuperarContrasena($correo)
{
    global $db;
    $respuesta = ['exito' => false, 'mensaje' => ''];

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $respuesta['mensaje'] = 'Correo electronico invalido';
        return $respuesta;
    }

    try {
        // se busca al usuario por correo
        $stmtUsuario = $db->prepare("SELECT NOMBRE_USUARIO FROM USUARIOS WHERE EMAIL = ?");
        $stmtUsuario->execute([$correo]);
        $usuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            $respuesta['mensaje'] = 'No se encontro un usuario con ese correo electronico.';
            return $respuesta;
        }

        $nombreUsuario = $usuario['NOMBRE_USUARIO'];

        // se genera y guarda la nueva contraseña
        $nuevaContrasena = generarContrasenaAleatoria();
        $hashedPassword = password_hash($nuevaContrasena, PASSWORD_DEFAULT);

        $stmt = $db->prepare("UPDATE USUARIOS SET CONTRASENA = ? WHERE EMAIL = ?");
        $stmt->execute([$hashedPassword, $correo]);

    } catch (Exception $e) {
        $respuesta['mensaje'] = 'Error al actualizar la contrasena: ' . $e->getMessage();
        return $respuesta;
    }

    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'espacioextra8@gmail.com';
        $mail->Password = 'uhhb wkxy vxvy twqh';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('espacioextra8@gmail.com', 'Novamelody');
        $mail->addAddress($correo);

        $mail->Subject = '🔐 Recuperación de Contraseña - Novamelody';

        $mail->isHTML(true);
        $mail->Body = "
            Hola <strong>$nombreUsuario</strong>,<br><br>
            Tu nueva contraseña es: <strong>$nuevaContrasena</strong><br><br>
            Por favor, cámbiala lo antes posible.<br><br>
        ";
        $mail->AltBody = "Hola $nombreUsuario,\n\nTu nueva contraseña es: $nuevaContrasena\n\nPor favor, cámbiala lo antes posible.";

        $mail->send();
        $respuesta['exito'] = true;
        $respuesta['mensaje'] = 'Se ha enviado la nueva contraseña a tu correo electrónico.';

    } catch (Exception $e) {
        $respuesta['mensaje'] = 'Error al enviar el correo: ' . $mail->ErrorInfo;
    }

    return $respuesta;
}

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

if (isset($data['accion']) && $data['accion'] === 'recuperar_contrasena' && isset($data['correo'])) {
    $resultado = recuperarContrasena($data['correo']);
} else {
    $resultado = ['exito' => false, 'mensaje' => 'Parámetros inválidos'];
}

echo json_encode($resultado);
exit;
