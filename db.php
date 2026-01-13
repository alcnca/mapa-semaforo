<?php
// db.php
$DB_HOST = "db5019389882.hosting-data.io";
$DB_NAME = "dbs15170198";
$DB_USER = "dbu1657888";
$DB_PASS = "Binario12##==";

$pdo = new PDO(
  "mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4",
  $DB_USER,
  $DB_PASS,
  [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ]
);
