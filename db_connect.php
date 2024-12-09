<?php
// 從環境變數中取得資料庫連線資訊
$host = getenv('DB_HOST');
$db = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');

// 檢查環境變數是否設置正確
if (!$host || !$db || !$user || !$pass) {
    die("Database connection details are missing.");
}

try {
    // 建立 PDO 連線
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
