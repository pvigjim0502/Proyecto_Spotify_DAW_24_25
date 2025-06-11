<?php
// esto dice que la respuesta sera en formato json
header('Content-Type: application/json');
session_start();
// eliminar todas las variables almacenadas en la sesion
session_unset();
// destruir la sesion
session_destroy();

echo json_encode(["success" => true]);
exit;
