<?php

include "db.php";
include "auth.php";

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if($user && password_verify($password, $user['password'])) {
        $_SESSION["user"] = $user;
        header("Location: index.php");
        exit;
    } else {
        $error = "wrong username or password";
    }
}
?>



<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container">
        <h1>Log in</h1>

        <?php if(isset($error)): ?>
            <p class="error"><?= htmlspcialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name="login">Login</button>
        </form>

        <p>You don't have an account yet? <a href="register.php">Register</a></p>
        <p><a href="index.php">Back to home page</a></p>
    </div>
</body>
</html>