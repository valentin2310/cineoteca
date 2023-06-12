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
}

try {
  // Crear una instancia de PDO para establecer la conexión con la base de datos
  $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
  // Configurar el modo de error de PDO para lanzar excepciones en caso de errores
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  //insertar el episodio en la base de datos
  $sql = "DELETE FROM lista WHERE id LIKE :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $id);
  $stmt->execute();

  echo "Lista eliminada correctamente";
    
} catch(PDOException $e) {
  echo "Error de conexión: " . $e->getMessage();
}

?>