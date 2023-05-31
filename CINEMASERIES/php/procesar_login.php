<?php
  // Obtener los datos del formulario
  $usuario = $_POST['username'] ?? '';
  $password = $_POST["password"] ?? '';

  // Verificar si se ingresaron espacios en blanco
  if (trim($usuario) === '' || trim($password) === '') {
    // Mostrar mensaje de error con JavaScript
    echo '<script>alert("Debe ingresar el usuario y la contraseña.");</script>';
  } else {
    // Conectar a la base de datos
    $conn = pg_connect("host=127.0.0.1 dbname=CINEMASERIES user=postgres password=usuario") or die("No se pudo conectar a la base de datos");

    // Consulta para verificar si el usuario y contraseña existen en la tabla "usuarios"
    $query = "SELECT COUNT(*) FROM usuarios WHERE nombre_usuario = $1";
    $query_id = "SELECT id_usuario, contraseña FROM usuarios WHERE nombre_usuario = $1";
    $result = pg_query_params($conn, $query, array($usuario));
    $result_id = pg_query_params($conn, $query_id, array($usuario));

    if ($result !== false) {
      $count = pg_fetch_result($result, 0, 0);

      // Comprobar si el usuario existe en la tabla "usuarios"
      if ($count > 0) {
        $hashAlmacenado = pg_fetch_result($result_id, 0, 'contraseña');

        // Verificar si la contraseña ingresada coincide con el hash almacenado
        if (password_verify($password, $hashAlmacenado)) {
          $idUsuario = pg_fetch_result($result_id, 0, 'id_usuario');

          // El usuario y contraseña coinciden, establecer una cookie con el ID de usuario
          setcookie('id_usuario', $idUsuario, time() + (86400 * 30), '/'); // La cookie expirará después de 30 días

          // Cerrar la conexión a la base de datos
          pg_close($conn);

          // El usuario y contraseña coinciden, mostrar un mensaje de éxito
          echo '<p>Inicio de sesión exitoso.</p>';
        } else {
          // La contraseña no coincide, mostrar mensaje de error con JavaScript
          echo '<script>alert("La contraseña es incorrecta.");</script>';
        }
      } else {
        // El usuario no existe, mostrar mensaje de error con JavaScript
        echo '<script>alert("El usuario no existe.");</script>';
      }
    } else {
      // Error al ejecutar la consulta SQL
      echo '<script>alert("Error al ejecutar la consulta SQL.");</script>';
    }
  }
?>