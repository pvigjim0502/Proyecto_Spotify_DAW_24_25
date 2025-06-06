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

function generarContrasenaAleatoria($longitud = 10)
{
    // estos son los caracteres que puede tener la contrasena
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $contrasena = '';

    // se repite hasta que la contrasena tenga la longitud que queremos
    for ($i = 0; $i < $longitud; $i++) {
        // se elige un caracter al azar y se agrega a la contrasena
        $numero = rand(0, strlen($caracteres) - 1);
        $contrasena = $contrasena . $caracteres[$numero];
    }

    return $contrasena;
}

function recuperarContrasena($correo)
{
    global $db;

    $respuesta = ['exito' => false, 'mensaje' => ''];

    // si el correo no es valido se envia un mensaje
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $respuesta['mensaje'] = 'Correo electronico invalido';
        return $respuesta;
    }

    // se crea la nueva contrasena
    $nuevaContrasena = generarContrasenaAleatoria();

    // se encripta la nueva contrasena
    $hashedPassword = password_hash($nuevaContrasena, PASSWORD_DEFAULT);

    try {
        // se cambia la contrasena en la base de datos
        $stmt = $db->prepare("UPDATE USUARIOS SET CONTRASENA = ? WHERE EMAIL = ?");
        $stmt->execute([$hashedPassword, $correo]);

        // si no se encontro el correo se envia un mensaje
        if ($stmt->rowCount() === 0) {
            $respuesta['mensaje'] = 'No se encontro un usuario con ese correo electronico.';
            return $respuesta;
        }
    } catch (Exception $e) {
        // si algo sale mal al cambiar la contrasena se muestra un error
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

        $mail->setFrom('espacioextra8@gmail.com', 'Novamelody Proyecto');

        $mail->addAddress($correo);

        $mail->Subject = '🔐 Recuperacion de Contrasena - Novamelody Proyecto';

        // el mensaje del correo con html
        $mail->isHTML(true);
        $mail->Body = "Hola,<br><br>Tu nueva contrasena es: <strong>$nuevaContrasena</strong><br><br>Por favor, cambiala lo antes posible.";
        $mail->AltBody = "Hola,\n\nTu nueva contrasena es: $nuevaContrasena\n\nPor favor, cambiala lo antes posible.";

        $mail->send();

        // si se envio bien se cambia la respuesta a exito
        $respuesta['exito'] = true;
        $respuesta['mensaje'] = 'Se ha enviado la nueva contrasena a tu correo electronico.';
    } catch (Exception $e) {
        // si hubo error al mandar el correo se muestra un mensaje
        $respuesta['mensaje'] = 'Error al enviar el correo: ' . $mail->ErrorInfo;
    }

    // se devuelve la respuesta
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
