<?php
require 'db_connect.php';

// Create
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $store_id = $_POST['store_id'];
    $staff_id = $_POST['staff_id'];
    $customer_name = $_POST['customer_name'];
    $total_amount = $_POST['total_amount'];

    $stmt = $pdo->prepare("INSERT INTO orders (store_id, staff_id, customer_name, total_amount) VALUES (?, ?, ?, ?)");
    $stmt->execute([$store_id, $staff_id, $customer_name, $total_amount]);
    echo "Order added successfully!";
}

// Read
$stmt = $pdo->query("SELECT * FROM orders");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['order_id'];
    $store_id = $_POST['store_id'];
    $staff_id = $_POST['staff_id'];
    $customer_name = $_POST['customer_name'];
    $total_amount = $_POST['total_amount'];

    $stmt = $pdo->prepare("UPDATE orders SET store_id = ?, staff_id = ?, customer_name = ?, total_amount = ? WHERE order_id = ?");
    $stmt->execute([$store_id, $staff_id, $customer_name, $total_amount, $id]);
    echo "Order updated successfully!";
}

// Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $id = $_POST['order_id'];

    $stmt = $pdo->prepare("DELETE FROM orders WHERE order_id = ?");
    $stmt->execute([$id]);
    echo "Order deleted successfully!";
}
?>
