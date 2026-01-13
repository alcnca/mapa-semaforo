<?php
session_start();
require_once __DIR__ . "/db.php";

header("Content-Type: application/json; charset=utf-8");

$user = trim($_POST["user"] ?? "");
$pass = $_POST["pass"] ?? "";

if ($user === "" || $pass === "") {
  http_response_code(400);
  echo json_encode(["ok"=>false,"error"=>"Usuario y contraseña requeridos"]);
  exit;
}

$stmt = $pdo->prepare("
  SELECT u.usuario, u.pass_hash, u.rol, u.sucursal_code, s.nombre_suc, u.activo
  FROM usuarios_portal u
  LEFT JOIN cat_sucursales s ON s.sucursal_code = u.sucursal_code
  WHERE u.usuario = ?
  LIMIT 1
");
$stmt->execute([$user]);
$row = $stmt->fetch();

if (!$row || (int)$row["activo"] !== 1 || !password_verify($pass, $row["pass_hash"])) {
  http_response_code(401);
  echo json_encode(["ok"=>false,"error"=>"Credenciales inválidas"]);
  exit;
}

// Seguridad de sesión
session_regenerate_id(true);

$_SESSION["auth"] = [
  "usuario"       => $row["usuario"],
  "rol"           => $row["rol"],
  "sucursal_code" => $row["sucursal_code"],
  "nombre_suc"    => $row["nombre_suc"],
];

echo json_encode(["ok"=>true, "auth"=>$_SESSION["auth"]]);
