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
    $id_item = $data['id_item'];
    $media_type = $data['media_type'];
    $valor = $data['valor'];
}

try {
  // Crear una instancia de PDO para establecer la conexión con la base de datos
  $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
  // Configurar el modo de error de PDO para lanzar excepciones en caso de errores
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Comprobar existencia de la valoración
  $sql = "SELECT COUNT(*) AS count FROM valoracion WHERE id_usuario = :id_usuario AND id_item = :id_item AND media_type like :media_type";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id_usuario', $id);
  $stmt->bindParam(':id_item', $id_item);
  $stmt->bindParam(':media_type', $media_type);
  $stmt->execute();
  $row = $stmt->fetch();

  if ($row['count'] > 0) {
    // La valoración existe, realizar una actualización
    $sql = "UPDATE valoracion SET valor = :valor WHERE id_usuario = :id_usuario AND id_item = :id_item AND media_type like :media_type";
  } else {
    // La valoración no existe, realizar una inserción
    $sql = "INSERT INTO valoracion (id_usuario, id_item, media_type, valor) VALUES (:id_usuario, :id_item, :media_type, :valor)";
  }

  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id_usuario', $id);
  $stmt->bindParam(':id_item', $id_item);
  $stmt->bindParam(':media_type', $media_type);
  $stmt->bindParam(':valor', $valor);
  $stmt->execute();

  echo "Valoración realizada correctamente";
    
} catch(PDOException $e) {
  echo "Error de conexión: " . $e->getMessage();
}

?>