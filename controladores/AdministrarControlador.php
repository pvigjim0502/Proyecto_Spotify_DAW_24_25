<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/funciones.php';

$db = obtenerConexion();

// funcion para crear un album
function crearAlbum($nombre, $artista, $fechaLanzamiento, $imagen)
{
    global $db;
    try {
        // si algun campo esta vacio, se lanza una excepcion
        if (empty($nombre) || empty($artista) || empty($fechaLanzamiento)) {
            throw new Exception('Nombre, artista y fecha de lanzamiento son obligatorios.');
        }

        // se prepara la consulta para verificar si ya existe un album con el mismo nombre y artista
        $stmt = $db->prepare("SELECT COUNT(*) FROM ALBUM WHERE NOMBRE = ? AND CODARTISTA = ?");
        $stmt->execute([$nombre, $artista]);
        $existe = $stmt->fetchColumn();

        // si a existe entonces dara un error
        if ($existe > 0) {
            throw new Exception('Ya existe un álbum con este nombre para el mismo artista.');
        }
        // se inicializa la variable rutaimagen a null
        $rutaImagen = null; 
        // se verifica si la imagen es un array, si tiene la clave 'error' y si el error es de tipo 'upload_err_ok' (subida exitosa)
        if (is_array($imagen) && isset($imagen['error']) && $imagen['error'] === UPLOAD_ERR_OK) { 
            $rutaImagen = guardarArchivo($imagen, 'album');
        } else {
            throw new Exception('Error al subir la imagen: Archivo no válido o no seleccionado.');
        }
        // se prepara la consulta para insertar un nuevo album en la tabla album
        $stmt = $db->prepare("INSERT INTO ALBUM (NOMBRE, CODARTISTA, FECHA_LANZAMIENTO, CARATULA) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $artista, $fechaLanzamiento, $rutaImagen]);

        return respuesta(true, 'Álbum creado correctamente.', ['rutaImagen' => $rutaImagen]);
    } catch (Exception $e) {
        return respuesta(false, 'Error al crear el álbum: ' . $e->getMessage());
    }
}

// funcion para actualizar un album
function actualizarAlbum($id, $nombre, $artista, $imagen = null)
{
    global $db;
    try {
        // consulta para actualizar nombre y codartista
        $query = "UPDATE ALBUM SET NOMBRE = ?, CODARTISTA = ?";
        $params = [$nombre, $artista];

        // si hay imagen nueva se guarda y se añade a la consulta
        if ($imagen) {
            $rutaImagen = guardarArchivo($imagen, 'album');
            $query .= ", CARATULA = ?";
            $params[] = $rutaImagen;
        }

        // condicion para actualizar el album especifico
        $query .= " WHERE CODALBUM = ?";
        $params[] = $id;

        // preparar y ejecutar la consulta
        $stmt = $db->prepare($query);
        $stmt->execute($params);

        return respuesta(true, 'Álbum actualizado correctamente');
    } catch (PDOException $e) {
        return respuesta(false, 'Error al actualizar el álbum: ' . $e->getMessage());
    }
}

// funcion para eliminar un album
function eliminarAlbum($id)
{
    global $db;
    try {
        // verificar si el album existe antes de eliminarlo
        $stmt = $db->prepare("SELECT COUNT(*) FROM ALBUM WHERE CODALBUM = ?");
        $stmt->execute([$id]);
        $existe = $stmt->fetchColumn();

        if ($existe == 0) {
            return respuesta(false, 'El álbum no existe');
        }

        // verificar si hay canciones asociadas al album
        $stmt = $db->prepare("SELECT COUNT(*) FROM CANCION WHERE CODALBUM = ?");
        $stmt->execute([$id]);
        $cancionesAsociadas = $stmt->fetchColumn();

        if ($cancionesAsociadas > 0) {
            // si hay canciones, se les quita la relacion con el album
            $stmt = $db->prepare("UPDATE CANCION SET CODALBUM = NULL WHERE CODALBUM = ?");
            $stmt->execute([$id]);
        }

        // ahora eliminar el album
        $stmt = $db->prepare("DELETE FROM ALBUM WHERE CODALBUM = ?");
        $stmt->execute([$id]);

        return respuesta(true, 'Álbum eliminado correctamente');
    } catch (PDOException $e) {
        return respuesta(false, 'Error al eliminar el álbum: ' . $e->getMessage());
    }
}

// manejo de acciones
try {
    $accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

    switch ($accion) {
        case 'crear_album':
            $respuesta = crearAlbum($_POST['nombre'], $_POST['artista'], $_POST['fechaLanzamiento'], $_FILES['imagen']);
            break;
        case 'actualizar_album':
            $respuesta = actualizarAlbum($_POST['id'], $_POST['nombre'], $_POST['artista'], $_FILES['imagen'] ?? null);
            break;
        case 'eliminar_album':
            $respuesta = eliminarAlbum($_POST['id']);
            break;
        case 'modificar_album':
            $respuesta = modificarAlbum($_POST['id'], $_POST['nombre'], $_POST['artista'], $_POST['fechaLanzamiento'] ?? null, $_FILES['imagen'] ?? null);
            break;
        case 'crear_cancion':
            if (empty($_POST['nombre']) || empty($_POST['album_id']) || empty($_POST['duracion']) || empty($_FILES['archivo_audio'])) {
                echo json_encode(['exito' => false, 'mensaje' => 'Datos incompletos']);
                exit;
            }
            $respuesta = crearCancion($_POST['nombre'], $_POST['album_id'], $_POST['duracion'], $_FILES['archivo_audio'], $_FILES['imagen'] ?? null);
            break;
        case 'modificar_cancion':
            if (empty($_POST['id']) || empty($_POST['nombre']) || empty($_POST['duracion'])) {
                echo json_encode(['exito' => false, 'mensaje' => 'Datos incompletos']);
                exit;
            }
            $album_id = $_POST['album_id'] ?? null;
            $respuesta = modificarCancion($_POST['id'], $_POST['nombre'], $_POST['duracion'], $album_id, $_FILES['archivo_audio'] ?? null, $_FILES['imagen'] ?? null);
            break;
        case 'eliminar_cancion':
            $id = json_decode(file_get_contents('php://input'), true)['id'];
            $respuesta = eliminarCancion($id);
            break;
        case 'crear_artista':
            $respuesta = crearArtista($_POST['nombre'] ?? null, $_POST['biografia'] ?? null, $_POST['fechaNacimiento'] ?? null, $_POST['paisOrigen'] ?? null, $_FILES['imagen'] ?? null);
            break;
        case 'modificar_artista':
            $respuesta = modificarArtista($_POST['id'] ?? null, $_POST['nombre'] ?? null, $_POST['biografia'] ?? null, $_POST['fechaNacimiento'] ?? null, $_POST['paisOrigen'] ?? null, $_FILES['imagen'] ?? null);
            break;
        case 'eliminar_artista':
            $respuesta = eliminarArtista($_POST['id']);
            break;
        case 'obtener_albumes':
            $respuesta = obtenerAlbumes();
            break;
        case 'obtener_canciones':
            $respuesta = obtenerCanciones();
            break;
        case 'obtener_artistas':
            $respuesta = obtenerArtistas();
            break;
        default:
            $respuesta = json_encode(['exito' => false, 'mensaje' => 'Acción no válida']);
            break;
    }

    echo $respuesta;
} catch (Exception $e) {
    echo json_encode(['exito' => false, 'mensaje' => 'Error en el servidor: ' . $e->getMessage()]);
}
