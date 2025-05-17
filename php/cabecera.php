<header id="cabecera" class="fixed-top shadow-sm" style="z-index: 1000; background-color: var(--color-oscuro);">
    <nav class="navbar navbar-dark shadow-sm">
        <div class="container-fluid">
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand d-flex align-items-center mx-auto">
                <span class="fw-bold me-1 text-white">Bienvenido,</span> 
                <span id="usuario-nombre" class="fw-bold" style="color: var(--color-primario); transition: color 0.3s ease;"></span>
            </a>
            <div class="offcanvas offcanvas-start text-white" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel" style="background-color: var(--color-oscuro) !important;">
                <div class="offcanvas-header border-bottom" style="border-color: var(--color-oscuro) !important;">
                    <h5 class="offcanvas-title fw-bold d-flex align-items-center" id="offcanvasNavbarLabel">
                        Menú Principal
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body" style="background-color: var(--color-oscuro) !important;">
                    <ul class="navbar-nav justify-content-start flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link active d-flex align-items-center gap-2 py-3 hover-effect" href="#"
                                onclick="cargarInicio()" style="color: white !important;">
                                <i class="fas fa-home fs-5" style="color: var(--color-primario) !important;"></i>
                                Inicio
                            </a>
                        </li>
                        <li class="nav-item dropdown mt-2">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 py-3 hover-effect" href="#"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: white !important;">
                                <i class="fas fa-user-circle fs-5" style="color: var(--color-primario) !important;"></i>
                                Mi Cuenta
                            </a>
                            <ul class="dropdown-menu border-0 shadow-sm" style="background-color: var(--color-oscuro) !important;">
                                <li>
                                    <a class="dropdown-item text-white d-flex align-items-center gap-2 py-2 hover-effect" href="#"
                                        onclick="cargarMiPerfil(event)" style="color: white !important;">
                                        <i class="fas fa-id-card" style="color: var(--color-primario) !important;"></i>
                                        Mi Perfil
                                    </a>
                                </li>
                                <li class="nav-item" id="admin-nav-item" style="display: none;">
                                    <a class="dropdown-item text-white d-flex align-items-center gap-2 py-2 hover-effect" href="#"
                                        onclick="cargarAdministracion()" style="color: white !important;">
                                        <i class="fas fa-tools" style="color: var(--color-primario) !important;"></i>
                                        Administración
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider" style="border-color: var(--color-oscuro) !important;"></li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2 py-2 hover-effect" href="#"
                                        onclick="cerrarSesion()" style="color: var(--color-peligro) !important;">
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
