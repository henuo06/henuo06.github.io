<?php
declare(strict_types=1);

session_start();

// ✅ Fill these in from Hetzner MariaDB/MySQL panel
$dbHost = "k5jp.your-database.de";     // or the host Hetzner shows
$dbName = "dzptfy_db1";
$dbUser = "dzptfy_1";
$dbPass = "f7(T{&~w;GXX";

$dsn = "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4";

try {
  $pdo = new PDO($dsn, $dbUser, $dbPass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
  ]);
} catch (Throwable $e) {
  http_response_code(500);
  header("Content-Type: application/json; charset=utf-8");
  echo json_encode(["ok" => false, "error" => "DB connection failed"]);
  exit;
}
