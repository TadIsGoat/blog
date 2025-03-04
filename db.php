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
    die("<script>alert('Database connection failed: " . $e->getMessage() . "'); window.location.href='index.php';</script>");
}

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    if (isset($_POST['otherAction'])) {
        switch ($_POST['otherAction']) {
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
                        echo "<script>alert('There was an error moving the uploaded file.'); window.location.href='index.php';</script>";
                    }
                } else {
                    echo "<script>alert('No file uploaded or there was an upload error.'); window.location.href='index.php';</script>";
                }
                break;
            default:
                die("<script>alert('You can\'t do that!'); window.location.href='index.php';</script>");
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
        echo "<script>alert('Exported $table to $filename'); window.location.href='index.php';</script>";
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
            echo "<script>alert('Imported $table from $file'); window.location.href='index.php';</script>";
        } else {    
            echo "<script>alert('File $file does not exist'); window.location.href='index.php';</script>";
        }
    }
}

?>