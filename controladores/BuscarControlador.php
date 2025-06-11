<?php
// esto dice que la respuesta sera en formato json
header('Content-Type: application/json');
// esto muestra los errores si algo sale mal
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/funciones.php';

// funcion para la barra de búsquedas, para los terminos escritos
function buscarEnBaseDeDatos($termino) {
    $db = obtenerConexion();
    // manera rapida y de abreviar el like del mysql en la busqueda
    $terminoBusqueda = '%' . $termino . '%';

    try {
        // buscar albumes que hay en la base de datos
        $queryAlbumes = "SELECT a.CODALBUM, a.NOMBRE, a.CARATULA, a.CODARTISTA, ar.NOMBRE AS ARTISTA
                        FROM ALBUM a
                        JOIN ARTISTA ar ON a.CODARTISTA = ar.CODARTISTA
                        WHERE a.NOMBRE LIKE :termino OR ar.NOMBRE LIKE :termino
                        ORDER BY a.NOMBRE
                        LIMIT 5";

        $stmtAlbumes = $db->prepare($queryAlbumes);
        $stmtAlbumes->bindParam(':termino', $terminoBusqueda);
        $stmtAlbumes->execute();
        $albumes = $stmtAlbumes->fetchAll(PDO::FETCH_ASSOC);

        // buscar las canciones que hay en la base de datos
        $queryCanciones = "SELECT c.CODCANCION, c.NOMBRE, c.IMAGEN, c.CODALBUM, a.NOMBRE AS ALBUM, ar.NOMBRE AS ARTISTA
                                FROM CANCION c
                                JOIN ALBUM a ON c.CODALBUM = a.CODALBUM
                                JOIN ARTISTA ar ON a.CODARTISTA = ar.CODARTISTA
                                WHERE c.NOMBRE LIKE :termino
                                   OR a.NOMBRE LIKE :termino
                                   OR ar.NOMBRE LIKE :termino
                                ORDER BY c.NOMBRE
                                LIMIT 5";

        $stmtCanciones = $db->prepare($queryCanciones);
        $stmtCanciones->bindParam(':termino', $terminoBusqueda);
        $stmtCanciones->execute();
        $canciones = $stmtCanciones->fetchAll(PDO::FETCH_ASSOC);

        // buscar los artistas que haya en la base de datos
        $queryArtistas = "SELECT CODARTISTA, NOMBRE, IMAGEN
                                FROM ARTISTA
                                WHERE NOMBRE LIKE :termino
                                ORDER BY NOMBRE
                                LIMIT 5";

        $stmtArtistas = $db->prepare($queryArtistas);
        $stmtArtistas->bindParam(':termino', $terminoBusqueda);
        $stmtArtistas->execute();
        $artistas = $stmtArtistas->fetchAll(PDO::FETCH_ASSOC);

        return [
            'exito' => true,
            'albumes' => $albumes,
            'canciones' => $canciones,
            'artistas' => $artistas
        ];

    } catch (PDOException $e) {
        error_log("Error en la base de datos para el término '$termino': " . $e->getMessage());
        return [
            'exito' => false,
            'mensaje' => 'Error en la base de datos: ' . $e->getMessage()
        ];
    }
}

// se consigue el texto que el usuario escribio para buscar
$termino = isset($_GET['termino']) ? trim($_GET['termino']) : '';

// si no escribio nada se manda un mensaje de error
if (empty($termino)) {
    $respuesta = [
        'exito' => false,
        'mensaje' => 'Escribe algo para buscar.'
    ];
    echo json_encode($respuesta);
    exit;
}

// se realiza la busqudea
$resultado = ($termino);

// devuelve los resultados
echo json_encode($resultado);
exit;
