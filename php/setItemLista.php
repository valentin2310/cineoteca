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
    $id_lista = $data['id_lista'];
    $id_item = $data['id_item'];
    $media_type = $data['media_type'];
}

try {
  // Crear una instancia de PDO para establecer la conexión con la base de datos
  $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
  // Configurar el modo de error de PDO para lanzar excepciones en caso de errores
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Comprobar si el episodio ya se ha visto
  $sqlComprobarVisto = "SELECT COUNT(*) AS num_vistos FROM lista_item WHERE id_lista LIKE :id_lista AND id_item LIKE :id_item AND media_type LIKE :media_type";
  $stmtComprobarVisto = $conn->prepare($sqlComprobarVisto);
  $stmtComprobarVisto->bindParam(':id_lista', $id_lista);
  $stmtComprobarVisto->bindParam(':id_item', $id_item);
  $stmtComprobarVisto->bindParam(':media_type', $media_type);
  $stmtComprobarVisto->execute();
  $resultadoComprobarVisto = $stmtComprobarVisto->fetch(PDO::FETCH_ASSOC);
  $numVistos = $resultadoComprobarVisto['num_vistos'];

  if ($numVistos > 0) {
      echo "El item ya se ha agregado antes";
  } else {

    $sql = "INSERT INTO lista_item(`id_lista`, `id_item`, `media_type`) VALUES(:id_lista, :id_item, :media_type)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_lista', $id_lista);
    $stmt->bindParam(':id_item', $id_item);
    $stmt->bindParam(':media_type', $media_type);
    $stmt->execute();

    echo "Item agregado a la lista correctamente";
  }
    
} catch(PDOException $e) {
  echo "Error de conexión: " . $e->getMessage();
}

?>