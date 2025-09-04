<?php
require 'config.php';
session_start();
$errors = [];
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if (!$username || !$password) {
        $errors[] = 'Please fill all fields';
    } else {
        $stmt = $pdo->prepare('SELECT id, password, username FROM users WHERE username = ? OR email = ?');
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: dashboard.php');
            exit;
        } else {
            $errors[] = 'Invalid credentials';
        }
    }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Login</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
  <h1>Login</h1>
  <?php if (isset($_GET['registered'])): ?>
    <div class="success">Registration successful. Please log in.</div>
  <?php endif; ?>
  <?php if ($errors): ?>
    <div class="errors"><?php echo implode('<br>', $errors); ?></div>
  <?php endif; ?>
  <form method="post" action="index.php">
    <label>Username or Email</label>
    <input type="text" name="username" required>
    <label>Password</label>
    <input type="password" name="password" required>
    <button type="submit">Login</button>
  </form>
  <p>No account? <a href="register.php">Register</a></p>
</div>
</body>
</html>
