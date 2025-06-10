<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/funciones.php';

$db = obtenerConexion();

// funcion para crear un album
function crearAlbum($nombre, $artista, $fechaLanzamiento, $imagen) {
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
function actualizarAlbum($id, $nombre, $artista, $fechaLanzamiento = null, $imagen = null) {
    global $db;
    try {
        // consulta para actualizar nombre y codartista
        if (empty($id) || empty($nombre) || empty($artista)) {
            return respuesta(false, 'ID, nombre y artista son obligatorios.');
        }

        // verificar que el album exista
        $stmt = $db->prepare("SELECT CARATULA FROM ALBUM WHERE CODALBUM = ?");
        $stmt->execute([$id]);
        $album = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$album) {
            return respuesta(false, 'El álbum no existe');
        }

        // empezar la actualizacion de datos
        $rutaImagen = null;
        $actualizarImagen = false;

        // verificar si se subio una nueva imagen
        if ($imagen && is_array($imagen) && isset($imagen['tmp_name']) && $imagen['error'] === UPLOAD_ERR_OK) {
            $rutaImagen = guardarArchivo($imagen, 'album');
            $actualizarImagen = true;
        }

        // empezar transaccion para que todo se haga bien o nada
        $db->beginTransaction();

        // preparar la consulta base
        $query = "UPDATE ALBUM SET NOMBRE = ?, CODARTISTA = ?";
        $params = [$nombre, $artista];

        // agregar fecha si se proporciono
        if ($fechaLanzamiento) {
            $query = $query . ", FECHA_LANZAMIENTO = ?";
            $params[] = $fechaLanzamiento;
        }

        // agregar imagen si se subio una nueva
        if ($actualizarImagen) {
            $query = $query . ", CARATULA = ?";
            $params[] = $rutaImagen;
        }

        // agregar condicion para actualizar solo este album
        $query = $query . " WHERE CODALBUM = ?";
        $params[] = $id;

        // ejecutar la actualizacion
        $stmt = $db->prepare($query);
        $stmt->execute($params);

        // confirmar que todo salio bien
        $db->commit();

        $mensaje = 'Álbum modificado correctamente';
        if ($actualizarImagen) {
            $mensaje = $mensaje . ' con nueva imagen';
        } else {
            $mensaje = $mensaje . ' sin cambiar imagen';
        }

        return respuesta(true, $mensaje);
    } catch (Exception $e) {
        // si algo sale mal, deshacer todo
        $db->rollBack();
        return respuesta(false, 'Error al modificar el álbum: ' . $e->getMessage());
    }
}

