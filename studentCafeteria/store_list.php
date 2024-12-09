<?php
// 引入資料庫連線
require 'db_connect.php';

try {
    // 執行 SQL 查詢
    $query = "SELECT * FROM store_list";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // 獲取查詢結果
    $stores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("查詢失敗：" . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>店家列表</title>
    <!-- 引入 Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">店家列表</h1>
    
    <!-- 返回首頁 -->
    <div class="mb-3">
         <a href="index.php" class="btn btn-secondary btn-sm">返回首頁</a>
    <!-- 查詢所有菜單 -->
         <a href="menu_items.php" class="btn btn-secondary btn-sm">查詢所有菜單</a>
    <!-- 查詢所有評論 -->
         <a href="feedback.php" class="btn btn-secondary btn-sm">查詢所有評論</a>
    </div>

    <?php if (!empty($stores)): ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>店家名稱</th>
                    <th>位置</th>
                    <th>營業時間</th>
                    <th>菜單</th>
                    <th>評論</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stores as $store): ?>
                    <tr>
                        <td><?= htmlspecialchars($store['store_name']) ?></td>
                        <td><?= htmlspecialchars($store['location']) ?></td>
                        <td><?= htmlspecialchars($store['opening_hours']) ?></td>
                        <td>
                            <a href="menu_items.php?store_id=<?= $store['store_id'] ?>" class="btn btn-primary btn-sm">查看菜單</a>
                        </td>
                        <td>
                            <a href="feedback.php?store_id=<?= $store['store_id'] ?>" class="btn btn-info btn-sm">查看評論</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">目前無店家資料</p>
    <?php endif; ?>
</div>

<!-- 引入 Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
