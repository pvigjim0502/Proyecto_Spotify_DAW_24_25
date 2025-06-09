async function cargarComentarios(idAlbum) {
    // esta funcion muestra los comentarios de un album
    try {
        // pedimos los comentarios al servidor
        const respuesta = await fetch(`./controladores/ComentarioControlador.php?accion=obtener_comentarios&idAlbum=${idAlbum}`);
        const datos = await respuesta.json();

        // buscamos la lista donde van los comentarios
        const listaComentarios = document.getElementById('listaComentarios');
        listaComentarios.innerHTML = ''; // borramos lo que habia antes de cargar los nuevos

        // si hay comentarios y todo fue bien
        if (datos.exito && datos.comentarios.length > 0) {
            // para cada comentario que encontramos
            for (let i = 0; i < datos.comentarios.length; i++) {
                const comentario = datos.comentarios[i];

                // vemos si el comentario es tuyo
                const usuarioNombre = obtenerCookie('usuarioNombre');
                const esMiComentario = usuarioNombre === comentario.usuario;
                const likeActivo = comentario.usuarioHaDadoLike;
                const dislikeActivo = comentario.usuarioHaDadoDislike;

                // creamos un espacio para el comentario
                const comentarioElemento = document.createElement('div');
                comentarioElemento.className = 'comentario card mb-3 p-3 shadow-sm rounded extra-comentario-style';

                // preparamos la fecha para que se vea bonita
                const fecha = new Date(comentario.fechaComentario);
                let dia = String(fecha.getDate());
                if (dia.length < 2) { // si el dia tiene solo un numero
                    dia = '0' + dia; // le ponemos un cero delante
                }
                let mes = String(fecha.getMonth() + 1); // el mes empieza en 0, asi que sumamos 1
                if (mes.length < 2) { // si el mes tiene solo un numero
                    mes = '0' + mes; // le ponemos un cero delante
                }
                const anio = fecha.getFullYear();
                let hora = String(fecha.getHours());
                if (hora.length < 2) { // si la hora tiene solo un numero
                    hora = '0' + hora; // le ponemos un cero delante
                }
                let minutos = String(fecha.getMinutes());
                if (minutos.length < 2) { // si los minutos tienen solo un numero
                    minutos = '0' + minutos; // le ponemos un cero delante
                }
                const fechaFormateada = `${dia}/${mes}/${anio} ${hora}:${minutos}`;

                // lo que va arriba del comentario: foto, nombre y fecha
                const encabezado = `
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <img src="assets/img/usuario/usuario.png" class="rounded-circle me-3" style="width: 45px; height: 45px; object-fit: cover;">
                            <span class="fw-bold">${comentario.usuario}</span>
                        </div>
                        <small>${fechaFormateada}</small>
                    </div>
                `;

                // el texto del comentario
                const textoComentario = `
                    <div class="mt-2 comentario-texto" id="comentarioTexto_${comentario.id}">
                        ${comentario.comentario}
                    </div>
                `;

                // juntamos el encabezado y el texto del comentario
                comentarioElemento.innerHTML = encabezado + textoComentario;

                // si el comentario es tuyo, ponemos botones para editar y borrar
                if (esMiComentario) {
                    const botones = document.createElement('div');
                    botones.className = 'd-flex justify-content-end mt-2';

                    // boton de editar
                    const botonEditar = document.createElement('button');
                    botonEditar.className = 'btn btn-warning btn-sm me-2 btn-editar';
                    botonEditar.innerHTML = '<i class="fas fa-edit"></i> Editar';
                    // cuando hagas clic, se editara el comentario
                    botonEditar.addEventListener('click', function() {
                        editarComentario(comentario.id, comentario.comentario, comentario.usuario);
                    });

                    // boton de eliminar
                    const botonEliminar = document.createElement('button');
                    botonEliminar.className = 'btn btn-danger btn-sm btn-eliminar';
                    botonEliminar.innerHTML = '<i class="fas fa-trash"></i> Eliminar';
                    // cuando hagas clic, se borrara el comentario
                    botonEliminar.addEventListener('click', function() {
                        borrarComentario(comentario.id);
                    });

                    // ponemos los botones en el comentario
                    botones.appendChild(botonEditar);
                    botones.appendChild(botonEliminar);
                    comentarioElemento.appendChild(botones);
                }

                // botones de me gusta y no me gusta
                const botonesReaccion = document.createElement('div');
                botonesReaccion.className = 'd-flex justify-content-start mt-2';

                // boton de me gusta
                const btnLike = document.createElement('button');
                btnLike.className = `btn btn-success btn-sm me-2 ${likeActivo ? 'activo' : ''}`;
                btnLike.innerHTML = `<i class="fas fa-thumbs-up"></i> ${comentario.likes}`;
                btnLike.disabled = dislikeActivo; // no puedes dar like si ya diste dislike
                // cuando hagas clic, se da me gusta
                btnLike.addEventListener('click', function() {
                    darLike(comentario.id);
                });

                // boton de no me gusta
                const btnDislike = document.createElement('button');
                btnDislike.className = `btn btn-danger btn-sm ${dislikeActivo ? 'activo' : ''}`;
                btnDislike.innerHTML = `<i class="fas fa-thumbs-down"></i> ${comentario.dislikes}`;
                btnDislike.disabled = likeActivo; // no puedes dar dislike si ya diste like
                // cuando hagas clic, se da no me gusta
                btnDislike.addEventListener('click', function() {
                    darDislike(comentario.id);
                });

                // ponemos los botones de reaccion en el comentario
                botonesReaccion.appendChild(btnLike);
                botonesReaccion.appendChild(btnDislike);
                comentarioElemento.appendChild(botonesReaccion);

                // agregamos el comentario a la lista
                listaComentarios.appendChild(comentarioElemento);
            }
        } else {
            // si no hay comentarios, mostramos un mensaje
            listaComentarios.innerHTML = '<p>No hay comentarios aun.</p>';
        }
    } catch (error) {
        // si algo sale mal, mostramos un mensaje de error
        mostrarToast('Error cargando comentarios: ' + error.message, 'error');
    }
}

