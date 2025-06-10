<?php
// establecer headers para permitir el acceso desde cualquier origen y especificar métodos y cabeceras permitidos
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/img/favicon/favicon.png" type="image/png">
    <title>Novamelody</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap5.3.css" rel="stylesheet">
    <link href="assets/css/estilos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
</head>

<body>
    <?php
    $rutaBase = __DIR__ . '/php/';
    include($rutaBase . 'cabecera.php');
    include($rutaBase . 'login.php');
    include($rutaBase . 'paginaInicio.php');
    include($rutaBase . 'miPerfil.php');
    include($rutaBase . 'mensajeInformativo.php');
    include($rutaBase . 'administrarPagina.php');
    include($rutaBase . 'footer.php');
    ?>
</body>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script src="/assets/js/funciones.js"></script>
<script src="/assets/js/foro.js"></script>
<script src="/assets/js/ajax.js"></script>
<script src="/assets/js/cookies.js"></script>

</html>
