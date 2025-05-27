// funcion para mostrar mensajes de aviso en pantalla
function mostrarToast(mensaje, tipo) {
    var configuracion = { icono: '❌', clase: 'bg-danger' };
    var tiposValidos = ['exito', 'error'];

    // revisamos que tipo de mensaje es para poner el icono correcto
    for (var i = 0; i < tiposValidos.length; i++) {
        if (tiposValidos[i] === tipo) {
            if (tipo === 'exito') {
                configuracion = { icono: '✅', clase: 'bg-success' };
            }
            break;
        }
    }

    var toast = document.getElementById('toast-success');
    var clasesToast = toast.classList;

    // quitamos cualquier color de fondo que tenga antes
    for (var j = 0; j < clasesToast.length; j++) {
        if (clasesToast[j].indexOf('bg-') !== -1) {
            toast.classList.remove(clasesToast[j]);
        }
    }

    // ponemos la nueva configuracion
    toast.classList.add(configuracion.clase);
    document.getElementById('toast-icon').textContent = configuracion.icono;
    document.getElementById('toast-text').textContent = mensaje;

    // ponemos la primera letra en mayuscula
    var titulo = tipo.charAt(0).toUpperCase() + tipo.slice(1);
    document.getElementById('toast-title').textContent = titulo + ': ';

    // mostramos el mensaje en pantalla
    new bootstrap.Toast(toast).show();
}

// funcion para enviar correo de recuperacion de contraseña
function enviarCorreoRecuperacion() {
    var email = document.getElementById('emailOlvido').value;
    alert('Correo enviado a ' + email + ' con instrucciones de recuperación.');
}

// funcion para mostrar la pantalla de login
function mostrarLogin() {
    document.getElementById('formularioRegistro').style.display = 'none';
    document.getElementById('formularioLogin').style.display = 'block';
    document.getElementById('formularioOlvidoContrasena').style.display = 'none';
}

// funcion para mostrar la pantalla de registro
function mostrarRegistro() {
    document.getElementById('formularioLogin').style.display = 'none';
    document.getElementById('formularioRegistro').style.display = 'block';
    document.getElementById('formularioOlvidoContrasena').style.display = 'none';
}

// funcion para mostrar la pantalla de olvide mi contraseña
function mostrarOlvidoContrasena() {
    document.getElementById('formularioLogin').style.display = 'none';
    document.getElementById('formularioOlvidoContrasena').style.display = 'block';
    document.getElementById('formularioRegistro').style.display = 'none';
}

// funcion para mostrar los albumes en la pagina
function mostrarAlbumes(albums) {
    var contenedor = document.getElementById('contenedorAlbum');

    // comprobamos si existe el contenedor
    if (!contenedor) {
        console.error("No se encontró el contenedor de álbumes.");
        return;
    }

    // borramos todo lo que hubiera antes
    while (contenedor.firstChild) {
        contenedor.removeChild(contenedor.firstChild);
    }

    // creamos el contenedor para el carrusel
    var swiperContainer = document.createElement('div');
    swiperContainer.className = 'album-container w-100';

    swiperContainer.innerHTML = `
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                ${albums.map(album => `
                    <div class="swiper-slide">
                        <div class="card h-100 shadow-lg border-0 rounded-4 overflow-hidden">
                            <div class="position-relative">
                                <img src="${album.CARATULA}" class="card-img-top img-fluid rounded-top album-img" alt="${album.NOMBRE}">
                                <div class="vista-previa p-3">
                                    <h5 class="fw-bold">${album.NOMBRE}</h5>
                                    <p class="mb-1"><strong>Artista:</strong> ${album.ARTISTA}</p>
                                    <p class="mb-1"><strong>Fecha:</strong> ${album.FECHA_LANZAMIENTO}</p>
                                    <p class="mb-0"><strong>Canciones:</strong> ${album.canciones.length}</p>
                                </div>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-between p-4">
                                <h5 class="card-title fw-bold mb-3 text-truncate">${album.NOMBRE}</h5>
                                <button class="btn-music btn btn-primary btn-lg w-100 rounded-pill shadow-sm fw-semibold"
                                        type="button"
                                        onclick="cargarCanciones(${album.CODALBUM})">
                                    <i class="bi bi-music-note-list me-2"></i> Ver canciones
                                </button>
                            </div>
                        </div>
                    </div>
                `).join('')}
            </div>
        </div>
    `;

    // agregamos el carrusel a la pagina
    contenedor.appendChild(swiperContainer);

    // ajustamos los estilos para que se vea bien
    contenedor.style.display = 'flex';
    contenedor.style.flexDirection = 'column';
    contenedor.style.width = '100%';
    contenedor.style.minHeight = '400px';

    // iniciamos el carrusel con sus opciones
    new Swiper('.mySwiper', {
        slidesPerView: 4,
        spaceBetween: 20,
        loop: true,
        centeredSlides: false,
        autoHeight: false,
        breakpoints: {
            1024: { slidesPerView: 4 },
            768: { slidesPerView: 2 },
            480: { slidesPerView: 1 }
        },
        navigation: false,
        pagination: false,
    });

    // ajustamos los estilos del carrusel
    const swiperElement = document.querySelector('.mySwiper');
    if (swiperElement) {
        swiperElement.style.width = '100%';
        swiperElement.style.height = '100%';
    }
}