// funcion para eliminar un album
function eliminarAlbum($id) {
    global $db;
    try {
        // verificar que el id no este vacio
        if (empty($id)) {
            return respuesta(false, 'El ID del álbum es obligatorio.');
        }

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

        // si hay canciones, quitarles la referencia al album
        if ($cancionesAsociadas > 0) {
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

// funcion para crear un artista
function crearArtista($nombre, $biografia, $fechaNacimiento, $paisOrigen, $imagen) {
    global $db;
    try {
        // verificar que el nombre no este vacio
        if (empty($nombre)) {
            return respuesta(false, 'El nombre del artista es obligatorio.');
        }

        // verificar si el artista ya existe
        $stmt = $db->prepare("SELECT COUNT(*) FROM ARTISTA WHERE NOMBRE = ?");
        $stmt->execute([$nombre]);
        if ($stmt->fetchColumn() > 0) {
            return respuesta(false, 'Ya existe un artista con este nombre.');
        }

        // procesar imagen si se subio
        $rutaImagen = null;

        if ($imagen && $imagen['error'] === UPLOAD_ERR_OK) {
            // validar tipo de archivo
            $tipoArchivo = $imagen['type'];
            $tiposPermitidos = ['image/jpeg', 'image/png', 'image/jpg'];

            if (!in_array($tipoArchivo, $tiposPermitidos)) {
                return respuesta(false, 'Tipo de archivo no válido. Debe ser JPEG o PNG.');
            }

            // guardar archivo solo si es valido
            $rutaImagen = guardarArchivo($imagen, 'imagen');
        }

        // insertar el artista con los campos completos
        $stmt = $db->prepare("INSERT INTO ARTISTA (NOMBRE, BIOGRAFIA, FECHA_NACIMIENTO, PAIS_ORIGEN, IMAGEN) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $biografia, $fechaNacimiento, $paisOrigen, $rutaImagen]);

        return respuesta(true, 'Artista creado correctamente.', ['rutaImagen' => $rutaImagen]);
    } catch (Exception $e) {
        return respuesta(false, 'Error al crear el artista: ' . $e->getMessage());
    }
}

// funcion para modificar un artista
function modificarArtista($id, $nombre, $biografia, $fechaNacimiento, $paisOrigen, $imagen = null) {
    global $db;
    try {
        // verificar que los campos obligatorios no esten vacios
        if (empty($id) || empty($nombre)) {
            return respuesta(false, 'El ID y el nombre del artista son obligatorios.');
        }

        // verificar que el artista exista
        $stmt = $db->prepare("SELECT COUNT(*) FROM ARTISTA WHERE CODARTISTA = ?");
        $stmt->execute([$id]);
        if ($stmt->fetchColumn() == 0) {
            return respuesta(false, 'El artista no existe.');
        }

        // preparar la consulta y parametros
        $query = "UPDATE ARTISTA SET NOMBRE = ?, BIOGRAFIA = ?, FECHA_NACIMIENTO = ?, PAIS_ORIGEN = ?";
        $params = [$nombre, $biografia, $fechaNacimiento, $paisOrigen];

        // manejar subida de imagen si se proporciono
        $rutaImagen = null;
        if ($imagen && is_array($imagen) && isset($imagen['tmp_name']) && $imagen['error'] === UPLOAD_ERR_OK) {
            // validar tipo de imagen
            $tipoArchivo = $imagen['type'];
            $tiposPermitidos = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!in_array($tipoArchivo, $tiposPermitidos)) {
                return respuesta(false, 'Tipo de archivo no válido. Debe ser JPEG o PNG.');
            }

            // guardar la nueva imagen
            $rutaImagen = guardarArchivo($imagen, 'imagen');
            $query = $query . ", IMAGEN = ?";
            $params[] = $rutaImagen;
        }

        // completar la consulta
        $query = $query . " WHERE CODARTISTA = ?";
        $params[] = $id;

        // ejecutar la actualizacion
        $stmt = $db->prepare($query);
        $stmt->execute($params);

        $mensaje = 'Artista modificado correctamente';
        if ($rutaImagen) {
            $mensaje = $mensaje . ' con nueva imagen';
        } else {
            $mensaje = $mensaje . ' sin cambiar imagen';
        }

        return respuesta(true, $mensaje);
    } catch (Exception $e) {
        return respuesta(false, 'Error al modificar el artista: ' . $e->getMessage());
    }
}

// funcion para eliminar un artista
function eliminarArtista($id) {
    global $db;
    try {
        // verificar que el id no este vacio
        if (empty($id)) {
            return respuesta(false, 'El ID del artista es obligatorio.');
        }

        // iniciar la transaccion para que todo se haga bien o nada
        $db->beginTransaction();

        // verificar si el artista existe
        $stmt = $db->prepare("SELECT COUNT(*) FROM ARTISTA WHERE CODARTISTA = ?");
        $stmt->execute([$id]);
        if ($stmt->fetchColumn() == 0) {
            $db->rollBack();
            return respuesta(false, 'El artista no existe.');
        }

        // eliminar las canciones asociadas al artista
        $stmt = $db->prepare("DELETE FROM CANCION WHERE CODALBUM IN (SELECT CODALBUM FROM ALBUM WHERE CODARTISTA = ?)");
        $stmt->execute([$id]);

        // eliminar los albumes asociados al artista
        $stmt = $db->prepare("DELETE FROM ALBUM WHERE CODARTISTA = ?");
        $stmt->execute([$id]);

        // eliminar el artista
        $stmt = $db->prepare("DELETE FROM ARTISTA WHERE CODARTISTA = ?");
        $stmt->execute([$id]);

        // confirmar la transaccion
        $db->commit();

        return respuesta(true, 'Artista, álbumes y canciones eliminados correctamente.');
    } catch (PDOException $e) {
        // si algo sale mal, deshacer todo
        $db->rollBack();
        return respuesta(false, 'Error al eliminar el artista: ' . $e->getMessage());
    }
}

// funcion para crear una cancion
function crearCancion($nombre, $albumId, $duracion, $archivoAudio, $imagen = null) {
    global $db;
    try {
        // verificar que los datos principales no esten vacios
        if (empty($nombre) || empty($albumId) || empty($duracion) || empty($archivoAudio)) {
            return respuesta(false, 'Datos incompletos');
        }

        // limpiar el nombre para usar en archivos
        $nombreBase = preg_replace('/[^a-zA-Z0-9\-_]/', '_', $nombre);

        // cambiar el nombre del archivo de audio
        $extension = pathinfo($archivoAudio['name'], PATHINFO_EXTENSION);
        $archivoAudio['name'] = $nombreBase . '.' . $extension;
        $rutaAudio = guardarArchivo($archivoAudio, 'audio');

        // procesar imagen si se subio
        $rutaImagen = null;
        if ($imagen) {
            $extensionImg = pathinfo($imagen['name'], PATHINFO_EXTENSION);
            $imagen['name'] = $nombreBase . '.' . $extensionImg;
            $rutaImagen = guardarArchivo($imagen, 'imagen');
        }

        // insertar la cancion en la base de datos
        $stmt = $db->prepare("INSERT INTO CANCION (NOMBRE, CODALBUM, DURACION, AUDIO, IMAGEN) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nombreBase, $albumId, $duracion, $rutaAudio, $rutaImagen]);

        return respuesta(true, 'Canción creada correctamente');
    } catch (Exception $e) {
        return respuesta(false, 'Error al crear la canción: ' . $e->getMessage());
    }
}

// funcion para actualizar una cancion
function modificarCancion($id, $nombre, $duracion, $albumId = null, $archivoAudio = null, $imagen = null) {
    global $db;
    try {
        // aqui revisamos que el id, el nombre y la duracion no esten vacios
        if (empty($id) || empty($nombre) || empty($duracion)) {
            return respuesta(false, 'ID, nombre y duración son obligatorios');
        }

        // limpiar el nombre para usarlo en nombres de archivo
        $nombreBase = str_replace([' ', '/', '\\', ':', '*', '?', '"', '<', '>', '|'], '_', $nombre);

        // aqui empezamos a crear el texto que actualiza la cancion
        $query = "UPDATE CANCION SET NOMBRE = ?, DURACION = ?";
        $params = [$nombreBase, $duracion];

        // si se proporciona albumId, incluirlo en la consulta
        if ($albumId !== null) {
            $query = $query . ", CODALBUM = ?";
            $params[] = $albumId;
        }

        // validacion y manejo de archivo de audio
        $rutaAudio = null;
        if ($archivoAudio && isset($archivoAudio['error']) && $archivoAudio['error'] === UPLOAD_ERR_OK) {
            $extensionAudio = strtolower(pathinfo($archivoAudio['name'], PATHINFO_EXTENSION));
            $extensionesAudioPermitidas = ['mp3', 'wav', 'ogg'];
            if (!in_array($extensionAudio, $extensionesAudioPermitidas)) {
                return respuesta(false, 'Formato de audio no válido (solo MP3, WAV, OGG)');
            }
            $archivoAudio['name'] = $nombreBase . '.' . $extensionAudio;
            $rutaAudio = guardarArchivo($archivoAudio, 'audio');
            $query = $query . ", AUDIO = ?";
            $params[] = $rutaAudio;
        }

        // validacion y manejo de imagen
        $rutaImagen = null;
        if ($imagen && isset($imagen['error']) && $imagen['error'] === UPLOAD_ERR_OK) {
            $extensionImagen = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));
            $extensionesImagenPermitidas = ['jpg', 'jpeg', 'png'];
            if (!in_array($extensionImagen, $extensionesImagenPermitidas)) {
                return respuesta(false, 'Formato de imagen no válido (solo JPG, PNG)');
            }
            $imagen['name'] = $nombreBase . '.' . $extensionImagen;
            $rutaImagen = guardarArchivo($imagen, 'imagen');
            $query = $query . ", IMAGEN = ?";
            $params[] = $rutaImagen;
        }

        // aqui terminamos el texto que actualiza con el id de la cancion
        $query = $query . " WHERE CODCANCION = ?";
        $params[] = $id;

        // ejecutar consulta
        $stmt = $db->prepare($query);
        $stmt->execute($params);

        // verificar si se actualizo alguna fila
        if ($stmt->rowCount() === 0) {
            return respuesta(false, 'No se encontró una canción con el ID proporcionado');
        }

        return respuesta(true, 'Canción actualizada correctamente', [
            'audio' => $rutaAudio,
            'imagen' => $rutaImagen
        ]);
    } catch (PDOException $e) {
        return respuesta(false, 'Error al modificar la canción: ' . $e->getMessage());
    }
}

// funcion para eliminar una cancion
function eliminarCancion($id) {
    global $db;
    try {
        $stmt = $db->prepare("SELECT NOMBRE, IMAGEN, AUDIO FROM CANCION WHERE CODCANCION = ?");
        $stmt->execute([$id]);
        $cancion = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cancion) {
            $nombreArchivoAudio = '/assets/audio/' . $cancion['NOMBRE'] . '.mp3';
            $nombreArchivoImagen = '/assets/img/album/' . $cancion['NOMBRE'] . '.jpg';

            // si existe el archivo de audio de la cancion y se va a borrar para no ocupar espacio
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $nombreArchivoAudio)) {
                unlink($_SERVER['DOCUMENT_ROOT'] . $nombreArchivoAudio);
            }

            // si existe el archivo de imagen de la cancion y se va a borrar para no ocupar espacio
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $nombreArchivoImagen)) {
                unlink($_SERVER['DOCUMENT_ROOT'] . $nombreArchivoImagen);
            }

            // hacemos la consulta para borrar la cancion de la base de datos
            $stmt = $db->prepare("DELETE FROM CANCION WHERE CODCANCION = ?");
            $stmt->execute([$id]);

            return respuesta(true, 'Canción y archivos relacionados eliminados correctamente');
        } else {
            return respuesta(false, 'Canción no encontrada');
        }
    } catch (PDOException $e) {
        return respuesta(false, 'Error al eliminar la canción: ' . $e->getMessage());
    }
}

