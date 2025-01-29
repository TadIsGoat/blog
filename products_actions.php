<?php

include 'db.php';
include 'auth.php';
include 'products.php';

if (!isAuth() || !hasPerm()) {
    die("You don't have permission to do this.");
}

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $name = trim($_POST['nazev']);
                $desc = trim($_POST['popis']);
                if($name && $desc) {
                    addProduct($pdo, $name, $desc);
                }
                break;
            case 'edit':
                $id = intval($_POST['id']);
                $name = trim($_POST['nazev']);
                $desc = trim($_POST['popis']);
                if($id && $name && $desc) {
                    updateProduct($pdo, $id, $name, $desc);
                }
                break;
            case 'delete':
                $id = intval($_POST['id']);
                if($id) {
                    deleteProduct($pdo, $id);
                }
                break;
            default:
                die("th u doin?");
                break;
        }
    }
}

header("Location: index.php");
exit;

?>