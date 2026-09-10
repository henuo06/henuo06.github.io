<?php
declare(strict_types=1);
session_start();
if (!isset($_SESSION["user_id"])) {
  header("Location: /login.html");
  exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard</title>
  <style>
    body { font-family: system-ui, sans-serif; padding: 30px; background:#0b1220; color:#e5e7eb; }
    .card { max-width: 640px; margin: 0 auto; padding: 20px; border:1px solid rgba(255,255,255,.12); border-radius: 14px; background: rgba(255,255,255,.05); }
    a { color: #38bdf8; }
  </style>
</head>
<body>
  <div class="card">
    <h1>Logged in ✅</h1>
    <p>Welcome, <strong><?php echo htmlspecialchars((string)$_SESSION["email"]); ?></strong></p>
    <p><a href="/logout.php">Logout</a></p>
  </div>
</body>
</html>
