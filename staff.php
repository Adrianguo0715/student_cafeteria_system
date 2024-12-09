<?php
require 'db_connect.php';

// Create
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $name = $_POST['staff_name'];
    $department = $_POST['department'];
    $grade = $_POST['grade'];
    $store_id = $_POST['store_id'];

    $stmt = $pdo->prepare("INSERT INTO staff (staff_name, department, grade, store_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $department, $grade, $store_id]);
    echo "Staff added successfully!";
}

// Read
$stmt = $pdo->query("SELECT * FROM staff");
$staff = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['staff_id'];
    $name = $_POST['staff_name'];
    $department = $_POST['department'];
    $grade = $_POST['grade'];
    $store_id = $_POST['store_id'];

    $stmt = $pdo->prepare("UPDATE staff SET staff_name = ?, department = ?, grade = ?, store_id = ? WHERE staff_id = ?");
    $stmt->execute([$name, $department, $grade, $store_id, $id]);
    echo "Staff updated successfully!";
}

// Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $id = $_POST['staff_id'];

    $stmt = $pdo->prepare("DELETE FROM staff WHERE staff_id = ?");
    $stmt->execute([$id]);
    echo "Staff deleted successfully!";
}
?>
