<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/CINEMASERIES/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="icon" type="image/jpg" href="/CINEMASERIES/imagenes/logo-cinemaseries.png" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
    <title>CINEMASERIES</title>
</head>

<body class="formularios">
    <div class="container formulario">
        <div class="row">
            <div class="col-sm">
                <div class="login-form formularioStyle">
                    <h2 class="text-center mb-4">Inicio de sesión</h2>
                    <form class="mb-3" method="post" action="/CINEMASERIES/php/procesar_login.php">
                        <div class="form-group">
                            <label for="username">Nombre de usuario</label>
                            <input type="text" name="username" class="form-control form-control-dark text-bg-dark inputSearchYText"
                                aria-label="Text">
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" name="password" class="form-control form-control-dark text-bg-dark inputSearchYText">
                        </div>
                        <div class="text-center mb-3 mt-3 border-bottom aNone">
                            <button type="submit" name="login" class="botones mb-3">Iniciar sesión</button>
                        </div>
                    </form>
                    <div class="text-center mb-3 aNone">
                        <a href="crearCuenta.php">
                            <button class="botones">Crear cuenta nueva</button>
                        </a>
                    </div>
                    <div class="text-center aNone">
                        <a href="/CINEMASERIES/index.php">
                            <button class="botones">Volver</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>