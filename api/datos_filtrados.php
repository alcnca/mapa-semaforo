<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['user'], $_SESSION['role'])) {
  http_response_code(401);
  echo json_encode(['ok'=>false,'error'=>'No autenticado']);
  exit;
}

$role = $_SESSION['role'];
$suc  = $_SESSION['sucursal'];

// Fuente original (GitHub raw)
$url = "https://raw.githubusercontent.com/alcnca/mapa-semaforo/main/datos.json";
$json = @file_get_contents($url);
if ($json === false) {
  http_response_code(502);
  echo json_encode(['ok'=>false,'error'=>'No se pudo leer datos.json']);
  exit;
}

$data = json_decode($json, true);
if (!is_array($data)) {
  http_response_code(500);
  echo json_encode(['ok'=>false,'error'=>'JSON inválido']);
  exit;
}

// Si es coordinador ALCNCA: puedes devolver todo, o solo Coordinador=ALCNCA
if ($role === 'COORD') {
  // Recomendación: filtrar solo lo tuyo
  $out = array_values(array_filter($data, function($r){
    $c = strtoupper(trim($r['Coordinador'] ?? $r['coordinador'] ?? ''));
    return $c === 'ALCNCA'; // tu coordinación
  }));
  echo json_encode($out);
  exit;
}

// Si es sucursal: devolver solo su sucursal y de ALCNCA
if ($role === 'BRANCH') {
  $sucNorm = strtoupper(trim($suc));
  $out = array_values(array_filter($data, function($r) use ($sucNorm){
    $s = strtoupper(trim($r['Sucursal'] ?? ''));
    $c = strtoupper(trim($r['Coordinador'] ?? $r['coordinador'] ?? ''));
    return $c === 'ALCNCA' && $s === $sucNorm;
  }));
  echo json_encode($out);
  exit;
}

http_response_code(403);
echo json_encode(['ok'=>false,'error'=>'Rol no permitido']);
