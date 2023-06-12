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
    $nombre = $data['nombre'];
    $usuario = $data['usuario'];
    $password = $data['password'];
    $password2 = $data['password2'];
    $sexo = $data['sexo'];
    $fecha_nac = $data['fecha_nac'];
}

// Validar el usuario, el nombre y la contraseña
if (!preg_match('/^[A-Za-zÑñ0-9_]{5,20}$/', $usuario)) {
  echo "Error: El usuario no cumple con el formato válido (debe contener entre 5 y 20 caracteres alfanuméricos y guiones bajos).";
  exit;
}

if (!preg_match('/^[A-Za-zÑñ]{3}[A-Za-zÑñ ]{0,27}$/', $nombre)) {
  echo "Error: El nombre no cumple con el formato válido (debe contener al menos 3 letras, seguidas de letras, espacios o tildes, con un máximo de 30 caracteres en total).";
  exit;
}

if (!preg_match('/^[A-Za-zÑñ0-9_#.]{5,30}$/', $password)) {
  echo "Error: La contraseña no cumple con el formato válido (debe contener entre 5 y 30 caracteres alfanuméricos, guiones bajos, almohadillas o puntos).";
  exit;
}

// Verificar si la contraseña coincide con la confirmación de contraseña
if ($password !== $password2) {
  echo "Error: La contraseña y la confirmación de contraseña no coinciden.";
  exit;
}

try {
  // Crear una instancia de PDO para establecer la conexión con la base de datos
  $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
  // Configurar el modo de error de PDO para lanzar excepciones en caso de errores
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Verificar si ya existe un usuario con el mismo nombre de usuario
  $sql = "SELECT COUNT(*) FROM usuario WHERE usuario = :usuario";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':usuario', $usuario);
  $stmt->execute();

  $usuarioExistente = $stmt->fetchColumn();

  if ($usuarioExistente) {
    echo "Error: Ya existe un usuario con el mismo nombre de usuario";
    exit;
  }

  $sql = "insert into usuario(`nombre`, `usuario`, `password`, `sexo`, `fecha_nac`) values(:nombre, :usuario, :password, :sexo, :fecha_nac)";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':nombre', $nombre);
  $stmt->bindParam(':usuario', $usuario);
  $stmt->bindParam(':password', $password);
  $stmt->bindParam(':sexo', $sexo);
  $stmt->bindParam(':fecha_nac', $fecha_nac);
  $stmt->execute();

  echo "Usuario insertado correctamente";
    
} catch(PDOException $e) {
  echo "Error de conexión: " . $e->getMessage();
}

?>