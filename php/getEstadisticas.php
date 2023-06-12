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
    $id_usuario = $data['id'];
}

try {
  // Crear una instancia de PDO para establecer la conexión con la base de datos
  $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
  // Configurar el modo de error de PDO para lanzar excepciones en caso de errores
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Obtener la cantidad de episodios vistos
  $sqlEpisodios = "SELECT COUNT(*) AS cantidad FROM visto_episodio WHERE id_usuario = :id_usuario";
  $stmtEpisodios = $conn->prepare($sqlEpisodios);
  $stmtEpisodios->bindParam(':id_usuario', $id_usuario);
  $stmtEpisodios->execute();
  $cantidadEpisodios = $stmtEpisodios->fetch(PDO::FETCH_ASSOC)['cantidad'];

  // Obtener la cantidad de películas vistas
  $sqlPeliculas = "SELECT COUNT(*) AS cantidad FROM visto_pelicula WHERE id_usuario = :id_usuario";
  $stmtPeliculas = $conn->prepare($sqlPeliculas);
  $stmtPeliculas->bindParam(':id_usuario', $id_usuario);
  $stmtPeliculas->execute();
  $cantidadPeliculas = $stmtPeliculas->fetch(PDO::FETCH_ASSOC)['cantidad'];

  // Obtener el tiempo visto en episodios
  $sqlTiempoEpisodios = "SELECT SUM(duracion) AS tiempo FROM visto_episodio WHERE id_usuario = :id_usuario";
  $stmtTiempoEpisodios = $conn->prepare($sqlTiempoEpisodios);
  $stmtTiempoEpisodios->bindParam(':id_usuario', $id_usuario);
  $stmtTiempoEpisodios->execute();
  $tiempoEpisodios = $stmtTiempoEpisodios->fetch(PDO::FETCH_ASSOC)['tiempo'];

  // Obtener el tiempo visto en películas
  $sqlTiempoPeliculas = "SELECT SUM(duracion) AS tiempo FROM visto_pelicula WHERE id_usuario = :id_usuario";
  $stmtTiempoPeliculas = $conn->prepare($sqlTiempoPeliculas);
  $stmtTiempoPeliculas->bindParam(':id_usuario', $id_usuario);
  $stmtTiempoPeliculas->execute();
  $tiempoPeliculas = $stmtTiempoPeliculas->fetch(PDO::FETCH_ASSOC)['tiempo'];

  // Obtener el número de series viendo
  $sqlSeriesViendo = "SELECT COUNT(DISTINCT id_tmdb) AS cantidad FROM visto_episodio WHERE id_usuario = :id_usuario";
  $stmtSeriesViendo = $conn->prepare($sqlSeriesViendo);
  $stmtSeriesViendo->bindParam(':id_usuario', $id_usuario);
  $stmtSeriesViendo->execute();
  $numeroSeriesViendo = $stmtSeriesViendo->fetch(PDO::FETCH_ASSOC)['cantidad'];

  // Obtener el número de series viendo
  $sqlValoraciones = "SELECT COUNT(DISTINCT id_item) AS cantidad FROM valoracion WHERE id_usuario = :id_usuario";
  $stmtValoraciones = $conn->prepare($sqlValoraciones);
  $stmtValoraciones->bindParam(':id_usuario', $id_usuario);
  $stmtValoraciones->execute();
  $numeroValoraciones = $stmtValoraciones->fetch(PDO::FETCH_ASSOC)['cantidad'];

  // Obtener el último episodio visto
  $sqlUltimoEpisodio = "SELECT * FROM visto_episodio WHERE id_usuario = :id_usuario ORDER BY fecha_alta DESC LIMIT 1";
  $stmtUltimoEpisodio = $conn->prepare($sqlUltimoEpisodio);
  $stmtUltimoEpisodio->bindParam(':id_usuario', $id_usuario);
  $stmtUltimoEpisodio->execute();
  $ultimoEpisodio = $stmtUltimoEpisodio->fetch(PDO::FETCH_ASSOC);

  // Obtener la última película vista
  $sqlUltimaPelicula = "SELECT * FROM visto_pelicula WHERE id_usuario = :id_usuario ORDER BY fecha_alta DESC LIMIT 1";
  $stmtUltimaPelicula = $conn->prepare($sqlUltimaPelicula);
  $stmtUltimaPelicula->bindParam(':id_usuario', $id_usuario);
  $stmtUltimaPelicula->execute();
  $ultimaPelicula = $stmtUltimaPelicula->fetch(PDO::FETCH_ASSOC);

  // Obtener la serie más vista
  $sqlSerieMasVista = "SELECT id_tmdb, titulo_serie, COUNT(*) AS cantidad FROM visto_episodio WHERE id_usuario = :id_usuario GROUP BY id_tmdb ORDER BY cantidad DESC LIMIT 1";
  $stmtSerieMasVista = $conn->prepare($sqlSerieMasVista);
  $stmtSerieMasVista->bindParam(':id_usuario', $id_usuario);
  $stmtSerieMasVista->execute();
  $serieMasVista = $stmtSerieMasVista->fetch(PDO::FETCH_ASSOC);

  // Obtener la lista de películas vistas
  $sqlPeliculasVistas = "SELECT * FROM visto_pelicula WHERE id_usuario = :id_usuario";
  $stmtPeliculasVistas = $conn->prepare($sqlPeliculasVistas);
  $stmtPeliculasVistas->bindParam(':id_usuario', $id_usuario);
  $stmtPeliculasVistas->execute();
  $peliculasVistas = $stmtPeliculasVistas->fetchAll(PDO::FETCH_ASSOC);

  // Crear un array para almacenar las series vistas y sus episodios
  $seriesEpisodios = array();

  // Obtener la lista de series vistas con sus episodios
  $sqlSeriesVistas = "SELECT id_tmdb, titulo_serie, num_episodio, num_temporada, titulo, fecha_alta FROM visto_episodio WHERE id_usuario = :id_usuario";
  $stmtSeriesVistas = $conn->prepare($sqlSeriesVistas);
  $stmtSeriesVistas->bindParam(':id_usuario', $id_usuario);
  $stmtSeriesVistas->execute();
  $seriesVistas = $stmtSeriesVistas->fetchAll(PDO::FETCH_ASSOC);

  // Recorrer las filas de resultados
  foreach ($seriesVistas as $row) {
      $id_tmdb = $row['id_tmdb'];
      $titulo_serie = $row['titulo_serie'];
      $num_episodio = $row['num_episodio'];
      $num_temporada = $row['num_temporada'];
      $titulo = $row['titulo'];
      $fecha_alta = $row['fecha_alta'];

      // Verificar si la serie ya existe en el array
      if (isset($seriesEpisodios[$id_tmdb])) {
          // Agregar el episodio a la serie existente
          $seriesEpisodios[$id_tmdb]['episodios'][] = array(
              'num_episodio' => $num_episodio,
              'num_temporada' => $num_temporada,
              'titulo' => $titulo,
              'fecha_alta' => $fecha_alta,
          );
      } else {
          // Crear una nueva entrada para la serie y su primer episodio
          $seriesEpisodios[$id_tmdb] = array(
                'episodios' => array(
                  array(
                      'num_episodio' => $num_episodio,
                      'num_temporada' => $num_temporada,
                      'titulo' => $titulo,
                      'fecha_alta' => $fecha_alta,
                  )
                ),
                'titulo_serie' => $titulo_serie
          );
        }
    }
  // Crear un array para almacenar las series y películas favoritas
  $favoritos = array();
  
  // Obtener la lista de series y películas favoritas
  $sqlFavoritos = "SELECT * FROM favorito WHERE id_usuario = :id_usuario";
  $stmtFavoritos = $conn->prepare($sqlFavoritos);
  $stmtFavoritos->bindParam(':id_usuario', $id_usuario);
  $stmtFavoritos->execute();
  $favoritos = $stmtFavoritos->fetchAll();

  $resultado = array(
    "cantidad_episodios_vistos" => $cantidadEpisodios,
    "cantidad_peliculas_vistas" => $cantidadPeliculas,
    "tiempo_visto_episodios" => $tiempoEpisodios,
    "tiempo_visto_peliculas" => $tiempoPeliculas,
    "numero_series_viendo" => $numeroSeriesViendo,
    "ultimo_episodio_visto" => $ultimoEpisodio,
    "ultima_pelicula_vista" => $ultimaPelicula,
    "serie_mas_vista" => $serieMasVista,
    "peliculas_vistas" => $peliculasVistas,
    "series_episodios" => $seriesEpisodios,
    "favoritos" => $favoritos,
    "numero_valoraciones" => $numeroValoraciones
  );

  // Devolver el resultado como JSON
  header('Content-Type: application/json');
  echo json_encode($resultado);
    
} catch(PDOException $e) {
  echo "Error de conexión: " . $e->getMessage();
}

?>