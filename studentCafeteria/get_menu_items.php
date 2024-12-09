<?php
// 引入資料庫連線
require 'db_connect.php';

try {
    // 獲取店家ID
    $store_id = isset($_GET['store_id']) ? $_GET['store_id'] : null;

    if ($store_id) {
        // 查詢該店家的品項
        $query = "SELECT * FROM menu_items WHERE store_id = :store_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['store_id' => $store_id]);
        $menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 返回品項資料為JSON格式
        echo json_encode($menu_items);
    } else {
        echo json_encode([]);
    }
} catch (PDOException $e) {
    die("查詢失敗：" . $e->getMessage());
}
