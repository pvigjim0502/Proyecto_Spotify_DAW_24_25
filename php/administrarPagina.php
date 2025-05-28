<div id="contenidoAdministracion" class="container-fluid py-5" style="display: none; background-color: #121212; color: #FFFFFF;">
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
