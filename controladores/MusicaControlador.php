<?php
// esto dice que la respuesta sera en formato json
header('Content-Type: application/json');
// esto muestra los errores si algo sale mal
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/funciones.php';

function obtenerMusica()
{
    // obtener la conexion
    $db = obtenerConexion();

    try {
        // consulta principal para obtener los albums y sus detalles
        $query = "SELECT a.CODALBUM, a.NOMBRE, a.CARATULA, a.FECHA_LANZAMIENTO, 
                a.CODARTISTA, 
                ar.NOMBRE AS ARTISTA, 
                ar.BIOGRAFIA, 
                ar.FECHA_NACIMIENTO,
                ar.PAIS_ORIGEN,
                ar.IMAGEN AS IMAGEN_ARTISTA
        FROM ALBUM a
        JOIN ARTISTA ar ON a.CODARTISTA = ar.CODARTISTA";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $albums = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // si no se encuentran albums
        if (empty($albums)) {
            return [
                'exito' => false,
                'mensaje' => 'no se encontraron álbumes'
            ];
        }

        // para cada album, obtener las canciones asociadas
        foreach ($albums as &$album) {
            try {
                // consulta para obtener las canciones de cada album
                $querySongs = "SELECT CODCANCION, NOMBRE, DURACION, IMAGEN, AUDIO FROM CANCION WHERE CODALBUM = :album_id";
                $stmt = $db->prepare($querySongs);
                $stmt->bindParam(':album_id', $album['CODALBUM'], PDO::PARAM_INT);
                $stmt->execute();
                $songs = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $album['canciones'] = $songs ?: [];
            } catch (Exception $e) {
                // si hay error al obtener las canciones
                $album['canciones'] = ["error" => "error al obtener canciones: " . $e->getMessage()];
            }
        }

        return [
            'exito' => true,
            'albums' => $albums
        ];
    } catch (Exception $e) {
        // si hay error al ejecutar la consulta principal
        return [
            'exito' => false,
            'mensaje' => 'error: ' . $e->getMessage()
        ];
    }
}

// intentar obtener la musica y devolverla
try {
    $resultado = obtenerMusica();
} catch (Exception $e) {
    // si hay un error critico
    $resultado = [
        'exito' => false,
        'mensaje' => 'error crítico: ' . $e->getMessage()
    ];
}

// devolver la respuesta en formato json
echo json_encode($resultado);
exit;
