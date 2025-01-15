
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přihlášení</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container">
        <h1>Přihlášení</h1>
        <form method="POST" action="">
            <label for="username">Uživatelské jméno</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Heslo</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name="login">Přihlásit se</button>
        </form>

        <p>Ještě nemáte účet? <a href="register.php">Registrace</a></p>
        <p><a href="index.php">Zpět na hlavní stránku</a></p>
    </div>
</body>
</html>