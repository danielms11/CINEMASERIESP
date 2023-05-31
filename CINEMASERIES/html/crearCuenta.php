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
    <link rel="icon" type="image/jpg" href="/CINEMASERIES/imagenes/logo-cinemaseries.png"/>
    <link rel="stylesheet" href="/CINEMASERIES/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>CINEMASERIES</title>
</head>

<body class="formularios">
    <div class="container formulario">
        <div class="row">
            <div class="col-sm">
                <div class="login-form formularioStyleCrearCuenta">
                    <h2 class="text-center mb-4">Registrarte</h2>
                    <?php
    if (!empty($_POST["nombre"]) && !empty($_POST["apellido1"]) && !empty($_POST["apellido2"]) && !empty($_POST["nombre_usuario"]) && !empty($_POST["correo_electronico"]) && !empty($_POST["contrasena"])) {
        // Preparar la consulta SQL para buscar el nombre de usuario
        $buscarUsuario = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE nombre_usuario = ?");
        $buscarUsuario->bindValue(1, $_POST["nombre_usuario"]);
        $buscarUsuario->execute();
        $existeUsuario = $buscarUsuario->fetchColumn();
    
        if ($existeUsuario) {
            echo "<p class=\"text-warning text-center\">El nombre de usuario ya existe.</p>";
        } else {
            // Preparar la consulta SQL para insertar el nuevo usuario
            $insertarUsuario = $pdo->prepare("INSERT INTO usuarios(correo, contraseña, nombre, apellido1, apellido2, nombre_usuario) VALUES (?, ?, ?, ?, ?, ?)");
    
            // Encriptar la contraseña
            $contrasenaEncriptada = password_hash($_POST["contrasena"], PASSWORD_DEFAULT);
    
            // Asignar los valores a los parámetros
            $insertarUsuario->bindValue(1, $_POST["correo_electronico"]);
            $insertarUsuario->bindValue(2, $contrasenaEncriptada);
            $insertarUsuario->bindValue(3, $_POST["nombre"]);
            $insertarUsuario->bindValue(4, $_POST["apellido1"]);
            $insertarUsuario->bindValue(5, $_POST["apellido2"]);
            $insertarUsuario->bindValue(6, $_POST["nombre_usuario"]);
    
            // Ejecutar la consulta
            if ($insertarUsuario->execute()) {
                echo "<p class=\"text-success text-center\">Usuario insertado exitosamente.</p>";
                echo '<script>window.location.href = "inicioSesion.php";</script>';
                exit;
            } else {
                echo "<p class=\"text-danger text-center\">Error al insertar el usuario.</p>";
            }
        }
    } else {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            echo "<p class=\"text-warning text-center\">Faltan datos requeridos para insertar el usuario.</p>";
        }
    }
    ?> 
                    <form method="POST" class="mb-3">
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" name="nombre" class="form-control form-control-dark text-bg-dark inputSearchYText"
                                aria-label="Text">
                        </div>
                        <div class="form-group form-inline">
                            <label for="lastname1">Primer Apellido</label>
                            <input type="text" name="apellido1" class="form-control form-control-dark text-bg-dark inputSearchYText"
                                aria-label="Text">
                            <label for="lastname2">Segundo Apellido</label>
                            <input type="text" name="apellido2" class="form-control form-control-dark text-bg-dark inputSearchYText"
                                aria-label="Text">
                        </div>
                        <div class="form-group">
                            <label for="username">Nombre de usuario</label>
                            <input type="text" name="nombre_usuario" class="form-control form-control-dark text-bg-dark inputSearchYText"
                                aria-label="Text">
                        </div>
                        <div class="form-group">
                            <label for="username">Correo electrónico</label>
                            <input type="email" name="correo_electronico" class="form-control form-control-dark text-bg-dark inputSearchYText"
                                aria-label="Text">
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" name="contrasena" class="form-control form-control-dark text-bg-dark inputSearchYText">
                        </div>
                        <div class="text-center mb-3 border-bottom aNone mt-4">
                            <button type="submit" class="botones mb-3">Registrarte</button>
                        </div>
                    </form>
                    <div class="text-center aNone">
                        <a href="inicioSesion.php">
                            <button class="botones">Volver</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>