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
    <link rel="stylesheet" href="/CINEMASERIES/css/insertarNoticia.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="icon" type="image/jpg" href="/CINEMASERIES/imagenes/logo-cinemaseries.png" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <title>CINEMASERIES</title>
</head>

<body class="formularioPagina">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-container formulario">
                    <form method="POST" enctype="multipart/form-data">
                        <?php
                        if (!empty($_POST["tituloNoticia"]) && !empty($_POST["descripcionNoticia"]) && !empty($_POST["contenidoNoticia"]) && !empty($_FILES['imagen']['name']) && !empty($_POST["categoriaNoticia"])) {
                            // Se han proporcionado todos los campos requeridos

                            $titulo = $_POST["tituloNoticia"];
                            $descripcion = $_POST["descripcionNoticia"];
                            $contenido = $_POST["contenidoNoticia"];
                            $nombreArchivo = $_FILES['imagen']['name'];
                            $categoria = $_POST["categoriaNoticia"];
                            $video = $_POST["videoNoticia"];
                            $id_usuario = $_COOKIE['id_usuario'];

                            $contenido = nl2br($contenido);

                            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                                $archivoTemp = $_FILES['imagen']['tmp_name'];
                                $rutaDestino = 'C:\xampp\htdocs\CINEMASERIES\imagenes\\' . $nombreArchivo; // Ruta deseada para guardar la imagen

                                // Validar que sea un archivo de imagen
                                $mimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
                                $tipoArchivo = mime_content_type($archivoTemp);

                                if (in_array($tipoArchivo, $mimeTypes)) {
                                    // Mover la imagen a la ruta de destino
                                    if (move_uploaded_file($archivoTemp, $rutaDestino)) {
                                        try {
                                            $fechaHoy = date("d/m/Y");

                                            $sql = "INSERT INTO public.noticias (titulo, contenido, foto, categoria_principal, fecha, id_usuario, descripcion, video) VALUES (:titulo, :contenido, :foto, :categoria_principal, :fecha, :id_usuario, :descripcion, :video)";
                                            $stmt = $pdo->prepare($sql);
                                            $stmt->bindParam(':titulo', $titulo);
                                            $stmt->bindParam(':contenido', $contenido);
                                            $stmt->bindParam(':foto', $nombreArchivo);
                                            $stmt->bindParam(':categoria_principal', $categoria);
                                            $stmt->bindParam(':fecha', $fechaHoy);
                                            $stmt->bindParam(':id_usuario', $id_usuario);
                                            $stmt->bindParam(':descripcion', $descripcion);
                                            $stmt->bindParam(':video', $video);
                                            $stmt->execute();

                                            // Redirigir al usuario a otra página después de la inserción exitosa
                                            header("Location: /CINEMASERIES/html/misNoticias.php");
                                            exit();
                                        } catch (PDOException $e) {
                                            echo "<p class=\"text-danger text-center\">Error al insertar los datos en la base de datos: " . $e->getMessage() . "</p>";
                                        }

                                        $conn = null; // Cierra la conexión a la base de datos
                                    } else {
                                        echo "Error al guardar la imagen.";
                                    }
                                } else {
                                    echo "<p class=\"text-warning text-center\">El archivo seleccionado no es una imagen válida.</p>";
                                }
                            }
                        } else {
                            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                                echo "<p class=\"text-warning text-center\">Falta alguno de los siguientes datos: Título, Descripción, Contenido, Imagen y Categoría.</p>";
                            }
                        }
                        ?>
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" name="tituloNoticia" class="form-control" id="titulo">
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" name="descripcionNoticia" id="descripcion" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="contenido" class="form-label">Contenido</label>
                            <textarea class="form-control" name="contenidoNoticia" id="contenido" rows="5"></textarea>
                        </div>
                        <div class="custom-file mb-3">
                            <input type="file" class="custom-file-input" name="imagen" id="customFile" accept="image/*" required>
                            <label class="custom-file-label" for="customFile">Seleccionar foto</label>
                        </div>
                        <div class="mb-3">
                            <label for="video" class="form-label">Link de video</label>
                            <input type="text" name="videoNoticia" class="form-control" id="video">
                        </div>
                        <div class="mb-3">
                            <label for="select" class="form-label">Seleccione una opción</label>
                            <select class="form-select" name="categoriaNoticia" id="select">
                                <option value="NOTICIAS">NOTICIAS</option>
                                <option value="ESTRENOS">ESTRENOS</option>
                                <option value="CRÍTICAS">CRÍTICAS</option>
                                <option value="RANKINGS">RANKINGS</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <a href="/CINEMASERIES/html/misNoticias.php" class="botones">Cancelar</a>
                            <button type="submit" class="botones">Publicar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>