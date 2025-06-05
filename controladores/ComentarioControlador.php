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

// esta funcion es para dar me gusta o quitarlo
function darLike($idComentario)
{
    // nos conectamos a la base de datos
    $db = obtenerConexion();
    // el nombre de la galleta para este comentario
    $cookieName = 'reaccion_' . $idComentario;

    // vemos si ya hay una reaccion guardada (me gusta o no me gusta)
    if (isset($_COOKIE[$cookieName])) {
        $reaccionActual = $_COOKIE[$cookieName];

        // si ya le habia dado me gusta
        if ($reaccionActual === 'like') {
            // quitamos la galleta
            setcookie($cookieName, '', time() - 3600, "/");  // borramos la galleta para que no este mas
            // restamos un like en la base de datos
            $stmt = $db->prepare('UPDATE COMENTARIOS SET LIKES = LIKES - 1 WHERE ID = ?');
            $stmt->execute([$idComentario]);
            // decimos que se quito el like
            return [
                'exito' => true,
                'mensaje' => 'like eliminado exitosamente'
            ];
        } elseif ($reaccionActual === 'dislike') {
            // si ya le dio no me gusta, no puede dar me gusta
            return [
                'exito' => false,
                'mensaje' => 'no puedes dar like si ya diste dislike'
            ];
        }
    } else {
        // si no habia reaccion, guardamos el me gusta
        setcookie($cookieName, 'like', time() + (86400 * 30), "/"); // guardamos la galleta por 30 dias
        // sumamos un like en la base de datos
        $stmt = $db->prepare('UPDATE COMENTARIOS SET LIKES = LIKES + 1 WHERE ID = ?');
        $stmt->execute([$idComentario]);
        // decimos que se agrego el like
        return [
            'exito' => true,
            'mensaje' => 'like añadido exitosamente'
        ];
    }
}

// esta funcion es para dar no me gusta o quitarlo
function darDislike($idComentario)
{
    // nos conectamos a la base de datos
    $db = obtenerConexion();
    // el nombre de la galleta para este comentario
    $cookieName = 'reaccion_' . $idComentario;

    // vemos si ya hay una reaccion guardada (me gusta o no me gusta)
    if (isset($_COOKIE[$cookieName])) {
        $reaccionActual = $_COOKIE[$cookieName];

        // si ya le habia dado no me gusta
        if ($reaccionActual === 'dislike') {
            // quitamos la galleta
            setcookie($cookieName, '', time() - 3600, "/");  // borramos la galleta para que no este mas
            // restamos un dislike en la base de datos
            $stmt = $db->prepare('UPDATE COMENTARIOS SET DISLIKES = DISLIKES - 1 WHERE ID = ?');
            $stmt->execute([$idComentario]);
            // decimos que se quito el dislike
            return [
                'exito' => true,
                'mensaje' => 'dislike eliminado exitosamente'
            ];
        } elseif ($reaccionActual === 'like') {
            // si ya le dio me gusta, no puede dar no me gusta
            return [
                'exito' => false,
                'mensaje' => 'no puedes dar dislike si ya diste like'
            ];
        }
    } else {
        // si no habia reaccion, guardamos el no me gusta
        setcookie($cookieName, 'dislike', time() + (86400 * 30), "/"); // guardamos la galleta por 30 dias
        // sumamos un dislike en la base de datos
        $stmt = $db->prepare('UPDATE COMENTARIOS SET DISLIKES = DISLIKES + 1 WHERE ID = ?');
        $stmt->execute([$idComentario]);
        // decimos que se agrego el dislike
        return [
            'exito' => true,
            'mensaje' => 'dislike añadido exitosamente'
        ];
    }
}

