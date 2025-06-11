<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once dirname(__FILE__) . '/../includes/db.php';
require_once dirname(__FILE__) . '/../includes/funciones.php';

// obtener la conexion
$db = obtenerConexion();

// funcion para obtener los artistas
function obtenerArtistas() {
    global $db;
    try {
        // hacemos la consulta a la base de datos
        $query = "SELECT * FROM ARTISTA";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $artistas = $stmt->fetchAll(PDO::FETCH_ASSOC); // obtenemos la consulta

        // verificamos los datos de la consulta
        if (empty($artistas)) {
            return [
                'exito' => false,
                'mensaje' => 'No se encontraron artistas'
            ];
        }

        return [
            'exito' => true,    
            'artistas' => $artistas
        ];
    } catch (Exception $e) {
        return [
            'exito' => false,
            'mensaje' => 'Error: ' . $e->getMessage()
        ];
    }
}

try {
    // llamada a la funcion para obtener artistas
    $resultado = obtenerArtistas();
} catch (Exception $e) {
    $resultado = [
        'exito' => false,
        'mensaje' => 'Error crítico: ' . $e->getMessage()
    ];
}

echo json_encode($resultado);
exit;
