<header id="cabecera" class="fixed-top shadow-sm">
        <nav class="navbar navbar-dark">
            <div class="container-fluid">
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <a class="navbar-brand d-flex align-items-center mx-auto">
                    <span class="fw-bold me-1 text-white">Bienvenido,</span> 
                    <span id="usuario-nombre" class="fw-bold"></span>
                </a>
                
                <div class="offcanvas offcanvas-start text-white" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header border-bottom">
                        <h5 class="offcanvas-title fw-bold d-flex align-items-center" id="offcanvasNavbarLabel">
                            Menú Principal
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-start flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link active d-flex align-items-center gap-2 py-3" href="#" onclick="cargarInicio()">
                                    <i class="fas fa-home fs-5"></i>
                                    Inicio
                                </a>
                            </li>
                            <li class="nav-item dropdown mt-2">
                                <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 py-3" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle fs-5"></i>
                                    Mi Cuenta
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#" onclick="cargarMiPerfil(event)">
                                            <i class="fas fa-id-card"></i>
                                            Mi Perfil
                                        </a>
                                    </li>
                                    <li id="admin-nav-item" style="display: none;">
                                        <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#" onclick="cargarAdministracion()">
                                            <i class="fas fa-tools"></i>
                                            Administración
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger" href="#" onclick="cerrarSesion()">
                                            <i class="fas fa-sign-out-alt"></i>
                                            Cerrar Sesión
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>