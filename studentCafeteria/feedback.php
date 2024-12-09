<?php
// 引入資料庫連線
require 'db_connect.php';

try {
    // 檢查是否有提供 store_id
    $store_id = isset($_GET['store_id']) ? $_GET['store_id'] : null;

    // 查詢評論及店家名稱
    if ($store_id) {
        $query = "
            SELECT f.*, s.store_name 
            FROM feedback f 
            JOIN store_list s ON f.store_id = s.store_id 
            WHERE f.store_id = :store_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['store_id' => $store_id]);
    } else {
        $query = "
            SELECT f.*, s.store_name 
            FROM feedback f 
            JOIN store_list s ON f.store_id = s.store_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    }

    // 獲取查詢結果
    $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 查詢店家列表
    $store_query = "SELECT * FROM store_list";
    $store_stmt = $pdo->prepare($store_query);
    $store_stmt->execute();
    $stores = $store_stmt->fetchAll(PDO::FETCH_ASSOC);

    // 查詢選定店家的品項
    if ($store_id) {
        $menu_query = "SELECT * FROM menu_items WHERE store_id = :store_id";
        $menu_stmt = $pdo->prepare($menu_query);
        $menu_stmt->execute(['store_id' => $store_id]);
        $menu_items = $menu_stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $menu_items = [];
    }
} catch (PDOException $e) {
    die("查詢失敗：" . $e->getMessage());
}

// 遮住顧客名稱中間部分，保留首尾字元
function maskCustomerName($name) {
    if (strlen($name) <= 2) {
        return $name; // 若姓名長度小於等於2，則不進行遮擋
    }
    $first_char = mb_substr($name, 0, 1); // 取首字
    $last_char = mb_substr($name, -1); // 取尾字
    $masked_name = $first_char . str_repeat('*', mb_strlen($name) - 2) . $last_char;
    return $masked_name;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>店家評論</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">店家評論</h1>

        <!-- 返回首頁 -->
        <div class="mb-3">
            <a href="index.php" class="btn btn-secondary btn-sm">返回首頁</a>
        <!-- 查詢所有店家 -->     
            <a href="store_list.php" class="btn btn-secondary btn-sm">查詢所有店家</a>
        <!-- 查詢所有菜單 -->
            <a href="menu_items.php" class="btn btn-secondary btn-sm">查詢所有菜單</a>                  
        </div>

        <!-- 現有評論 -->
        <h3>評論列表</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>顧客名稱</th>
                    <th>店家名稱</th>
                    <th>評論內容</th>
                    <th>評論時間</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($feedbacks)): ?>
                    <?php foreach ($feedbacks as $feedback): ?>
                        <tr>
                            <td><?= maskCustomerName($feedback['customer_name']) ?></td>
                            <td><?= htmlspecialchars($feedback['store_name']) ?></td>
                            <td><?= htmlspecialchars($feedback['feedback_content']) ?></td>
                            <td><?= htmlspecialchars($feedback['feedback_time']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">目前沒有評論</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- 新增評論表單 -->
        <h3 class="mt-5">新增評論</h3>
        <form method="POST" action="submit_feedback.php" onsubmit="return validateForm()">
            <div class="mb-3">
                <label for="store_id" class="form-label">選擇店家</label>
                <select class="form-select" name="store_id" id="store_id" required onchange="loadMenuItems()">
                    <option value="" disabled selected>請選擇店家</option>
                    <?php foreach ($stores as $store): ?>
                        <option value="<?= $store['store_id'] ?>" <?= $store_id == $store['store_id'] ? 'selected' : '' ?>><?= $store['store_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="item_id" class="form-label">選擇品項</label>
                <select class="form-select" name="item_id" id="item_id" required>
                    <option value="" disabled selected>請選擇品項</option>
                    <?php if (!empty($menu_items)): ?>
                        <?php foreach ($menu_items as $menu_item): ?>
                            <option value="<?= $menu_item['item_id'] ?>"><?= $menu_item['item_name'] ?></option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="" disabled>無品項資料</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="customer_name" class="form-label">顧客姓名</label>
                <input type="text" class="form-control" name="customer_name" id="customer_name" required>
            </div>

            <div class="mb-3">
                <label for="feedback_content" class="form-label">評論內容</label>
                <textarea class="form-control" name="feedback_content" id="feedback_content" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">提交評論</button>
        </form>
    </div>

    <script>
        // 驗證表單是否填寫完整
        function validateForm() {
            const storeId = document.getElementById('store_id').value;
            const itemId = document.getElementById('item_id').value;
            const customerName = document.getElementById('customer_name').value;
            const feedbackContent = document.getElementById('feedback_content').value;

            if (!storeId || !itemId || !customerName || !feedbackContent) {
                alert('請完整填寫所有欄位');
                return false;
            }

            return true;
        }

        // 當選擇店家時，根據店家ID動態更新品項選單
        function loadMenuItems() {
            const storeId = document.getElementById('store_id').value;

            if (storeId) {
                fetch('get_menu_items.php?store_id=' + storeId)
                    .then(response => response.json())
                    .then(data => {
                        const itemSelect = document.getElementById('item_id');
                        itemSelect.innerHTML = '<option value="" disabled selected>請選擇品項</option>';
                        if (data.length > 0) {
                            data.forEach(item => {
                                const option = document.createElement('option');
                                option.value = item.item_id;
                                option.textContent = item.item_name;
                                itemSelect.appendChild(option);
                            });
                        } else {
                            itemSelect.innerHTML = '<option value="" disabled>無品項資料</option>';
                        }
                    })
                    .catch(error => console.error('錯誤:', error));
            }
        }
    </script>
</body>
</html>