// guardamos el id del album que estamos viendo
var albumSeleccionadoId = 0;

// funcion para mostrar el detalle de un album con sus canciones
function mostrarDetalleAlbum(album) {
    var contenedorCanciones = document.getElementById('contenedorCanciones');
    var contenedorAlbum = document.getElementById('contenedorAlbum');
    var contenedorArtistas = document.getElementById('contenedorArtistas');
    var buscador = document.getElementById('buscador');

    // ajustamos los estilos del contenedor
    contenedorCanciones.className = 'container-fluid p-0';
    document.body.style.backgroundColor = 'var(--fondo-body)';

    // creamos el encabezado con los datos del album
    var htmlCabecera = `
        <div class="position-relative mb-5">
            <div class="position-absolute w-100 h-100" style="
                background: linear-gradient(to bottom, rgba(0,0,0,0.7), var(--fondo-body)),
                url('${album.CARATULA}') no-repeat center center;
                background-size: cover;
                filter: blur(8px);
                z-index: 0;
            "></div>
            <div class="container-fluid position-relative py-5" style="z-index: 1;">
                <div class="d-flex justify-content-between align-items-center mb-5 px-4">
                    <button class="btn btn-outline-light rounded-pill px-4" onclick="irAtras()">
                        <i class="fas fa-arrow-left me-2"></i>Volver atrás
                    </button>
                    <div class="badge rounded-pill px-4 py-2" style="background-color: var(--color-primario); color: var(--color-claro);">
                        <i class="fas fa-music me-2"></i>${album.canciones ? album.canciones.length : 0} canciones
                    </div>
                </div>
                <div class="row align-items-center g-5 px-4">
                    <div class="col-lg-4">
                        <img id="albumCaratula"
                             src="${album.CARATULA}"
                             class="img-fluid rounded-4 shadow-lg"
                             alt="${album.NOMBRE}"
                             style="width: 100%; aspect-ratio: 1/1; object-fit: cover;">
                    </div>
                    <div class="col-lg-8" style="color: var(--color-texto-body);">
                        <h1 class="display-4 fw-bold mb-3">${album.NOMBRE}</h1>
                        <div class="d-flex align-items-center gap-4 mb-4">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-circle fs-1 me-3" style="color: var(--color-secundario);"></i>
                                <div>
                                    <p class="mb-0" style="color: var(--color-secundario);">Artista</p>
                                    <h2 class="h4 mb-0">${album.ARTISTA || 'Anónimo'}</h2>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar-alt fs-1 me-3" style="color: var(--color-secundario);"></i>
                                <div>
                                    <p class="mb-0" style="color: var(--color-secundario);">Lanzamiento</p>
                                    <h2 class="h4 mb-0">${album.FECHA_LANZAMIENTO}</h2>
                                </div>
                            </div>
                        </div>
                        <p class="lead mb-4">${album.BIOGRAFIA || 'Biografía no disponible'}</p>
                    </div>
                </div>
            </div>
        </div>`;

    // creamos el contenido principal con la lista de canciones
    var htmlContenidoPrincipal = `
        <div class="container-fluid px-4 pb-5">
            <div class="grid-container">
                <div class="canciones-col">
                    <div class="card shadow-lg rounded-4 border-0 overflow-hidden" style="background-color: transparent;">
                        <div class="card-header bg-transparent border-0 p-4 pb-2">
                            <h3 class="h4 fw-bold mb-0 pb-2 d-inline-block" style="color: var(--color-texto-body); border-bottom: 3px solid var(--color-primario) !important;">Lista de canciones</h3>
                        </div>
                        <div class="card-body p-0">`;

    // agregamos cada cancion a la lista
    if (album.canciones && album.canciones.length > 0) {
        for (var i = 0; i < album.canciones.length; i++) {
            var cancion = album.canciones[i];

            // formateamos el numero
            var numero = i + 1;
            var numeroFormateado = '';
            if (numero < 10) {
                numeroFormateado = '0' + numero;
            } else {
                numeroFormateado = '' + numero;
            }

            // reemplazamos los _ por espacios sin usar replace
            var nombreCancion = cancion.NOMBRE.split('_').join(' ');

            htmlContenidoPrincipal += `
            <div class="d-flex align-items-center p-4 border-bottom" style="border-color: rgba(255,255,255,0.1) !important;">
                <div class="d-flex align-items-center w-100 gap-3">
                    <span class="h5 fw-bold mb-0 text-center" style="color: var(--color-secundario); width: 40px; font-family: var(--bs-font-monospace);">
                        ${numeroFormateado}
                    </span>

                    <img src="${cancion.IMAGEN}"
                        alt="${nombreCancion}"
                        class="rounded-3 shadow-sm flex-shrink-0"
                        style="width: 64px; height: 64px; object-fit: cover;">

                    <div class="text-truncate" style="width: 30%; min-width: 150px;">
                        <h4 class="h6 fw-bold mb-1 text-truncate" style="color: var(--color-texto-body);">${nombreCancion}</h4>
                        <p class="small mb-0" style="color: var(--color-secundario);">Pista ${i + 1}</p>
                    </div>

                    <div class="flex-grow-1 ms-3" style="min-width: 200px; max-width: 500px;">
                        <audio id="audio-${i}"
                            class="w-100 rounded-pill"
                            controls
                            style="background-color: rgba(255,255,255,0.1);">
                            <source src="${cancion.AUDIO}" type="audio/mp3">
                        </audio>
                    </div>
                </div>
            </div>`;
        }
    } else {
        // mensaje si no hay canciones
        htmlContenidoPrincipal += `
            <div class="alert m-4" style="background-color: rgba(29, 185, 84, 0.1); color: var(--color-primario); border-radius: 1rem;">
                <div class="text-center py-5">
                    <i class="fas fa-exclamation-circle fs-1 mb-4 opacity-75"></i>
                    <h2 class="fw-bold mb-3" style="color: var(--color-texto-body);">No hay canciones disponibles</h2>
                    <p class="lead opacity-75 mb-0" style="color: var(--color-secundario);">Este álbum no tiene canciones registradas.</p>
                </div>
            </div>`;
    }

    // terminamos el html del contenido principal
    htmlContenidoPrincipal += `
                        </div>
                    </div>
                </div>

                <div class="artista-col">
                    <div class="card shadow-lg rounded-4 border-0 mb-4">
                        <div class="card-header border-0 p-4" style="background: linear-gradient(to right, var(--color-primario), transparent 100%);">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="h4 fw-bold mb-0" style="color: var(--color-texto-body);">Perfil del artista</h3>
                                <span class="badge rounded-pill px-3 py-2" style="background-color: rgba(29, 185, 84, 0.2); color: var(--color-primario);">Verificado</span>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <img src="${album.IMAGEN_ARTISTA || 'assets/img/default-artist.jpg'}"
                                     alt="${album.ARTISTA || 'Artista'}"
                                     class="img-fluid shadow-sm me-4"
                                     style="width: 120px; height: 120px; object-fit: cover; border-radius: 12px;">
                                <div>
                                    <h4 class="h5 fw-bold mb-1" style="color: var(--color-texto-body);">${album.ARTISTA || 'Anónimo'}</h4>
                                </div>
                            </div>


                            <div class="row row-cols-1 g-3 mb-4">
                                <div class="col">
                                    <div class="d-flex align-items-center p-3 rounded-4" style="background-color: rgba(255,255,255,0.05);">
                                        <div class="p-3 rounded-3 me-3" style="background-color: rgba(29, 185, 84, 0.1);">
                                            <i class="fas fa-globe fs-5" style="color: var(--color-primario);"></i>
                                        </div>
                                        <div>
                                            <p class="small mb-0" style="color: var(--color-secundario);">País de origen</p>
                                            <h5 class="fw-bold mb-0" style="color: var(--color-texto-body);">${album.PAIS_ORIGEN || 'No disponible'}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="d-flex align-items-center p-3 rounded-4" style="background-color: rgba(255,255,255,0.05);">
                                        <div class="p-3 rounded-3 me-3" style="background-color: rgba(29, 185, 84, 0.1);">
                                            <i class="fas fa-calendar-day fs-5" style="color: var(--color-primario);"></i>
                                        </div>
                                        <div>
                                            <p class="small mb-0" style="color: var(--color-secundario);">Fecha de nacimiento</p>
                                            <h5 class="fw-bold mb-0" style="color: var(--color-texto-body);">${album.FECHA_NACIMIENTO || 'No disponible'}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="comentarios-col">
                    <div class="card shadow-lg rounded-4 border-0" style="background-color: transparent;">
                        <div class="card-header border-0 p-4">
                            <h3 class="h4 fw-bold mb-0" style="color: var(--color-texto-body);">Comentarios</h3>
                        </div>
                        <div class="card-body p-4">
                            <div id="listaComentarios" class="mb-4">
                                <div class="comment-placeholder-animation">
                                    <div class="placeholder-glow mb-4">
                                        <div class="d-flex mb-3">
                                            <div class="placeholder col-2 rounded-circle me-3" style="height: 45px; background-color: rgba(255,255,255,0.1);"></div>
                                            <div class="flex-grow-1">
                                                <div class="placeholder col-4 mb-2" style="background-color: rgba(255,255,255,0.1);"></div>
                                                <div class="placeholder col-12 mb-2" style="background-color: rgba(255,255,255,0.1);"></div>
                                                <div class="placeholder col-8" style="background-color: rgba(255,255,255,0.1);"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="border-top pt-4" style="border-color: rgba(255,255,255,0.1) !important;">
                                <div class="d-flex align-items-start">
                                    <img src="assets/img/usuario/usuario.png" class="rounded-circle me-3" style="width: 45px; height: 45px; object-fit: cover;">
                                    <div class="flex-grow-1">
                                        <textarea id="comentarioInput"
                                                  class="form-control mb-2"
                                                  rows="3"
                                                  style="background-color: rgba(255,255,255,0.1); color: var(--color-texto-body); border: none;"></textarea>
                                        <div class="text-end">
                                            <button class="btn rounded-pill px-4" onclick="publicarComentario()" style="background-color: var(--color-primario); color: var(--color-claro);">
                                                <i class="fas fa-paper-plane me-2"></i>Publicar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;

    // unimos el encabezado y el contenido principal
    contenedorCanciones.innerHTML = htmlCabecera + htmlContenidoPrincipal;
    cargarComentarios(albumSeleccionadoId);

    // mostramos solo la seccion de canciones
    contenedorCanciones.style.display = 'block';
    contenedorAlbum.style.display = 'none';
    contenedorArtistas.style.display = 'none';
    buscador.style.display = 'none';
}

// funcion para volver a la pagina anterior
function irAtras() {
    document.getElementById('contenedorCanciones').style.display = 'none';
    document.getElementById('contenedorAlbum').style.display = 'flex';
    document.getElementById('contenedorArtistas').style.display = 'flex';
    document.getElementById('buscador').style.display = 'flex';
}

// funcion para crear una tabla con datos
function crearTabla(titulos, data, dibujarFila) {
    // creo la tabla
    var tabla = document.createElement('table');
    tabla.className = 'table table-bordered table-striped';

    // creo la cabecera
    var thead = document.createElement('thead');
    var headerRow = document.createElement('tr');

    // añado cada texto de cabecera
    for (var i = 0; i < titulos.length; i++) {
        var th = document.createElement('th');
        th.textContent = titulos[i];
        headerRow.appendChild(th);
    }

    thead.appendChild(headerRow);
    tabla.appendChild(thead);

    // creo el cuerpo de la tabla
    var tbody = document.createElement('tbody');

    // para cada elemento de datos, creo una fila
    for (var j = 0; j < data.length; j++) {
        var fila = document.createElement('tr');
        dibujarFila(fila, data[j]);
        tbody.appendChild(fila);
    }

    tabla.appendChild(tbody);

    return tabla;
}

// funcion para mostrar una tabla en un contenedor
function mostrarTabla(contenedorId, tabla) {
    // busco el contenedor y limpio su contenido
    var contenedor = document.getElementById(contenedorId);
    contenedor.innerHTML = '';

    // añado la tabla al contenedor
    contenedor.appendChild(tabla);
}

// funcion para mostrar una tabla en un contenedor
function mostrarTabla(contenedorId, tabla) {
    // busco el contenedor y limpio su contenido
    var contenedor = document.getElementById(contenedorId);
    contenedor.innerHTML = '';

    // añado la tabla al contenedor
    contenedor.appendChild(tabla);
}

// funcion para cargar la pagina de inicio
function cargarInicio(evento) {
    // si hay un evento, lo detengo
    if (evento) {
        evento.preventDefault();
    }

    // oculto y muestro las secciones necesarias
    document.getElementById('contenidoPerfil').style.display = 'none';
    document.getElementById('pagina-inicio').style.display = 'block';
    document.getElementById('contenedorCanciones').style.display = 'none';
    document.getElementById('contenedorArtistas').style.display = 'block';
    document.getElementById('contenidoAdministracion').style.display = 'none'

    // cargo la musica
    cargarMusica();

    // si existe el contenedor de musica y esta visible, me aseguro que siga visible
    var contenedorMusica = document.getElementById('contenedor-musica');
    if (contenedorMusica && contenedorMusica.style.display === 'block') {
        contenedorMusica.style.display = 'block';
    }

    // guardo la ultima pagina visitada en una cookie
    crearCookie('ultimaPagina', 'inicio', 7);
}
