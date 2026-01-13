<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

$users = require __DIR__ . '/../config/users.php';

$input = json_decode(file_get_contents('php://input'), true) ?: [];
$user = strtoupper(trim($input['user'] ?? ''));
$pass = (string)($input['pass'] ?? '');

if (!$user || !$pass || !isset($users[$user])) {
  http_response_code(401);
  echo json_encode(['ok'=>false,'error'=>'Credenciales inválidas']);
  exit;
}

$u = $users[$user];
if (!password_verify($pass, $u['hash'])) {
  http_response_code(401);
  echo json_encode(['ok'=>false,'error'=>'Credenciales inválidas']);
  exit;
}

$_SESSION['user'] = $user;
$_SESSION['role'] = $u['role'];
$_SESSION['sucursal'] = $u['sucursal'];

echo json_encode(['ok'=>true,'role'=>$u['role'],'sucursal'=>$u['sucursal']]);
