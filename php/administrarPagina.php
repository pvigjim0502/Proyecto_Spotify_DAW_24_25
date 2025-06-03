<div id="contenidoAdministracion" class="container-fluid py-5"
    style="display: none; background-color: #121212; color: #FFFFFF;">
    <div class="row justify-content-center mb-5">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-body" style="padding: 2rem;">
                    <h2 class="text-center mb-5 text-uppercase font-weight-bold"
                        style="color: #FFFFFF; letter-spacing: 1px;">Administración de Contenidos</h2>

                    <div class="row justify-content-center">
                        <div class="col-md-5 mb-4">
                            <h4 class="text-center mb-4" style="color: #1ED760; font-weight: 600;">Gestionar Canciones
                            </h4>
                            <div class="d-flex flex-column align-items-center">
                                <button class="btn btn-lg mb-3 px-5 py-3 w-100"
                                    onclick="mostrarFormulario('añadirCancion')"
                                    style="background-color: #1DB954; color: white; border-radius: 30px; font-weight: 600; transition: all 0.3s ease;">
                                    <i class="fas fa-plus-circle me-2"></i>Añadir Canción
                                </button>
                                <button class="btn btn-lg mb-3 px-5 py-3 w-100"
                                    onclick="mostrarFormulario('eliminarCancion')"
                                    style="background-color: rgba(255, 65, 54, 0.8); color: white; border-radius: 30px; font-weight: 600; transition: all 0.3s ease;">
                                    <i class="fas fa-trash-alt me-2"></i>Eliminar Canción
                                </button>
                                <button class="btn btn-lg mb-3 px-5 py-3 w-100"
                                    onclick="mostrarFormulario('modificarCancion')"
                                    style="background-color: #FFB400; color: white; border-radius: 30px; font-weight: 600; transition: all 0.3s ease;">
                                    <i class="fas fa-edit me-2"></i>Modificar Canción
                                </button>
                            </div>
                        </div>

                        <div class="col-md-5 mb-4">
                            <h4 class="text-center mb-4" style="color: #1ED760; font-weight: 600;">Gestionar Artistas
                            </h4>
                            <div class="d-flex flex-column align-items-center">
                                <button class="btn btn-lg mb-3 px-5 py-3 w-100"
                                    onclick="mostrarFormulario('añadirArtista')"
                                    style="background-color: #1DB954; color: white; border-radius: 30px; font-weight: 600; transition: all 0.3s ease;">
                                    <i class="fas fa-plus-circle me-2"></i>Añadir Artista
                                </button>
                                <button class="btn btn-lg mb-3 px-5 py-3 w-100"
                                    onclick="mostrarFormulario('eliminarArtista')"
                                    style="background-color: rgba(255, 65, 54, 0.8); color: white; border-radius: 30px; font-weight: 600; transition: all 0.3s ease;">
                                    <i class="fas fa-trash-alt me-2"></i>Eliminar Artista
                                </button>
                                <button class="btn btn-lg mb-3 px-5 py-3 w-100"
                                    onclick="mostrarFormulario('modificarArtista')"
                                    style="background-color: #FFB400; color: white; border-radius: 30px; font-weight: 600; transition: all 0.3s ease;">
                                    <i class="fas fa-edit me-2"></i>Modificar Artista
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-5 mb-4">
                            <h4 class="text-center mb-4" style="color: #1ED760; font-weight: 600;">Gestionar Álbumes
                            </h4>
                            <div class="d-flex flex-column align-items-center">
                                <button class="btn btn-lg mb-3 px-5 py-3 w-100"
                                    onclick="mostrarFormulario('añadirAlbum')"
                                    style="background-color: #1DB954; color: white; border-radius: 30px; font-weight: 600; transition: all 0.3s ease;">
                                    <i class="fas fa-plus-circle me-2"></i>Añadir Álbum
                                </button>
                                <button class="btn btn-lg mb-3 px-5 py-3 w-100"
                                    onclick="mostrarFormulario('eliminarAlbum')"
                                    style="background-color: rgba(255, 65, 54, 0.8); color: white; border-radius: 30px; font-weight: 600; transition: all 0.3s ease;">
                                    <i class="fas fa-trash-alt me-2"></i>Eliminar Álbum
                                </button>
                                <button class="btn btn-lg mb-3 px-5 py-3 w-100"
                                    onclick="mostrarFormulario('modificarAlbum')"
                                    style="background-color: #FFB400; color: white; border-radius: 30px; font-weight: 600; transition: all 0.3s ease;">
                                    <i class="fas fa-edit me-2"></i>Modificar Álbum
                                </button>
                            </div>
                        </div>

                        <div class="col-md-5 mb-4">
                            <h4 class="text-center mb-4" style="color: #1ED760; font-weight: 600;">Ver Contenido</h4>
                            <div class="d-flex flex-column align-items-center">
                                <button class="btn btn-lg mb-3 px-5 py-3 w-100"
                                    onclick="mostrarFormulario('mostrarArtistas')"
                                    style="background-color: rgba(255, 255, 255, 0.1); color: white; border-radius: 30px; font-weight: 600; border: 1px solid rgba(255, 255, 255, 0.3); transition: all 0.3s ease;">
                                    <i class="fas fa-users me-2"></i>Artistas
                                </button>
                                <button class="btn btn-lg mb-3 px-5 py-3 w-100"
                                    onclick="mostrarFormulario('mostrarAlbumes')"
                                    style="background-color: rgba(255, 255, 255, 0.1); color: white; border-radius: 30px; font-weight: 600; border: 1px solid rgba(255, 255, 255, 0.3); transition: all 0.3s ease;">
                                    <i class="fas fa-compact-disc me-2"></i>Álbumes
                                </button>
                                <button class="btn btn-lg mb-3 px-5 py-3 w-100"
                                    onclick="mostrarFormulario('mostrarCanciones')"
                                    style="background-color: rgba(255, 255, 255, 0.1); color: white; border-radius: 30px; font-weight: 600; border: 1px solid rgba(255, 255, 255, 0.3); transition: all 0.3s ease;">
                                    <i class="fas fa-music me-2"></i>Canciones
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div id="formularioAñadirCancion" class="card shadow-lg border-0 mb-4 formularioSeccion"
                style="display: none; border-radius: 8px;">
                <div class="card-header py-3"
                    style="background-color: #1DB954; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                    <h4 class="card-title mb-0 text-center text-white">Añadir Nueva Canción</h4>
                </div>
                <div class="card-body p-4">
                    <form id="form-cancion" onsubmit="return subirCancion(event)" method="POST" class="row g-4">
                        <div class="col-md-6">
                            <label for="cancionNombre" class="form-label" style="color: #FFFFFF;">Nombre de la
                                Canción</label>
                            <input type="text" id="cancionNombre" class="form-control form-control-lg"
                                name="cancionNombre" required
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                        </div>
                        <div class="col-md-6">
                            <label for="cancionAlbum" class="form-label" style="color: #FFFFFF;">Seleccionar
                                Álbum</label>
                            <select id="cancionAlbum" class="form-select form-select-lg" name="cancionAlbum" required
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="cancionImagen" class="form-label" style="color: #FFFFFF;">Imagen</label>
                            <input type="file" id="cancionImagen" class="form-control form-control-lg"
                                name="cancionImagen"
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                        </div>
                        <div class="col-md-6">
                            <label for="cancionAudio" class="form-label" style="color: #FFFFFF;">Archivo de
                                Audio</label>
                            <input type="file" id="cancionAudio" class="form-control form-control-lg"
                                name="cancionAudio" required
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                        </div>
                        <div class="col-md-6">
                            <label for="cancionDuracion" class="form-label" style="color: #FFFFFF;">Duración</label>
                            <input type="time" id="cancionDuracion" class="form-control form-control-lg"
                                name="cancionDuracion" required
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                        </div>
                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-lg px-5"
                                style="background-color: #1DB954; color: white; border-radius: 30px; font-weight: 600; transition: all 0.3s ease;">
                                Subir Canción
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="formularioModificarCancion" class="card shadow-lg border-0 mb-4 formularioSeccion"
                style="display: none; border-radius: 8px;">
                <div class="card-header py-3"
                    style="background-color: rgba(255, 220, 0, 0.8); border-top-left-radius: 8px; border-top-right-radius: 8px;">
                    <h4 class="card-title mb-0 text-center" style="color: #121212;">Modificar Canción</h4>
                </div>
                <div class="card-body p-4">
                    <form id="form-modificar-cancion" onsubmit="modificarCancion(event)" method="POST"
                        enctype="multipart/form-data" class="row g-4">
                        <div class="col-md-12">
                            <label for="selectCancionModificar" class="form-label" style="color: #FFFFFF;">Seleccionar
                                Canción</label>
                            <select id="selectCancionModificar" name="id" class="form-select form-select-lg" required
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                                <option value="" disabled selected>Seleccione una canción</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label for="nombreCancionModificar" class="form-label" style="color: #FFFFFF;">Nuevo Nombre
                                de la Canción</label>
                            <input type="text" id="nombreCancionModificar" name="nombre"
                                class="form-control form-control-lg" required
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                        </div>

                        <div class="col-md-12">
                            <label for="duracionCancionModificar" class="form-label"
                                style="color: #FFFFFF;">Duración</label>
                            <input type="time" id="duracionCancionModificar" name="duracion"
                                class="form-control form-control-lg"
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                        </div>

                        <div class="col-md-12">
                            <label for="audioCancionModificar" class="form-label" style="color: #FFFFFF;">Nuevo
                                Audio</label>
                            <input type="file" id="audioCancionModificar" name="audio"
                                class="form-control form-control-lg" accept="audio/*"
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                        </div>

                        <div class="col-md-12">
                            <label for="imagenCancionModificar" class="form-label" style="color: #FFFFFF;">Nueva Imagen
                                de la Canción</label>
                            <input type="file" id="imagenCancionModificar" name="imagen"
                                class="form-control form-control-lg" accept="image/*"
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                        </div>

                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-lg px-5"
                                style="background-color: rgba(255, 220, 0, 0.8); color: black; border-radius: 30px; font-weight: 600; transition: all 0.3s ease;">
                                Modificar Canción
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="formularioEliminarCancion" class="card shadow-lg border-0 mb-4 formularioSeccion"
                style="display: none; border-radius: 8px;">
                <div class="card-header py-3"
                    style="background-color: rgba(255, 65, 54, 0.8); border-top-left-radius: 8px; border-top-right-radius: 8px;">
                    <h4 class="card-title mb-0 text-center text-white">Eliminar una Canción</h4>
                </div>
                <div class="card-body p-4">
                    <form id="form-eliminar-cancion" onsubmit="return eliminarCancion(event)" class="row g-4">
                        <div class="col-12">
                            <label for="cancionEliminar" class="form-label" style="color: #FFFFFF;">Seleccionar Canción
                                a Eliminar</label>
                            <select id="cancionEliminar" class="form-select form-select-lg" name="cancionEliminar"
                                required
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                            </select>
                        </div>
                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-lg px-5"
                                style="background-color: rgba(255, 65, 54, 0.8); color: white; border-radius: 30px; font-weight: 600; transition: all 0.3s ease;">
                                Eliminar Canción
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="formularioAñadirArtista" class="card shadow-lg border-0 mb-4 formularioSeccion"
                style="display: none; border-radius: 8px;">
                <div class="card-header py-3"
                    style="background-color: #1DB954; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                    <h4 class="card-title mb-0 text-center text-white">Añadir Nuevo Artista</h4>
                </div>
                <div class="card-body p-4">
                    <form id="form-añadir-artista" onsubmit="return crearArtista(event)" class="row g-4"
                        enctype="multipart/form-data">
                        <div class="col-12">
                            <label for="nombreArtista" class="form-label" style="color: #FFFFFF;">Nombre del
                                Artista</label>
                            <input type="text" class="form-control form-control-lg" id="nombreArtista" name="nombre"
                                required
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                        </div>

                        <div class="col-12">
                            <label for="biografiaArtista" class="form-label" style="color: #FFFFFF;">Biografía del
                                Artista</label>
                            <textarea class="form-control form-control-lg" id="biografiaArtista" name="biografia"
                                rows="4"
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;"></textarea>
                        </div>

                        <div class="col-12">
                            <label for="fechaNacimientoArtista" class="form-label" style="color: #FFFFFF;">Fecha de
                                Nacimiento</label>
                            <input type="date" class="form-control form-control-lg" id="fechaNacimientoArtista"
                                name="fecha_nacimiento"
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                        </div>

                        <div class="col-12">
                            <label for="paisOrigenArtista" class="form-label" style="color: #FFFFFF;">País de
                                Origen</label>
                            <input type="text" class="form-control form-control-lg" id="paisOrigenArtista"
                                name="pais_origen"
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                        </div>

                        <div class="col-12">
                            <label for="imagenArtista" class="form-label" style="color: #FFFFFF;">Imagen del Artista
                                (Opcional)</label>
                            <input type="file" class="form-control form-control-lg" id="imagenArtista" name="imagen"
                                accept="image/*"
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                        </div>

                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-lg px-5"
                                style="background-color: #1DB954; color: white; border-radius: 30px; font-weight: 600; transition: all 0.3s ease;">
                                Añadir Artista
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="formularioAñadirAlbum" class="card shadow-lg border-0 mb-4 formularioSeccion"
                style="display: none; border-radius: 8px;">
                <div class="card-header py-3"
                    style="background-color: #1DB954; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                    <h4 class="card-title mb-0 text-center text-white">Añadir Nuevo Álbum</h4>
                </div>
                <div class="card-body p-4">
                    <form id="form-album" onsubmit="return añadirAlbum(event)" method="POST"
                        enctype="multipart/form-data" class="row g-4">
                        <div class="col-md-12">
                            <label for="albumNombre" class="form-label" style="color: #FFFFFF;">Nombre del Álbum</label>
                            <input type="text" id="albumNombre" name="albumNombre" class="form-control form-control-lg"
                                required
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                        </div>
                        <div class="col-md-12">
                            <label for="artistaAlbum" class="form-label" style="color: #FFFFFF;">Artista</label>
                            <select id="artistaAlbum" name="artistaAlbum" class="form-select form-select-lg" required
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                                <option value="" disabled selected>Seleccione un artista</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="albumFechaLanzamiento" class="form-label" style="color: #FFFFFF;">Fecha de
                                Lanzamiento</label>
                            <input type="date" id="albumFechaLanzamiento" name="albumFechaLanzamiento"
                                class="form-control form-control-lg" required
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                        </div>
                        <div class="col-md-12">
                            <label for="albumImagen" class="form-label" style="color: #FFFFFF;">Carátula del
                                Álbum</label>
                            <input type="file" id="albumImagen" name="albumImagen" class="form-control form-control-lg"
                                accept="image/*" required
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                        </div>
                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-lg px-5"
                                style="background-color: #1DB954; color: white; border-radius: 30px; font-weight: 600; transition: all 0.3s ease;">
                                Añadir Álbum
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="formularioEliminarAlbum" class="card shadow-lg border-0 mb-4 formularioSeccion"
                style="display: none; border-radius: 8px;">
                <div class="card-header py-3"
                    style="background-color: rgba(255, 65, 54, 0.8); border-top-left-radius: 8px; border-top-right-radius: 8px;">
                    <h4 class="card-title mb-0 text-center text-white">Eliminar un Álbum</h4>
                </div>
                <div class="card-body p-4">
                    <form id="form-eliminar-album" onsubmit="return eliminarAlbum(event)" class="row g-4">
                        <div class="col-12">
                            <label for="albumEliminar" class="form-label" style="color: #FFFFFF;">Seleccionar Álbum a
                                Eliminar</label>
                            <select id="albumEliminar" class="form-select form-select-lg" name="albumEliminar" required
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                            </select>
                        </div>
                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-lg px-5"
                                style="background-color: rgba(255, 65, 54, 0.8); color: white; border-radius: 30px; font-weight: 600; transition: all 0.3s ease;">
                                Eliminar Álbum
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="formularioModificarAlbum" class="card shadow-lg border-0 mb-4 formularioSeccion"
                style="display: none; border-radius: 8px;">
                <div class="card-header py-3"
                    style="background-color: rgba(255, 220, 0, 0.8); border-top-left-radius: 8px; border-top-right-radius: 8px;">
                    <h4 class="card-title mb-0 text-center" style="color: #121212;">Modificar Álbum</h4>
                </div>
                <div class="card-body p-4">
                    <form id="form-modificar-album" onsubmit="return modificarAlbum(event)" method="POST"
                        enctype="multipart/form-data" class="row g-4">
                        <div class="col-md-12">
                            <label for="albumSeleccionado" class="form-label" style="color: #FFFFFF;">Seleccionar
                                Álbum</label>
                            <select id="albumSeleccionado" name="albumSeleccionado" class="form-select form-select-lg"
                                required
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                                <option value="" disabled selected>Seleccione un álbum</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="albumNombreModificar" class="form-label" style="color: #FFFFFF;">Nuevo Nombre
                                del Álbum</label>
                            <input type="text" id="albumNombreModificar" name="albumNombreModificar"
                                class="form-control form-control-lg" required
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                        </div>
                        <div class="col-md-12">
                            <label for="artistaAlbumModificar" class="form-label"
                                style="color: #FFFFFF;">Artista</label>
                            <select id="artistaAlbumModificar" name="artistaAlbumModificar"
                                class="form-select form-select-lg" required
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                                <option value="" disabled selected>Seleccione un artista</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="imagen" class="form-label" style="color: #FFFFFF;">Nueva Carátula del
                                Álbum</label>
                            <input type="file" id="imagen" name="imagen" class="form-control form-control-lg"
                                accept="image/*"
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                        </div>
                        
                        <div class="col-md-12">
                            <label for="albumFechaLanzamientoModificar" class="form-label" style="color: #FFFFFF;">Nueva
                                Fecha de Lanzamiento</label>
                            <input type="date" id="albumFechaLanzamientoModificar" name="albumFechaLanzamientoModificar"
                                class="form-control form-control-lg"
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                        </div>
                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-lg px-5"
                                style="background-color: rgba(255, 220, 0, 0.8); color: black; border-radius: 30px; font-weight: 600; transition: all 0.3s ease;">
                                Modificar Álbum
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="formularioModificarArtista" class="card shadow-lg border-0 mb-4 formularioSeccion"
                style="display: none; border-radius: 8px;">
                <div class="card-header py-3"
                    style="background-color: rgba(255, 220, 0, 0.8); border-top-left-radius: 8px; border-top-right-radius: 8px;">
                    <h4 class="card-title mb-0 text-center" style="color: #121212;">Modificar Artista</h4>
                </div>
                <div class="card-body p-4">
                    <form id="form-modificar-artista" onsubmit="return modificarArtista(event)" method="POST"
                        enctype="multipart/form-data" class="row g-4">

                        <div class="col-md-12">
                            <label for="selectArtistaModificar" class="form-label" style="color: #FFFFFF;">Seleccionar
                                Artista</label>
                            <select id="selectArtistaModificar" name="id" class="form-select form-select-lg" required
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                                <option value="" disabled selected>Seleccione un artista</option>
                                
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label for="nombreArtistaModificar" class="form-label" style="color: #FFFFFF;">Nuevo Nombre
                                del Artista</label>
                            <input type="text" id="nombreArtistaModificar" name="nombre"
                                class="form-control form-control-lg" required
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                        </div>

                        <div class="col-md-12">
                            <label for="biografiaArtistaModificar" class="form-label"
                                style="color: #FFFFFF;">Biografía</label>
                            <textarea id="biografiaArtistaModificar" name="biografia"
                                class="form-control form-control-lg"
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;"></textarea>
                        </div>

                        <div class="col-md-12">
                            <label for="fechaNacimientoArtistaModificar" class="form-label"
                                style="color: #FFFFFF;">Fecha de Nacimiento</label>
                            <input type="date" id="fechaNacimientoArtistaModificar" name="fechaNacimiento"
                                class="form-control form-control-lg"
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                        </div>

                        <div class="col-md-12">
                            <label for="paisOrigenArtistaModificar" class="form-label" style="color: #FFFFFF;">País de
                                Origen</label>
                            <input type="text" id="paisOrigenArtistaModificar" name="paisOrigen"
                                class="form-control form-control-lg"
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                        </div>

                        <div class="col-md-12">
                            <label for="imagenArtistaModificar" class="form-label" style="color: #FFFFFF;">Nueva Imagen
                                del Artista</label>
                            <input type="file" id="imagenArtistaModificar" name="imagen"
                                class="form-control form-control-lg" accept="image/*"
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                        </div>

                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-lg px-5"
                                style="background-color: rgba(255, 220, 0, 0.8); color: black; border-radius: 30px; font-weight: 600; transition: all 0.3s ease;">
                                Modificar Artista
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="formularioEliminarArtista" class="card shadow-lg border-0 mb-4 formularioSeccion"
                style="display: none; border-radius: 8px;">
                <div class="card-header py-3"
                    style="background-color: rgba(255, 65, 54, 0.8); border-top-left-radius: 8px; border-top-right-radius: 8px;">
                    <h4 class="card-title mb-0 text-center text-white">Eliminar Artista</h4>
                </div>
                <div class="card-body p-4">
                    <form id="form-eliminar-artista" onsubmit="return eliminarArtista(event)" class="row g-4">
                        <div class="col-12">
                            <label for="artistaEliminar" class="form-label" style="color: #FFFFFF;">Seleccionar Artista
                                a Eliminar</label>
                            <select id="artistaEliminar" class="form-select form-select-lg" name="id" required
                                style="background-color: #333333; color: #FFFFFF; border: none; border-radius: 4px;">
                                <option value="" disabled selected>Seleccione un artista</option>
                            </select>
                        </div>
                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-lg px-5"
                                style="background-color: rgba(255, 65, 54, 0.8); color: white; border-radius: 30px; font-weight: 600; transition: all 0.3s ease;">
                                Eliminar Artista
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="formularioMostrarArtistas" class="card shadow-lg border-0 mb-4 formularioSeccion"
                style="display: none; border-radius: 8px;">
                <div class="card-header py-3"
                    style="background-color: #222222; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                    <h4 class="card-title mb-0 text-center">Lista de Artistas</h4>
                </div>
                <div class="card-body p-4">
                    <div id="listaArtistasAdmin" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

                    </div>
                </div>
            </div>

            <div id="formularioMostrarAlbumes" class="card shadow-lg border-0 mb-4 formularioSeccion"
                style="display: none; border-radius: 8px;">
                <div class="card-header py-3"
                    style="background-color: #222222; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                    <h4 class="card-title mb-0 text-center">Lista de Álbumes</h4>
                </div>
                <div class="card-body p-4">
                    <div id="listaAlbumesAdmin" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

                    </div>
                </div>
            </div>

            <div id="formularioMostrarCanciones" class="card shadow-lg border-0 mb-4 formularioSeccion"
                style="display: none; border-radius: 8px;">
                <div class="card-header py-3"
                    style="background-color: #222222; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                    <h4 class="card-title mb-0 text-center">Lista de Canciones</h4>
                </div>
                <div class="card-body p-4">
                    <div id="listaCancionesAdmin" class="row row-cols-1 g-4">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
