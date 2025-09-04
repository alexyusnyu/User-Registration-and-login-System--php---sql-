<?php
require 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
$username = $_SESSION['username'];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Dashboard</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container dashboard">
  <div class="welcome-card">
    <h1>Welcome, <?php echo htmlspecialchars($username); ?></h1>
    <p>You are logged in</p>
    <a href="logout.php" class="btn-logout">Logout</a>
  </div>
</div>
</body>
</html>
