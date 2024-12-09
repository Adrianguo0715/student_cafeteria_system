<?php
// 引入資料庫連線
require 'db_connect.php';

try {
    // 檢查是否填寫完整
    if (!isset($_POST['store_id'], $_POST['item_id'], $_POST['customer_name'], $_POST['feedback_content'])) {
        throw new Exception("請完整填寫所有欄位");
    }

    $store_id = $_POST['store_id'];
    $item_id = $_POST['item_id'];
    $customer_name = $_POST['customer_name'];
    $feedback_content = $_POST['feedback_content'];

    // 插入資料到 feedback 表
    $query = "
        INSERT INTO feedback (store_id, item_id, customer_name, feedback_content, feedback_time)
        VALUES (:store_id, :item_id, :customer_name, :feedback_content, NOW())";
    $stmt = $pdo->prepare($query);

    $stmt->execute([
        'store_id' => $store_id,
        'item_id' => $item_id,
        'customer_name' => $customer_name,
        'feedback_content' => $feedback_content,
    ]);

    echo "評論提交成功！";
} catch (Exception $e) {
    echo "提交失敗：" . $e->getMessage();
}
?>
