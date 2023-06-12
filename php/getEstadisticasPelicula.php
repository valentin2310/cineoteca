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
}

try {
  // Crear una instancia de PDO para establecer la conexión con la base de datos
  $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
  // Configurar el modo de error de PDO para lanzar excepciones en caso de errores
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  //Consulta a tabla favorito

  $sql = "SELECT id_item FROM favorito WHERE id_usuario LIKE :id AND id_item LIKE :id_item AND media_type LIKE 'movie'";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $id);
  $stmt->bindParam(':id_item', $id_item);
  $stmt->execute();

  $row1 = $stmt->fetch();

  if ($row1) {
      $favorito = true;
  } else {
      $favorito = false;
  }

  //Consulta a tabla valoracion

  $sql = "SELECT valor FROM valoracion WHERE id_usuario LIKE :id AND id_item LIKE :id_item AND media_type LIKE 'movie'";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $id);
  $stmt->bindParam(':id_item', $id_item);
  $stmt->execute();

  $row2 = $stmt->fetch();

  if ($row2) {
      $valoracion = $row2['valor'];
  } else {
      $valoracion = 0;
  }

  //Consulta a tabla seguimiento

  $sql = "SELECT id_item FROM seguimiento WHERE id_usuario LIKE :id AND id_item LIKE :id_item AND media_type LIKE 'movie'";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $id);
  $stmt->bindParam(':id_item', $id_item);
  $stmt->execute();

  $row3 = $stmt->fetch();

  if ($row3) {
      $seguimiento = true;
  } else {
      $seguimiento = false;
  }

  //Consulta a tabla visto_pelicula

  $sql = "SELECT fecha_alta FROM visto_pelicula WHERE id_usuario LIKE :id AND id_tmdb LIKE :id_item";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $id);
  $stmt->bindParam(':id_item', $id_item);
  $stmt->execute();

  $row4 = $stmt->fetch();

  if ($row4) {
      $visto = true;
      $fecha_visto = $row['fecha_alta'];
  } else {
      $visto = false;
      $fecha_visto = 'null';
  }

  // Array con las estadisticas
  $resultados = [
    'favorito' => $favorito,
    'valoracion' => $valoracion,
    'seguimiento' => $seguimiento,
    'visto' => $visto,
    'fecha_visto' => $fecha_visto
  ];

  // Devolver los resultados como JSON
  header('Content-Type: application/json');
  echo json_encode($resultados);
    
} catch(PDOException $e) {
  echo "Error de conexión: " . $e->getMessage();
}

?>