<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>فروشگاه گیمینگ</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<header>
    <h1>فروشگاه گیمینگ</h1>
    <nav>
        <a href="/index.php">خانه</a>
        <a href="/cart.php">سبد خرید</a>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="/logout.php">خروج</a>
        <?php else: ?>
            <a href="/login.php">ورود</a>
            <a href="/register.php">ثبت‌نام</a>
        <?php endif; ?>
    </nav>
</header>
<main>