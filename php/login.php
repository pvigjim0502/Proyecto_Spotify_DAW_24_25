<div class="container d-flex justify-content-center align-items-center mt-5 pt-5">
    <!-- formulario de inicio de sesión -->
    <div id="formularioLogin" class="card p-4 mx-auto" class="max-width-400px w-100 border-radius-10">
        <div class="card-body">
            <h5 class="text-center mb-4">Iniciar Sesión</h5>
            <div class="mb-3">
                <label for="nombreUsuario" class="form-label">Usuario:</label>
                <input type="text" class="form-control" id="nombreUsuario" placeholder="Introduzca usuario"
                    name="nombreUsuario" required>
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña:</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="contrasena" placeholder="Introduzca contraseña"
                        name="contrasena" required>
                </div>
            </div>
            <button type="button" class="btn btn-primary w-100 mt-3" onclick="iniciarSesion()">Entrar</button>
            <div id="mensaje-error" class="text-danger mt-3"></div>

            <p class="text-center mt-3">
                <a href="#" class="text-primary" onclick="mostrarOlvidoContrasena()">¿Olvidaste tu contraseña?</a>
            </p>
        </div>
        <!-- footer con opción de registro -->
        <div class="card-footer text-center">
            <p class="mb-0">
                ¿No tienes una cuenta?
                <a href="#" class="text-primary" onclick="mostrarRegistro()">Regístrate</a>
            </p>
        </div>
    </div>

    <!-- formulario para recuperar contraseña olvidada (oculto inicialmente) -->
    <div id="formularioOlvidoContrasena" class="card p-4 mx-auto" class="max-width-400px w-100 border-radius-10 d-none">
        <div class="card-body">
            <h5 class="text-center mb-4">Recuperar Contraseña</h5>
            <div class="mb-3">
                <label for="emailOlvido" class="form-label">Correo:</label>
                <input type="email" class="form-control" id="emailOlvido" placeholder="Introduzca correo"
                    name="emailOlvido" required>
            </div>
            <button type="button" class="btn btn-primary w-100 mt-3" onclick="enviarCorreoRecuperacion()">Enviar
                enlace</button>
            <div id="mensaje-error-recuperacion" class="text-danger mt-3"></div>
        </div>
        <!-- footer con opción de volver al login -->
        <div class="card-footer text-center">
            <p class="mb-0">
                ¿Ya recuerdas tu contraseña?
                <a href="#" class="text-primary" onclick="mostrarLogin()">Inicia Sesión</a>
            </p>
        </div>
    </div>

    <!-- formulario de registro-->
    <div id="formularioRegistro" class="card p-4 mx-auto" class="max-width-400px w-100 border-radius-10 d-none">
        <div class="card-body">
            <h5 class="text-center mb-4">Registrarse</h5>
            <div class="mb-3">
                <label for="nuevoUsuario" class="form-label">Usuario:</label>
                <input type="text" class="form-control" id="nuevoUsuario" placeholder="Introduzca usuario"
                    name="nuevoUsuario" required>
            </div>
            <div class="mb-3">
                <label for="nuevoCorreo" class="form-label">Correo:</label>
                <input type="email" class="form-control" id="nuevoCorreo" placeholder="Introduzca correo"
                    name="nuevoCorreo" required>
            </div>
            <div class="mb-3">
                <label for="nuevaContrasena" class="form-label">Contraseña:</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="nuevaContrasena" placeholder="Introduzca contraseña"
                        name="nuevaContrasena" required>
                </div>
            </div>
            <button type="button" class="btn btn-primary w-100 mt-3" onclick="registrarUsuario()">Registrarse</button>
            <div id="mensaje-registro-error" class="text-danger mt-3"></div>
        </div>
        <!-- footer con opción de volver al login -->
        <div class="card-footer text-center">
            <p class="mb-0">
                ¿Ya tienes una cuenta?
                <a href="#" class="text-primary" onclick="mostrarLogin()">Inicia Sesión</a>
            </p>
        </div>
    </div>
</div>