// funcion para obtener canciones
function obtenerArtistas() {
    global $db;
    try {
        // obtener todos los artistas de la base de datos
        $stmt = $db->query("SELECT * FROM ARTISTA");
        $resultadoConsulta = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$resultadoConsulta) {
            return json_encode([
                'exito' => false,
                'mensaje' => 'No se encontraron artistas'
            ]);
        }

        return json_encode([
            'exito' => true,
            'data' => $resultadoConsulta
        ]);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return json_encode([
            'exito' => false,
            'mensaje' => 'Error al obtener los artistas: ' . $e->getMessage()
        ]);
    }
}

// funcion para obtener album
function obtenerAlbumes() {
    global $db;
    try {
        // obtener todos los albumes con informacion del artista
        $stmt = $db->query("
            SELECT ALBUM.CODALBUM, ALBUM.NOMBRE, ALBUM.FECHA_LANZAMIENTO, ALBUM.CARATULA, ARTISTA.NOMBRE AS ARTISTA
            FROM ALBUM
            INNER JOIN ARTISTA ON ALBUM.CODARTISTA = ARTISTA.CODARTISTA
        ");
        $resultadoConsulta = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$resultadoConsulta) {
            return json_encode([
                'exito' => false,
                'mensaje' => 'No se encontraron álbumes'
            ]);
        }

        return json_encode([
            'exito' => true,
            'data' => $resultadoConsulta
        ]);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return json_encode([
            'exito' => false,
            'mensaje' => 'Error al obtener los álbumes: ' . $e->getMessage()
        ]);
    }
}

