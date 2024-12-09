<?php
session_start();

// 檢查登入狀態
$is_logged_in = isset($_SESSION['user_role']); // user_role 可以是 'guest', 'store_owner', 'admin'

// 預設角色為訪客
$user_role = $is_logged_in ? $_SESSION['user_role'] : 'guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>學生餐廳管理系統</title>
    <!-- 引入 Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .navbar {
            display: flex;
            justify-content: center; /* 將導航列的元素置中 */
            background-color: #f4f4f4;
            padding: 10px;
        }
        .navbar a {
            text-decoration: none;
            color: #333;
            margin: 0 15px;
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        .content {
            margin: 20px;
            text-align: center; /* 將內容區的文字置中 */
        }
        .login-status {
            position: absolute;
            right: 20px;
            top: 10px;
        }
        .carousel-inner img {
            max-height: 500px; /* 調整圖片高度 */
            object-fit: cover;
        }
        .bulletin-board .post {
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>
    <!-- 導覽列 -->
    <div class="navbar">
        <a href="index.php">首頁</a>
        <a href="store_list.php">查詢店家</a>
        <a href="menu_items.php">查詢菜單</a>
        <a href="feedback.php">查看評論</a>
        <div class="login-status">
            <?php if (!$is_logged_in): ?>
                <a href="login.php">登入</a>
            <?php else: ?>
                <span>歡迎, <?= htmlspecialchars($user_role) ?></span>
                <a href="logout.php">登出</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- 主內容 -->
    <div class="content">
        <h1>歡迎來到學生餐廳管理系統</h1>
        <?php if ($user_role === 'guest'): ?>
            <p>您目前以訪客身份瀏覽，可查詢店家資訊與菜單。</p>
        <?php elseif ($user_role === 'store_owner'): ?>
            <p>您已登入為店家，您可以管理菜單與員工資料。</p>
        <?php elseif ($user_role === 'admin'): ?>
            <p>您已登入為管理者，您可以管理所有系統資料。</p>
        <?php endif; ?>

        <!-- 插入循環式滾動 gallery -->
        <div class="mt-5">
            <h3>最新畫廊</h3>
            <?php
            // 引入Gallery類別並顯示圖片
            require 'Gallery.php';
            $gallery = new Gallery('images/gallery'); // 假設圖片資料夾位置
            $gallery->display();
            ?>
        </div>

        <div class="mt-5">
        <h3>布告欄</h3>
            <div class="container" style="max-width: 800px; background-color: #f9f9f9; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <?php
                // 引入BulletinBoard類別並顯示公告
                require 'BulletinBoard.php';
                $bulletin_messages = [
                    '歡迎使用學生餐廳管理系統。',
                    '今天的午餐有新菜單，快來看看！',
                    '有任何問題，請聯繫管理員。'
                ];
                $bulletin = new BulletinBoard($bulletin_messages);
                $bulletin->display();
                ?>
            </div>
        </div>

        </div>

    <!-- 引入 Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
