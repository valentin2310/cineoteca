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
    $num_episodio = $data['num_episodio'];
    $num_temporada = $data['num_temporada'];
}

try {
  // Crear una instancia de PDO para establecer la conexión con la base de datos
  $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
  // Configurar el modo de error de PDO para lanzar excepciones en caso de errores
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "DELETE FROM visto_episodio WHERE id_usuario LIKE :id_usuario AND id_tmdb LIKE :id_tmdb AND num_episodio LIKE :num_episodio AND num_temporada LIKE :num_temporada";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id_usuario', $id);
  $stmt->bindParam(':id_tmdb', $id_tmdb);
  $stmt->bindParam(':num_episodio', $num_episodio);
  $stmt->bindParam(':num_temporada', $num_temporada);
  $stmt->execute();

  echo "Episodio eliminada de vistos correctamente";
    
} catch(PDOException $e) {
  echo "Error de conexión: " . $e->getMessage();
}

?>