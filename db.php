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

?>