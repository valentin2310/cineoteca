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
    $duracion = $data['duracion'];
    $titulo = $data['titulo'];
    $titulo_serie = $data['titulo_serie'];
}

try {
  // Crear una instancia de PDO para establecer la conexión con la base de datos
  $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
  // Configurar el modo de error de PDO para lanzar excepciones en caso de errores
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Comprobar si el episodio ya se ha visto
  $sqlComprobarVisto = "SELECT COUNT(*) AS num_vistos FROM visto_episodio WHERE id_usuario = :id_usuario AND id_tmdb = :id_tmdb AND num_episodio = :num_episodio AND num_temporada = :num_temporada";
  $stmtComprobarVisto = $conn->prepare($sqlComprobarVisto);
  $stmtComprobarVisto->bindParam(':id_usuario', $id);
  $stmtComprobarVisto->bindParam(':id_tmdb', $id_tmdb);
  $stmtComprobarVisto->bindParam(':num_episodio', $num_episodio);
  $stmtComprobarVisto->bindParam(':num_temporada', $num_temporada);
  $stmtComprobarVisto->execute();
  $resultadoComprobarVisto = $stmtComprobarVisto->fetch(PDO::FETCH_ASSOC);
  $numVistos = $resultadoComprobarVisto['num_vistos'];

  if ($numVistos > 0) {
      echo "El episodio ya se ha visto antes";
  } else {
    //insertar el episodio en la base de datos
    $sql = "insert into visto_episodio(`id_usuario`, `id_tmdb`, `num_episodio`, `num_temporada`, `duracion`, `titulo`, `titulo_serie`) values(:id_usuario, :id_tmdb, :num_episodio, :num_temporada, :duracion, :titulo, :titulo_serie)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_usuario', $id);
    $stmt->bindParam(':id_tmdb', $id_tmdb);
    $stmt->bindParam(':num_episodio', $num_episodio);
    $stmt->bindParam(':num_temporada', $num_temporada);
    $stmt->bindParam(':duracion', $duracion);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':titulo_serie', $titulo_serie);
    $stmt->execute();
  
    echo "Item agregado a visto episidio correctamente";
  }
    
} catch(PDOException $e) {
  echo "Error de conexión: " . $e->getMessage();
}

?>