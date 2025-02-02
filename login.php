<?php

session_start();
require_once 'config.php';
require_once 'functions.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        $user = getUserByEmail($conn, $email);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];

            error_log("User logged in - ID: " . $user['id'] . ", Role: " . $user['role']);

            if ($user['role'] === 'admin') {
                header("Location: admin-dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error = "Invalid email or password.";
            error_log("Failed login attempt for email: " . $email);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Eventura</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
      <div class="login-card">
        <div class="logo-placeholder">
          <img src="./uploads/eventura.png" alt="Logo" style="max-height: 50px;">
        </div>
        <h2>Login</h2>
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="success"><?php echo htmlspecialchars($_SESSION['success_message']); unset($_SESSION['success_message']); ?></div>
        <?php endif; ?>
        <form id="loginForm" method="POST" action="login.php">
          <div class="form-group">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" placeholder="Enter your email">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password">
          </div>
          <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
      </div>
    </div>
    <script src="login1.js"></script>
</body>
</html>

