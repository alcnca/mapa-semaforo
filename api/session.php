<?php
session_start();
header("Content-Type: application/json; charset=utf-8");

if (!isset($_SESSION["auth"])) {
  http_response_code(401);
  echo json_encode(["ok"=>false,"error"=>"No autenticado"]);
  exit;
}

echo json_encode(["ok"=>true,"auth"=>$_SESSION["auth"]]);
