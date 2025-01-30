<?php

include 'db.php';
include 'auth.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isAuth()) {
        die("no permission");
    }
    if (isset($_POST['action'])) {
        switch($_POST['action']) {
            case 'toggle_permission':

                if (!isAdmin()) {
                    die("no permission");
                }

                $userID = intval($_POST['user_id']);

                if ($userID) {
                    $stmt = $pdo->prepare("UPDATE users SET can_edit = NOT can_edit WHERE id = ?");
                    $stmt->execute([$userID]);
                }

                break;
            default:
                die("unknown");
                break;
        }
    }
}

header("Location: index.php");
exit;

?>