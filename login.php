<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 簡單的身分驗證 (請根據實際需求修改驗證邏輯)
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['user_role'] = 'admin';
        header('Location: index.php');
        exit();
    } elseif ($username === 'store' && $password === 'store123') {
        $_SESSION['user_role'] = 'store_owner';
        header('Location: index.php');
        exit();
    } else {
        $error = '帳號或密碼錯誤';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登入</title>
</head>
<body>
    <h1>登入</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="username">帳號：</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">密碼：</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">登入</button>
    </form>
</body>
</html>
