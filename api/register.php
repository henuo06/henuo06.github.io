<?php
declare(strict_types=1);
header("Content-Type: application/json; charset=utf-8");

require __DIR__ . "/config.php";

$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

$email = strtolower(trim((string)($data["email"] ?? "")));
$pass  = (string)($data["password"] ?? "");

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  http_response_code(400);
  echo json_encode(["ok" => false, "error" => "Invalid email"]);
  exit;
}
if (strlen($pass) < 10) {
  http_response_code(400);
  echo json_encode(["ok" => false, "error" => "Password must be at least 10 characters"]);
  exit;
}

$hash = password_hash($pass, PASSWORD_DEFAULT);

try {
  $stmt = $pdo->prepare("INSERT INTO users (email, pass_hash) VALUES (?, ?)");
  $stmt->execute([$email, $hash]);
  echo json_encode(["ok" => true]);
} catch (Throwable $e) {
  // Duplicate email
  if ((int)($pdo->errorInfo()[1] ?? 0) === 1062) {
    http_response_code(409);
    echo json_encode(["ok" => false, "error" => "Email already registered"]);
    exit;
  }
  http_response_code(500);
  echo json_encode(["ok" => false, "error" => "Server error"]);
}
