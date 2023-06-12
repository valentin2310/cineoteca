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
    $id_creador = $data['id_creador'];
    $titulo = $data['titulo'];
    $descripcion = $data['descripcion'];
    $privacidad = $data['privacidad'];
    $id_tmdb = $data['id_tmdb'];
}

try {
  // Crear una instancia de PDO para establecer la conexión con la base de datos
  $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
  // Configurar el modo de error de PDO para lanzar excepciones en caso de errores
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  //insertar el episodio en la base de datos
  $sql = "INSERT INTO lista(`id_creador`, `titulo`, `descripcion`, `privacidad`, `id_tmdb`) VALUES(:id_creador, :titulo, :descripcion, :privacidad, :id_tmdb)";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id_creador', $id_creador);
  $stmt->bindParam(':titulo', $titulo);
  $stmt->bindParam(':descripcion', $descripcion);
  $stmt->bindParam(':privacidad', $privacidad);
  $stmt->bindParam(':id_tmdb', $id_tmdb);
  $stmt->execute();

  echo "Lista creada correctamente";
    
} catch(PDOException $e) {
  echo "Error de conexión: " . $e->getMessage();
}

?>