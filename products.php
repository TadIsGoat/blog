<?php

function getProducts($pdo) {
    $stmt = $pdo->query("SELECT * FROM products");
    return $stmt->fetchAll();
}

function addProduct($pdo, $name, $description) {
    $stmt = $pdo->prepare("INSERT INTO products (nazev, popis) VALUES (?, ?)");
    $stmt->execute([$name, $description]);
}

function updateProduct($pdo, $id, $name, $description) {
    $stmt = $pdo->prepare("UPDATE products SET nazev = ?, popis = ? WHERE id = ?");
    $stmt->execute([$name, $description, $id]);
}

function deleteProduct($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
}

?>