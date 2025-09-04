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
<div class="container">
  <h1>Welcome, <?php echo htmlspecialchars($username); ?></h1>
  <p>You are logged in.</p>
  <p><a href="logout.php">Logout</a></p>
</div>
</body>
</html>
