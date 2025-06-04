<?php
// esto dice que la respuesta sera en formato json
header('Content-Type: application/json');
// esto muestra los errores si algo sale mal
error_reporting(E_ALL);
ini_set('display_errors', 1);

// traemos el archivo que conecta con la base de datos
require_once dirname(__FILE__) . '/../includes/db.php';

// esta funcion busca los comentarios de un album
function obtenerComentariosPorAlbum($idAlbum)
{
    // nos conectamos a la base de datos
    $db = obtenerConexion();
    try {
        // preparamos la pregunta para buscar comentarios
        $stmt = $db->prepare(
            'SELECT c.ID as id, c.COMENTARIO as comentario, c.FECHA_COMENTARIO as fechaComentario, 
                u.NOMBRE_USUARIO as usuario, c.LIKES as likes, c.DISLIKES as dislikes
             FROM COMENTARIOS c
             JOIN USUARIOS u ON c.ID_USUARIO = u.ID
             WHERE c.ID_ALBUM = ?'
        );
        // ejecutamos la pregunta con el id del album
        $stmt->execute([$idAlbum]);
        // guardamos todos los comentarios que encontramos
        $comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // para cada comentario, vemos si el usuario ya le dio me gusta o no me gusta
        foreach ($comentarios as &$comentario) {
            // el nombre de la galleta para saber la reaccion
            $cookieName = 'reaccion_' . $comentario['id'];
            // si existe la galleta
            if (isset($_COOKIE[$cookieName])) {
                // vemos si fue un me gusta
                $comentario['usuarioHaDadoLike'] = ($_COOKIE[$cookieName] === 'like');
                // vemos si fue un no me gusta
                $comentario['usuarioHaDadoDislike'] = ($_COOKIE[$cookieName] === 'dislike');
            } else {
                // si no hay galleta, no ha dado ninguna reaccion
                $comentario['usuarioHaDadoLike'] = false;
                $comentario['usuarioHaDadoDislike'] = false;
            }
        }

        // devolvemos que todo salio bien y los comentarios
        return [
            'exito' => true,
            'comentarios' => $comentarios
        ];
    } catch (Exception $e) {
        // si algo salio mal, devolvemos un mensaje de error
        return [
            'exito' => false,
            'mensaje' => 'error al obtener los comentarios: ' . $e->getMessage()
        ];
    }
}