// funcion para obtener canciones
function obtenerCanciones() {
    global $db;
    try {
        // obtener todas las canciones con informacion del album
        $stmt = $db->query("
            SELECT 
                c.CODCANCION,
                c.NOMBRE, 
                c.DURACION, 
                c.AUDIO, 
                c.IMAGEN, 
                a.NOMBRE AS NOMBRE_ALBUM 
            FROM CANCION c
            LEFT JOIN ALBUM a ON c.CODALBUM = a.CODALBUM
        ");
        $resultadoConsulta = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // si las canciones no se encontraron
        if (!$resultadoConsulta) {
            return json_encode([
                'exito' => false,
                'mensaje' => 'No se encontraron canciones'
            ]);
        }

        return json_encode([
            'exito' => true,
            'data' => $resultadoConsulta
        ]);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return json_encode([
            'exito' => false,
            'mensaje' => 'Error al obtener las canciones: ' . $e->getMessage()
        ]);
    }
}

// funcion para generar respuestas json
function respuesta($exito, $mensaje, $data = null) {
    return json_encode([
        'exito' => $exito,
        'mensaje' => $mensaje,
        'data' => $data
    ]);
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
            $respuesta = crearCancion($_POST['nombre'], $_POST['album_id'], $_POST['duracion'], $_FILES['archivo_audio'], $_FILES['imagen'] ?? null);
            break;
        case 'modificar_cancion':
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
