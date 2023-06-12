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
    $nombre = $data['nombre'];
    $usuario = $data['usuario'];
    $sexo = $data['sexo'];
    $fecha_nac = $data['fecha_nac'];
}

// Validar el usuario y el nombre
if (!preg_match('/^[A-Za-zÑñ0-9_]{5,20}$/', $usuario)) {
  echo "Error: El usuario no cumple con el formato válido (debe contener entre 5 y 20 caracteres alfanuméricos y guiones bajos).";
  exit;
}

if (!preg_match('/^[A-Za-zÑñ]{3}[A-Za-zÑñ ]{0,27}$/', $nombre)) {
  echo "Error: El nombre no cumple con el formato válido (debe contener al menos 3 letras, seguidas de letras, espacios o tildes, con un máximo de 30 caracteres en total).";
  exit;
}

try {
  // Crear una instancia de PDO para establecer la conexión con la base de datos
  $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
  // Configurar el modo de error de PDO para lanzar excepciones en caso de errores
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Verificar si ya existe un usuario con el mismo nombre de usuario, excluyendo al usuario actual
  $sql = "SELECT COUNT(*) FROM usuario WHERE usuario = :usuario AND id <> :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':usuario', $usuario);
  $stmt->bindParam(':id', $id);
  $stmt->execute();

  $usuarioExistente = $stmt->fetchColumn();

  if ($usuarioExistente) {
    echo "Error: Ya existe un usuario con el mismo nombre de usuario";
    exit;
  }

  // Actualizar los datos del usuario
  $sql = "UPDATE usuario SET nombre = :nombre, usuario = :usuario, sexo = :sexo, fecha_nac = :fecha_nac WHERE id = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':nombre', $nombre);
  $stmt->bindParam(':usuario', $usuario);
  $stmt->bindParam(':sexo', $sexo);
  $stmt->bindParam(':fecha_nac', $fecha_nac);
  $stmt->bindParam(':id', $id);
  $stmt->execute();

  echo "Datos del usuario actualizados correctamente";
    
} catch(PDOException $e) {
  echo "Error de conexión: " . $e->getMessage();
}

?>
