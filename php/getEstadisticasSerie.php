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

  $sql = "SELECT id_item FROM favorito WHERE id_usuario LIKE :id AND id_item LIKE :id_item AND media_type LIKE 'tv'";
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

  $sql = "SELECT valor FROM valoracion WHERE id_usuario LIKE :id AND id_item LIKE :id_item AND media_type LIKE 'tv'";
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

  $sql = "SELECT id_item FROM seguimiento WHERE id_usuario LIKE :id AND id_item LIKE :id_item AND media_type LIKE 'tv'";
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

  // Crear un array para almacenar las temporadas con sus episodios vistos
$temporadasEpisodios = array();

// Obtener la lista de temporadas con sus episodios vistos
$sql = "SELECT id_tmdb, num_temporada, num_episodio, titulo, fecha_alta FROM visto_episodio WHERE id_usuario = :id_usuario AND id_tmdb = :id_tmdb";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_usuario', $id);
$stmt->bindParam(':id_tmdb', $id_item);
$stmt->execute();
$temporadasVistas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Recorrer las filas de resultados
foreach ($temporadasVistas as $row) {
    $num_temporada = $row['num_temporada'];
    $num_episodio = $row['num_episodio'];
    $titulo = $row['titulo'];
    $fecha_alta = $row['fecha_alta'];

    // Verificar si la temporada ya existe en el array
    if (isset($temporadasEpisodios[$num_temporada])) {
        // Agregar el episodio a la temporada existente
        $temporadasEpisodios[$num_temporada]['episodios'][] = array(
            'episode_number' => $num_episodio,
            'titulo' => $titulo,
            'fecha_alta' => $fecha_alta,
        );
    } else {
        // Crear una nueva entrada para la temporada y su primer episodio
        $temporadasEpisodios[$num_temporada] = array(
            'episodios' => array(
                array(
                    'episode_number' => $num_episodio,
                    'titulo' => $titulo,
                    'fecha_alta' => $fecha_alta,
                )
            )
        );
    }
}


  // Array con las estadisticas
  $resultados = [
    'favorito' => $favorito,
    'valoracion' => $valoracion,
    'seguimiento' => $seguimiento,
    'temporadaEpisodios' => $temporadasEpisodios
  ];

  // Devolver los resultados como JSON
  header('Content-Type: application/json');
  echo json_encode($resultados);
    
} catch(PDOException $e) {
  echo "Error de conexión: " . $e->getMessage();
}

?>