<div id="pagina-inicio" class="container-fluid py-5 px-lg-5" style="display: none;">

    <!-- seccion de busqueda -->
    <div class="row justify-content-center mb-5" id="buscador" style="position: relative;">
        <div class="col-lg-8 col-xl-6">
            <div class="card shadow-sm border-0 rounded-4" style="background-color: #121212;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <form id="formBuscador" class="mb-0 d-flex flex-grow-1">
                            <div class="input-group input-group-lg flex-grow-1">
                                <span class="input-group-text" style="background-color: transparent; border: 0;">
                                    <i class="fas fa-search" style="color: #b3b3b3;"></i>
                                </span>
                                <input type="text" id="buscar" class="form-control form-control-lg border-0"
                                    style="background-color: transparent; color: #ffffff; outline: none; box-shadow: none;"
                                    placeholder="Encuentra tu música favorita..." aria-label="busqueda de musica"
                                    oninput="buscarTodo()">

                                <button class="btn btn-link border-0" type="button" style="color: #b3b3b3;"
                                    onclick="limpiarBusqueda()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="resultadosBusqueda" class="card shadow-sm border-0 rounded-4 mt-1"
                style="display: none; position: absolute; z-index: 1000; width: 100%; top: 100%; left: 0; max-height: 400px; overflow-y: auto; background-color: #121212; color: #ffffff;">
                <div class="card-body p-4" id="contenedorResultados"></div>
            </div>
        </div>
    </div>
    
    <!-- seccion de albumes -->
    <div class="row d-flex justify-content-center align-items-center">
        <div id="contenedorAlbum" class="row g-4 justify-content-center">
            <!-- aqui iran los albumes cargados -->
        </div>

        <div id="contenedorCanciones" class="row" style="display: none;">
            <div class="col-12">
                <!-- aqui iran las canciones cargadas -->
            </div>
        </div>

        <!-- separador -->
        <hr class="my-5">

        <!-- seccion de artistas -->
        <div id="contenedorArtistas">
            <!-- aqui se generaran los slides de los artistas -->
        </div>

    </div>    
</div>
