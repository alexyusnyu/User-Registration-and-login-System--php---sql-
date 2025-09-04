<?php
require 'config.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if (!$username || !$email || !$password) {
        $errors[] = 'Please fill all fields';
    }
    if (!$errors) {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ? OR email = ?');
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $errors[] = 'Username or email already taken';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
            if ($stmt->execute([$username, $email, $hash])) {
                header('Location: index.php?registered=1');
                exit;
            } else {
                $errors[] = 'Registration failed';
            }
        }
    }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Register</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
  <h1>Register</h1>
  <?php if ($errors): ?>
    <div class="errors"><?php echo implode('<br>', $errors); ?></div>
  <?php endif; ?>
  <form method="post" action="register.php">
    <label>Username</label>
    <input type="text" name="username" value="<?php echo htmlspecialchars($username ?? ''); ?>" required>
    <label>Email</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
    <label>Password</label>
    <input type="password" name="password" required>
    <button type="submit">Register</button>
  </form>
  <p>Already have an account? <a href="index.php">Login</a></p>
</div>
</body>
</html>
