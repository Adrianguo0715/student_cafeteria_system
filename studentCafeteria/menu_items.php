<?php
// 引入資料庫連線
require 'db_connect.php';

// 預設空陣列來儲存菜單資料
$menu_items = [];

// 檢查是否傳遞 store_id，並進行查詢
if (isset($_GET['store_id'])) {
    $store_id = $_GET['store_id'];

    try {
        // 查詢指定店家的菜單項目
        $query = "SELECT * FROM menu_items WHERE store_id = :store_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':store_id', $store_id, PDO::PARAM_INT);
        $stmt->execute();

        // 獲取查詢結果
        $menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("查詢失敗：" . $e->getMessage());
    }

} else {
    // 如果沒有傳遞 store_id，則查詢所有店家的菜單
    try {
        $query = "SELECT menu_items.*, store_list.store_name FROM menu_items
                  JOIN store_list ON menu_items.store_id = store_list.store_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        // 獲取所有菜單資料及店名
        $menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("查詢失敗：" . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>菜單列表</title>
    <!-- 引入 Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">菜單列表</h1>
    
    <!-- 返回首頁 -->
    <div class="mb-3">
         <a href="index.php" class="btn btn-secondary btn-sm">返回首頁</a>
    <!-- 查詢所有店家 -->     
         <a href="store_list.php" class="btn btn-secondary btn-sm">查詢所有店家</a>
    <!-- 查詢所有評論 -->
         <a href="feedback.php" class="btn btn-secondary btn-sm">查詢所有評論</a>
    </div>


    <?php if (!empty($menu_items)): ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <?php if (!isset($store_id)): ?>
                        <th>店家名稱</th>
                    <?php endif; ?>
                    <th>品項名稱</th>
                    <th>類別</th>
                    <th>價格</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($menu_items as $item): ?>
                    <tr>
                        <?php if (!isset($store_id)): ?>
                            <td><?= htmlspecialchars($item['store_name']) ?></td>
                        <?php endif; ?>
                        <td><?= htmlspecialchars($item['item_name']) ?></td>
                        <td><?= htmlspecialchars($item['category']) ?></td>
                        <td><?= htmlspecialchars($item['price']) ?> 元</td>
                        <td>
                            <!-- 新增查看評論按鈕 -->
                            <a href="feedback.php?store_id=<?= htmlspecialchars($item['store_id']) ?>&item_id=<?= htmlspecialchars($item['item_id']) ?>" class="btn btn-primary btn-sm">查看評論</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">目前沒有菜單資料。</p>
    <?php endif; ?>
</div>

<!-- 引入 Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
