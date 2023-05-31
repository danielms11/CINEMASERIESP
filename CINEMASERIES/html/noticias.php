<?php
include('../php/conexion.php');
include('../php/metodos.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/CINEMASERIES/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="icon" type="image/jpg" href="/CINEMASERIES/imagenes/logo-cinemaseries.png" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <title>CINEMASERIES</title>
</head>

<body>
    <?php
    $categoriaPrincipal = $_GET['categoriaPrincipal'];

    $consultaTarjeta = "SELECT n.*, u.nombre, u.apellido1, apellido2, COUNT(c.id_comentario) AS num_comentarios 
    FROM noticias n 
    JOIN usuarios u ON n.id_usuario = u.id_usuario 
    LEFT JOIN comentarios c ON n.id_noticia = c.id_noticia 
    WHERE n.categoria_principal = '" . $categoriaPrincipal . "'
    GROUP BY n.id_noticia, u.nombre, u.apellido1, u.apellido2
    ORDER BY n.fecha DESC";
    ?>
    <header>
        <div class="container border-bottom">
            <a href="/CINEMASERIES/index.php">
                <img src="/CINEMASERIES/imagenes/logo-cinemaseries.png" alt="" class="mb-4" id="logo-cinemaseries">
            </a>
        </div>
    </header>
    <nav class="p-3">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0" id="menuLinks">
                    <li><a href="/CINEMASERIES/html/noticias.php?categoriaPrincipal=NOTICIAS" class="nav-link px-2">NOTICIAS</a></li>
                    <li><a href="/CINEMASERIES/html/noticias.php?categoriaPrincipal=ESTRENOS" class="nav-link px-2">ESTRENOS</a></li>
                    <li><a href="/CINEMASERIES/html/noticias.php?categoriaPrincipal=CRÍTICAS" class="nav-link px-2">CRÍTICAS</a></li>
                    <li><a href="/CINEMASERIES/html/noticias.php?categoriaPrincipal=RANKINGS" class="nav-link px-2">RANKINGS</a></li>
                </ul>

                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                    <input type="search" class="form-control form-control-dark text-bg-dark inputSearchYText" placeholder="Search..." aria-label="Search">
                </form>
                <?php
                if (isset($_COOKIE['id_usuario'])) {

                    $idUsuario = $_COOKIE['id_usuario'];

                    try {
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $query = "SELECT * FROM usuarios WHERE id_usuario = :idUsuario";
                        $stmt = $pdo->prepare($query);
                        $stmt->bindParam(':idUsuario', $idUsuario);
                        $stmt->execute();

                        if ($stmt->rowCount() > 0) {
                            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                            $nombreUsuario = $usuario['nombre_usuario'];
                        } else {
                            echo 'No se encontró el usuario.';
                        }
                    } catch (PDOException $e) {
                        echo "Error al conectar a la base de datos: " . $e->getMessage();
                    }

                    $usuario_serializado = json_encode($usuario);

                    setcookie('usuario', $usuario_serializado, time() + (30 * 24 * 60 * 60), '/');
                ?>
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="botones dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= $nombreUsuario ?>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <li><a class="dropdown-item" href="/CINEMASERIES/html/insertarNoticia.php">Nueva noticia</a></li>
                            <li><a class="dropdown-item" href="/CINEMASERIES/html/misNoticias.php">Mis noticias</a></li>
                            <li><a class="dropdown-item" href="/CINEMASERIES/php/cerrarSesion.php">Cerrar sesión</a></li>
                        </ul>
                    </div>
                <?php
                } else {
                ?>
                    <div class="text-end">
                        <a href="/CINEMASERIES/html/inicioSesion.php">
                            <button class="botones">Iniciar sesión</button>
                        </a>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </nav>
    <section>
        <div class="container">
            <div class="row">

            </div>
        </div>
        <article class="mt-3">
            <?php
            $resultadoTarjeta = mostrarTarjeta($consultaTarjeta, $pdo);

            echo $resultadoTarjeta;
            ?>
        </article>
    </section>
    <footer class="bg-dark text-light">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; 2023 CINEMASERIES. Todos los derechos reservados.</p>
                </div>
                <div class="col-md-6 text-right">
                    <a href="https://twitter.com/?lang=es"><img src="/CINEMASERIES/imagenes/twitter.png" alt="Twitter"></a>
                    <a href="https://es-es.facebook.com/"><img src="/CINEMASERIES/imagenes/facebook.png" alt="Facebook"></a>
                    <a href="https://www.instagram.com/"><img src="/CINEMASERIES/imagenes/instagram.png" alt="Instagram"></a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>