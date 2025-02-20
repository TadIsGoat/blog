<?php

include 'db.php';
include 'auth.php';
include 'products.php';

$products = getProducts($pdo);
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
    <?php if (isAuth() && hasPerm()): ?>
        <form method="POST" action="products_actions.php">
            <input type="hidden" name="action" value="add">
            <label for="nazev">Name:</label>
            <input type="text" id="nazev" name="nazev" required>
            <label for="popis">Description:</label>
            <input type="text" id="popis" name="popis" required>
            <button type="submit">Add</button>

        </form>
    <?php else: ?>
        <p style="color: red;">Login to add products</p>
    <?php endif; ?>

    <h2>Product list</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Název</th>
            <th>Popis</th>
            <?php if (isAuth() && hasPerm()): ?><th>Action</th><?php endif; ?>
        </tr>

        <?php foreach ($products as $product): ?>
        
        <tr>
            <td><?= htmlspecialchars($product['id']) ?></td>
            <td><?= htmlspecialchars($product['nazev']) ?></td>
            <td><?= htmlspecialchars($product['popis']) ?></td>

            <?php if (isAuth() && hasPerm()): ?>
            <td>
                <form method="POST" action="products_actions.php" style="display: inline;">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                    <input type="text" name="nazev" value="<?= htmlspecialchars($product['nazev']) ?>" required>
                    <input type="text" name="popis" value="<?= htmlspecialchars($product['popis']) ?>" required>
                    <button type="submit">Edit</button>
                </form>
                <form method="POST" action="products_actions.php" style="display: inline;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
            <?php endif; ?>

        </tr>

        <?php endforeach; ?>

    </table>

    <?php if (isAdmin()): ?>
    <h2>User administartion</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Editing allowed</th>
                <th>Action</th>
            </tr>
            <?php
            $stmt = $pdo->query("SELECT id, username, role, can_edit FROM users");
            $users = $stmt->fetchAll();
            foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['role']) ?></td>
                    <td><?= $user['can_edit'] ? 'Yes' : 'No' ?></td>
                    <td>
                        <form method="POST" action="users_actions.php">
                            <input type="hidden" name="action" value="toggle_permission">
                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                            <button type="submit">
                                <?= $user['can_edit'] ? 'Deny' : 'Allow' ?>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

    <h2>Database export import</h2>
        <form method="POST" action="db.php">
            <label for="export">Export</label>
            <select name="otherAction">
                <option value="exportUsers">Export Users</option>
                <option value="exportProducts">Export Products</option>
            </select>
            <button type="submit">Export</button>   
        </form>
        <br>
        <form method="POST" action="db.php" enctype="multipart/form-data">
            <label for="import">Import</label>
            <input type="hidden" name="otherAction" value="import">
            <input type="file" name="import_file" required>
            <button type="submit">Import</button>
        </form>
    <?php endif; ?>

</body>
</html>