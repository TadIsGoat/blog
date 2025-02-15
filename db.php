<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_db";

$conn = "mysql:host=$servername;dbname=$dbname;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($conn, $username, $password, $options);
} catch (PDOException $e) {
    die("Database connection failed:" . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'exportUsers':
                exportTables($pdo, ['users']);
                break;
            case 'exportProducts':
                exportTables($pdo, ['products']);
                break;
            case 'import':
                if (isset($_FILES['import_file']) && $_FILES['import_file']['error'] === UPLOAD_ERR_OK) {
                    $fileTmpPath = $_FILES['import_file']['tmp_name'];
                    $fileName = $_FILES['import_file']['name'];
                    $destPath = __DIR__ . '/' . $fileName;
                    if (move_uploaded_file($fileTmpPath, $destPath)) {
                        importTables($pdo, [$fileName]);
                    } else {
                        echo "There was an error moving the uploaded file.";
                    }
                } else {
                    echo "No file uploaded or there was an upload error.";
                }
                break;
            default:
                die("You can't do that!");
                break;
        }
    }
}

function exportTables($pdo, $tables) {
    foreach ($tables as $table) {
        $stmt = $pdo->query("SELECT * FROM $table");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $filename = "$table.json";
        file_put_contents($filename, json_encode($rows));
        echo "Exported $table to $filename<br>";
    }
}

function importTables($pdo, $files) {
    foreach ($files as $file) {
        $table = pathinfo($file, PATHINFO_FILENAME);
        if (file_exists($file)) {
            $data = json_decode(file_get_contents($file), true);
            $pdo->exec("TRUNCATE TABLE $table");
            foreach ($data as $row) {
                $columns = implode(", ", array_keys($row));
                $values = implode(", ", array_map([$pdo, 'quote'], array_values($row)));
                $pdo->exec("INSERT INTO $table ($columns) VALUES ($values)");
            }
            echo "Imported $table from $file<br>";
        } else {
            echo "File $file does not exist<br>";
        }
    }
}

?>