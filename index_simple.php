<?php
// Simple test page without database
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BNG Shop - تست</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 40px;
            text-align: center;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        h1 {
            color: #667eea;
            margin-bottom: 20px;
        }
        .status {
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🛒 BNG Shop</h1>
        <p>فروشگاه گیفت کارت و محصولات دیجیتالی</p>
        
        <div class="status success">
            ✅ سایت آپلود شده و در حال کار است
        </div>
        
        <div class="status info">
            📋 مراحل باقی‌مانده:
            <br>1. تنظیم دیتابیس
            <br>2. اجرای فایل SQL
            <br>3. فعال‌سازی سایت کامل
        </div>
        
        <?php
        // Test database connection
        try {
            $pdo = new PDO(
                "mysql:host=localhost;dbname=bngshopi_bng_shop;charset=utf8mb4",
                'bngshopi_masiha1380',
                'masihabadboy'
            );
            echo '<div class="status success">✅ اتصال دیتابیس موفق</div>';
            
            // Check tables
            $stmt = $pdo->query("SHOW TABLES");
            $tables = $stmt->fetchAll();
            
            if (count($tables) > 0) {
                echo '<div class="status success">✅ جداول دیتابیس موجود (' . count($tables) . ' جدول)</div>';
            } else {
                echo '<div class="status error">❌ جداول دیتابیس موجود نیست - لطفاً فایل SQL را اجرا کنید</div>';
            }
            
        } catch (PDOException $e) {
            echo '<div class="status error">❌ خطا در اتصال دیتابیس: ' . $e->getMessage() . '</div>';
        }
        ?>
        
        <div style="margin-top: 30px;">
            <p><strong>برای ادامه:</strong></p>
            <p>1. فایل database/schema.sql را در phpMyAdmin اجرا کنید</p>
            <p>2. index.php اصلی را آپلود کنید</p>
        </div>
    </div>
</body>
</html>