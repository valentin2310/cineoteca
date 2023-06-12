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
    $password_old = $data['password_old'];
    $password_new = $data['password_new'];
    $password2_new = $data['password2_new'];
}

if (!preg_match('/^[A-Za-zÑñ0-9_#.]{5,30}$/', $password_new)) {
  echo "Error: La contraseña no cumple con el formato válido (debe contener entre 5 y 30 caracteres alfanuméricos, guiones bajos, almohadillas o puntos).";
  exit;
}

// Verificar si la contraseña coincide con la confirmación de contraseña
if ($password_new !== $password2_new) {
  echo "Error: La contraseña y la confirmación de contraseña no coinciden.";
  exit;
}

try {
  // Crear una instancia de PDO para establecer la conexión con la base de datos
  $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
  // Configurar el modo de error de PDO para lanzar excepciones en caso de errores
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Verificar si ya existe un usuario con el mismo nombre de usuario
  $sql = "SELECT COUNT(*) FROM usuario WHERE id = :id AND password LIKE :password";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $id);
  $stmt->bindParam(':password', $password_old);
  $stmt->execute();

  $usuarioCorrecto = $stmt->fetchColumn();

  if (!$usuarioCorrecto) {
    echo "Error: La contraseña no es correcta";
    exit;
  }

  $sql = "UPDATE usuario SET password = :password WHERE id = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $id);
  $stmt->bindParam(':password', $password_new);
  $stmt->execute();

  echo "Contraseña actualizada correctamente";
    
} catch(PDOException $e) {
  echo "Error de conexión: " . $e->getMessage();
}

?>