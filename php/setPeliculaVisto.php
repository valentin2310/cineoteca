<?php

require_once('config.php');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Obtener la solicitud
$request = file_get_contents("php://input");

// Pasar los datos de la solicitud a JSON
$data = json_decode($request, true);

if(isset($data)){
    $id = $data['id'];
    $id_tmdb = $data['id_tmdb'];
    $duracion = $data['duracion'];
    $titulo = $data['titulo'];
}

try {
  // Crear una instancia de PDO para establecer la conexión con la base de datos
  $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
  // Configurar el modo de error de PDO para lanzar excepciones en caso de errores
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "insert into visto_pelicula(`id_usuario`, `id_tmdb`, `duracion`, `titulo`) values(:id_usuario, :id_tmdb, :duracion, :titulo)";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id_usuario', $id);
  $stmt->bindParam(':id_tmdb', $id_tmdb);
  $stmt->bindParam(':duracion', $duracion);
  $stmt->bindParam(':titulo', $titulo);
  $stmt->execute();

  echo "Item agregado a visto pelicula correctamente";
    
} catch(PDOException $e) {
  echo "Error de conexión: " . $e->getMessage();
}

?>