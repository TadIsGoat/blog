<?php

include 'db.php';
include 'auth.php';

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>O' mighty page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>jklasdofsldaibfhlbg</h1>
    <div class="menu">
    <div style="text-align: center; margin-bottom: 20px;">

    <?php if(isAuth()): ?>
        <span>Hiii, <?= htmlspecialchars($_SESSION['user']['username']) ?></span>
        <a href="logout.php"><button>Log out</button></a>
    <?php else: ?>
        <a href="login.php"><button>Log in</button></a>
        <a href="register.php"><button>Sign in</button></a>
    <?php endif; ?>
    </div>
    </div>
    <h2>Add new product</h2>
    <h2>Product list</h2>
    <h2>User administartion</h2>
</body>
</html>