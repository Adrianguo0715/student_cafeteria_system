<?php
require 'db_connect.php';

// Create
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $store_id = $_POST['store_id'];
    $name = $_POST['owner_name'];
    $phone = $_POST['owner_phone'];
    $email = $_POST['owner_email'];

    $stmt = $pdo->prepare("INSERT INTO owners (store_id, owner_name, owner_phone, owner_email) VALUES (?, ?, ?, ?)");
    $stmt->execute([$store_id, $name, $phone, $email]);
    echo "Owner added successfully!";
}

// Read
$stmt = $pdo->query("SELECT * FROM owners");
$owners = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['owner_id'];
    $store_id = $_POST['store_id'];
    $name = $_POST['owner_name'];
    $phone = $_POST['owner_phone'];
    $email = $_POST['owner_email'];

    $stmt = $pdo->prepare("UPDATE owners SET store_id = ?, owner_name = ?, owner_phone = ?, owner_email = ? WHERE owner_id = ?");
    $stmt->execute([$store_id, $name, $phone, $email, $id]);
    echo "Owner updated successfully!";
}

// Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $id = $_POST['owner_id'];

    $stmt = $pdo->prepare("DELETE FROM owners WHERE owner_id = ?");
    $stmt->execute([$id]);
    echo "Owner deleted successfully!";
}
?>
