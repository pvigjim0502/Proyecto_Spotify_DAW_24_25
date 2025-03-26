<?php
require_once __DIR__ . '/config.php';

function obtenerConexion()
{
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NOMBRE . ";charset=" . CHARSET;
        $conexion = new PDO($dsn, DB_USUARIO, DB_CONTRASENA);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;
    } catch (PDOException $e) {
        throw new Exception('Error de conexión a la base de datos: ' . $e->getMessage());
    }
}