// esta funcion es para escribir un comentario nuevo en un album
function publicarComentario($usuarioNombre, $idAlbum, $comentario)
{
    // nos conectamos a la base de datos
    $db = obtenerConexion();
    try {
        // si el id del album no es un numero, avisamos
        if (!is_numeric($idAlbum)) {
            throw new Exception("Id de album no valido");
        }

        // buscamos el id del usuario usando su nombre
        $stmt = $db->prepare('SELECT ID FROM USUARIOS WHERE NOMBRE_USUARIO = ?');
        $stmt->execute([$usuarioNombre]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // si no encontramos al usuario, avisamos
        if (!$usuario) {
            throw new Exception("Usuario no encontrado");
        }

        $idUsuario = $usuario['ID'];

        // limpiamos el comentario para que no tenga cosas raras
        $comentario = htmlspecialchars($comentario, ENT_QUOTES, 'UTF-8');
        // si el comentario esta vacio, avisamos
        if (empty($comentario)) {
            throw new Exception("El comentario no puede estar vacio");
        }

        // insertamos el comentario en la base de datos
        $stmt = $db->prepare(
            'INSERT INTO COMENTARIOS (ID_USUARIO, ID_ALBUM, COMENTARIO)
             VALUES (?, ?, ?)'
        );
        $stmt->execute([$idUsuario, $idAlbum, $comentario]);

        // decimos que el comentario se publico bien
        return [
            'exito' => true,
            'mensaje' => 'Comentario publicado exitosamente'
        ];

    } catch (Exception $e) {
        // si algo salio mal, devolvemos un mensaje de error
        return [
            'exito' => false,
            'mensaje' => 'Error al publicar el comentario: ' . $e->getMessage()
        ];
    }
}

// esta funcion es para cambiar un comentario que ya existe
function editarComentario($idComentario, $comentarioNuevo)
{
    // nos conectamos a la base de datos
    $db = obtenerConexion();
    try {
        // si el comentario nuevo esta vacio, avisamos
        if (empty($comentarioNuevo)) {
            throw new Exception("El comentario no puede estar vacio");
        }

        // limpiamos el comentario para que no tenga cosas raras
        $comentarioNuevo = htmlspecialchars($comentarioNuevo, ENT_QUOTES, 'UTF-8');

        // actualizamos el comentario en la base de datos
        $stmt = $db->prepare('UPDATE COMENTARIOS SET COMENTARIO = ? WHERE ID = ?');
        $stmt->execute([$comentarioNuevo, $idComentario]);

        // decimos que el comentario se actualizo bien
        return [
            'exito' => true,
            'mensaje' => 'Comentario actualizado exitosamente'
        ];

    } catch (Exception $e) {
        // si algo salio mal, devolvemos un mensaje de error
        return [
            'exito' => false,
            'mensaje' => 'Error al editar el comentario: ' . $e->getMessage()
        ];
    }
}

// esta funcion es para borrar un comentario
function eliminarComentario($idComentario)
{
    // nos conectamos a la base de datos
    $db = obtenerConexion();
    try {
        // borramos el comentario de la base de datos
        $stmt = $db->prepare('DELETE FROM COMENTARIOS WHERE ID = ?');
        $stmt->execute([$idComentario]);

        // decimos que el comentario se borro bien
        return [
            'exito' => true,
            'mensaje' => 'Comentario eliminado exitosamente'
        ];

    } catch (Exception $e) {
        // si algo salio mal, devolvemos un mensaje de error
        return [
            'exito' => false,
            'mensaje' => 'Error al eliminar el comentario: ' . $e->getMessage()
        ];
    }
}

// aqui lo que hacemos es segun la seleccion que se haga, pues se procede a una accion u otra
try {
    // leemos los datos que nos envian
    $datos = json_decode(file_get_contents('php://input'), true);

    // si nos enviaron datos con el metodo post (para guardar o cambiar cosas)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // si nos dicen que accion hacer
        if (isset($datos['accion'])) {
            // hacemos algo segun la accion
            switch ($datos['accion']) {
                case 'borrar_comentario':
                    // si nos piden borrar un comentario y nos dan el id
                    if (isset($datos['idComentario'])) {
                        $resultado = eliminarComentario($datos['idComentario']); // lo borramos
                        echo json_encode($resultado); // devolvemos la respuesta
                        exit; // terminamos aqui
                    }
                    break;
                case 'editar_comentario':
                    // si nos piden editar un comentario y nos dan el id y el nuevo comentario
                    if (isset($datos['idComentario'], $datos['comentario'])) {
                        $resultado = editarComentario($datos['idComentario'], $datos['comentario']); // lo editamos
                        echo json_encode($resultado); // devolvemos la respuesta
                        exit; // terminamos aqui
                    }
                    break;
                case 'dar_like':
                    // si nos piden dar un me gusta y nos dan el id
                    if (isset($datos['idComentario'])) {
                        $resultado = darLike($datos['idComentario']); // damos el me gusta
                        echo json_encode($resultado); // devolvemos la respuesta
                        exit; // terminamos aqui
                    }
                    break;
                case 'dar_dislike':
                    // si nos piden dar un no me gusta y nos dan el id
                    if (isset($datos['idComentario'])) {
                        $resultado = darDislike($datos['idComentario']); // damos el no me gusta
                        echo json_encode($resultado); // devolvemos la respuesta
                        exit; // terminamos aqui
                    }
                    break;
            }
        }
        // si nos envian un nuevo comentario con el nombre de usuario, id del album y el comentario
        if (isset($datos['usuarioNombre'], $datos['idAlbum'], $datos['comentario'])) {
            $resultado = publicarComentario($datos['usuarioNombre'], $datos['idAlbum'], $datos['comentario']); // lo publicamos
            echo json_encode($resultado); // devolvemos la respuesta
            exit; // terminamos aqui
        }
    }

    // si nos piden datos con el metodo get (para obtener cosas) y nos dan el id del album
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['idAlbum'])) {
        // obtenemos el id del album de forma segura
        $idAlbum = filter_input(INPUT_GET, 'idAlbum', FILTER_VALIDATE_INT);
        // si el id del album es valido
        if ($idAlbum) {
            $resultado = obtenerComentariosPorAlbum($idAlbum); // buscamos los comentarios
            echo json_encode($resultado); // devolvemos la respuesta
            exit; // terminamos aqui
        } else {
            // si el id del album no es valido, avisamos
            throw new Exception("Id de album no valido");
        }
    }

    // si no nos pidieron nada valido, avisamos
    throw new Exception("Metodo no valido");

} catch (Exception $e) {
    // si algo sale mal en cualquier parte, devolvemos un mensaje de error
    echo json_encode([
        'exito' => false,
        'mensaje' => $e->getMessage()
    ]);
}
