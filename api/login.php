<?php
declare(strict_types=1);
header("Content-Type: application/json; charset=utf-8");

require __DIR__ . "/config.php";

$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

$email = strtolower(trim((string)($data["email"] ?? "")));
$pass  = (string)($data["password"] ?? "");

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $pass === "") {
  http_response_code(400);
  echo json_encode(["ok" => false, "error" => "Invalid credentials"]);
  exit;
}

$stmt = $pdo->prepare("SELECT id, email, pass_hash FROM users WHERE email = ? LIMIT 1");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user || !password_verify($pass, $user["pass_hash"])) {
  http_response_code(401);
  echo json_encode(["ok" => false, "error" => "Wrong email or password"]);
  exit;
}

// ✅ Login success: store minimal info in session
$_SESSION["user_id"] = (int)$user["id"];
$_SESSION["email"] = (string)$user["email"];

echo json_encode(["ok" => true]);
