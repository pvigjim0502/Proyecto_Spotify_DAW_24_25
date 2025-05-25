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