async function publicarComentario() {
    // esta funcion publica un comentario nuevo
    const comentarioInput = document.getElementById('comentarioInput');
    const comentario = comentarioInput.value.trim();
    const usuarioNombre = obtenerCookie('usuarioNombre');

    if (!usuarioNombre) {
        // si no hay usuario conectado, mostramos un error
        mostrarToast('Debes iniciar sesión para comentar', 'error');
        return;
    }

    if (!comentario) {
        // si el comentario esta vacio, mostramos un error
        mostrarToast('El comentario no puede estar vacío', 'error');
        return;
    }

    if (!albumSeleccionadoId) {
        // si no hay album seleccionado, mostramos un error
        mostrarToast('Selecciona un álbum para comentar', 'error');
        return;
    }

    try {
        // enviamos el comentario al servidor
        const respuesta = await fetch('./controladores/ComentarioControlador.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                usuarioNombre: usuarioNombre,
                idAlbum: albumSeleccionadoId,
                comentario: comentario
            })
        });

        const datos = await respuesta.json();

        if (datos.exito) {
            // si todo sale bien, mostramos un mensaje y recargamos los comentarios
            mostrarToast('Comentario publicado', 'exito');
            comentarioInput.value = '';
            cargarComentarios(albumSeleccionadoId);
        } else {
            // si hay un problema, mostramos el error del servidor
            mostrarToast(datos.mensaje, 'error');
        }
    } catch (error) {
        // si algo falla al enviar, mostramos un error
        mostrarToast('Error al publicar: ' + error.message, 'error');
    }
}

function editarComentario(idComentario, comentarioActual, usuarioComentario) {
    // esta funcion deja cambiar un comentario
    const usuarioNombre = obtenerCookie('usuarioNombre');

    if (usuarioNombre !== usuarioComentario) {
        // si no es tu comentario, mostramos un error
        mostrarToast('No puedes editar comentarios de otros usuarios', 'error');
        return;
    }

    // pedimos el nuevo comentario al usuario
    const nuevoComentario = prompt('Edita tu comentario:', comentarioActual);

    if (nuevoComentario && nuevoComentario.trim() !== comentarioActual) {
        // si hay un cambio, actualizamos el comentario
        actualizarComentario(idComentario, nuevoComentario.trim());
    }
}

async function borrarComentario(idComentario) {
    // esta funcion borra un comentario
    const confirmarBorrado = confirm('¿Estás seguro de que deseas eliminar este comentario?');

    if (confirmarBorrado) {
        try {
            const usuarioNombre = obtenerCookie('usuarioNombre');
            if (!usuarioNombre) {
                throw new Error("Debes iniciar sesión para eliminar un comentario");
            }

            // pedimos al servidor que borre el comentario
            const respuesta = await fetch('./controladores/ComentarioControlador.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    accion: 'borrar_comentario',
                    idComentario: idComentario,
                    usuarioNombre: usuarioNombre
                })
            });

            const datos = await respuesta.json();

            if (datos.exito) {
                // si todo sale bien, mostramos un mensaje y recargamos los comentarios
                mostrarToast('Comentario eliminado con éxito', 'exito');
                cargarComentarios(albumSeleccionadoId);
            } else {
                // si hay un problema, mostramos el error del servidor
                mostrarToast(datos.mensaje, 'error');
            }
        } catch (error) {
            // si algo falla al enviar, mostramos un error
            mostrarToast('Error al borrar el comentario: ' + error.message, 'error');
        }
    }
}
