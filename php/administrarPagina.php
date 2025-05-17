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
