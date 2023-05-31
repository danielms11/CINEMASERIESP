<?php
// Establecer la cookie con una fecha de expiración en el pasado
setcookie('id_usuario', '', time() - 3600, '/');
// Redirigir a la página de inicio de sesión u otra página deseada
header('Location: /CINEMASERIES/index.php');
exit();
?>