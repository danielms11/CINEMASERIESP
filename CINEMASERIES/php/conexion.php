<?php
$host = "localhost";
$port = "5432";
$dbname = "CINEMASERIES";
$user = "postgres";
$password = "usuario";

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";
try {
  $pdo = new PDO($dsn);
} catch(PDOException $e) {
  echo "Error al conectar con la base de datos: " . $e->getMessage();
  die();
}
?>