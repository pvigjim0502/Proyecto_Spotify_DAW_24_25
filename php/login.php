<div class="container d-flex justify-content-center align-items-center mt-5 pt-5">
    <!-- formulario de inicio de sesion -->
    <div id="formularioLogin" class="card p-4 mx-auto" style="max-width: 400px; width: 100%; border-radius: 10px;">
        <div class="card-body">
            <h5 class="text-center mb-4" style="color: var(--color-primario);">Iniciar Sesión</h5>
            <div class="mb-3">
                <label for="nombreUsuario" class="form-label">Usuario:</label>
                <input type="text" class="form-control search-input" id="nombreUsuario" placeholder="Introduzca usuario"
                    name="nombreUsuario" required>
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña:</label>
                <div class="input-group">
                    <input type="password" class="form-control search-input" id="contrasena" placeholder="Introduzca contraseña"
                        name="contrasena" required>
                </div>
            </div>
            <button type="button" class="btn btn-music w-100 mt-3" onclick="iniciarSesion()">
                Entrar
            </button>
            <div id="mensaje-error" class="text-danger mt-3"></div>
            <p class="text-center mt-3">
                <a href="#" class="text-primary" onclick="mostrarOlvidoContrasena()" style="color: var(--color-primario) !important;">¿Olvidaste tu contraseña?</a>
            </p>
        </div>
        <!-- footer con opcion de registro -->
        <div class="card-footer text-center" style="background-color: #121212; border-top: 1px solid #2A2A2A;">
            <p class="mb-0">
                ¿No tienes una cuenta?
                <a href="#" style="color: var(--color-primario) !important;" onclick="mostrarRegistro()">Regístrate</a>
            </p>
        </div>
    </div>

    <!-- formulario para recuperar contrasena olvidada (oculto inicialmente) -->
    <div id="formularioOlvidoContrasena" class="card p-4 mx-auto"
        style="max-width: 400px; width: 100%; border-radius: 10px; display: none;">
        <div class="card-body">
            <h5 class="text-center mb-4" style="color: var(--color-primario);">Recuperar Contraseña</h5>
            <div class="mb-3">
                <label for="emailOlvido" class="form-label">Correo:</label>
                <input type="email" class="form-control search-input" id="emailOlvido" placeholder="Introduzca correo"
                    name="emailOlvido" required>
            </div>
            <button type="button" class="btn btn-music w-100 mt-3" onclick="enviarCorreoRecuperacion()">
                Enviar enlace
            </button>
            <div id="mensaje-error-recuperacion" class="text-danger mt-3"></div>
        </div>
        <!-- footer con opcion de volver al login -->
        <div class="card-footer text-center" style="background-color: #121212; border-top: 1px solid #2A2A2A;">
            <p class="mb-0">
                ¿Ya recuerdas tu contraseña?
                <a href="#" style="color: var(--color-primario) !important;" onclick="mostrarLogin()">Inicia Sesión</a>
            </p>
        </div>
    </div>

    <!-- formulario de registro -->
    <div id="formularioRegistro" class="card p-4 mx-auto"
        style="max-width: 400px; width: 100%; border-radius: 10px; display: none;">
        <div class="card-body">
            <h5 class="text-center mb-4" style="color: var(--color-primario);">Registrarse</h5>
            <div class="mb-3">
                <label for="nuevoUsuario" class="form-label">Usuario:</label>
                <input type="text" class="form-control search-input" id="nuevoUsuario" placeholder="Introduzca usuario"
                    name="nuevoUsuario" required>
            </div>
            <div class="mb-3">
                <label for="nuevoCorreo" class="form-label">Correo:</label>
                <input type="email" class="form-control search-input" id="nuevoCorreo" placeholder="Introduzca correo"
                    name="nuevoCorreo" required>
            </div>
            <div class="mb-3">
                <label for="nuevaContrasena" class="form-label">Contraseña:</label>
                <div class="input-group">
                    <input type="password" class="form-control search-input" id="nuevaContrasena" placeholder="Introduzca contraseña"
                        name="nuevaContrasena" required>
                </div>
            </div>
            <button type="button" class="btn btn-music w-100 mt-3" onclick="registrarUsuario()">
                Registrarse
            </button>
            <div id="mensaje-registro-error" class="text-danger mt-3"></div>
        </div>
        <!-- footer con opcion de volver al login -->
        <div class="card-footer text-center" style="background-color: #121212; border-top: 1px solid #2A2A2A;">
            <p class="mb-0">
                ¿Ya tienes una cuenta?
                <a href="#" style="color: var(--color-primario) !important;" onclick="mostrarLogin()">Inicia Sesión</a>
            </p>
        </div>
    </div>
</div>
