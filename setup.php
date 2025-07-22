<?php
require_once 'config/config.php';

// Check if setup is already done
if (file_exists('setup_done.flag')) {
    die('Setup already completed. Delete setup_done.flag to run again.');
}

echo "<!DOCTYPE html>";
echo "<html lang='fa' dir='rtl'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<title>راه‌اندازی فروشگاه گیمینگ</title>";
echo "<style>";
echo "body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; direction: rtl; }";
echo ".success { color: green; } .error { color: red; } .info { color: blue; }";
echo "pre { background: #f5f5f5; padding: 15px; border-radius: 5px; overflow-x: auto; }";
echo "</style>";
echo "</head>";
echo "<body>";

echo "<h1>راه‌اندازی فروشگاه گیمینگ</h1>";

$errors = [];
$success = [];

// Create directories
$directories = [
    'uploads',
    'uploads/products',
    'uploads/categories',
    'uploads/users'
];

echo "<h2>ایجاد پوشه‌ها...</h2>";
foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        if (mkdir($dir, 0755, true)) {
            $success[] = "پوشه $dir ایجاد شد";
            echo "<p class='success'>✓ پوشه $dir ایجاد شد</p>";
        } else {
            $errors[] = "خطا در ایجاد پوشه $dir";
            echo "<p class='error'>✗ خطا در ایجاد پوشه $dir</p>";
        }
    } else {
        echo "<p class='info'>→ پوشه $dir قبلاً وجود دارد</p>";
    }
}

// Execute database schema
echo "<h2>راه‌اندازی دیتابیس...</h2>";
try {
    $schema = file_get_contents('database/schema.sql');
    $statements = array_filter(array_map('trim', explode(';', $schema)));
    
    foreach ($statements as $statement) {
        if (!empty($statement)) {
            $pdo->exec($statement);
        }
    }
    
    $success[] = "دیتابیس با موفقیت راه‌اندازی شد";
    echo "<p class='success'>✓ دیتابیس با موفقیت راه‌اندازی شد</p>";
    
} catch (PDOException $e) {
    $errors[] = "خطا در راه‌اندازی دیتابیس: " . $e->getMessage();
    echo "<p class='error'>✗ خطا در راه‌اندازی دیتابیس: " . $e->getMessage() . "</p>";
}

// Check if admin user exists
echo "<h2>بررسی کاربر مدیر...</h2>";
try {
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users WHERE role = 'admin'");
    $result = $stmt->fetch();
    
    if ($result['count'] > 0) {
        echo "<p class='success'>✓ کاربر مدیر موجود است</p>";
        echo "<p class='info'>→ اطلاعات ورود مدیر: admin@gaming-store.com / admin123</p>";
    } else {
        // Create admin user
        $admin_password = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, full_name, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute(['admin', 'admin@gaming-store.com', $admin_password, 'مدیر سایت', 'admin']);
        
        echo "<p class='success'>✓ کاربر مدیر ایجاد شد</p>";
        echo "<p class='info'>→ اطلاعات ورود مدیر: admin@gaming-store.com / admin123</p>";
    }
} catch (PDOException $e) {
    $errors[] = "خطا در ایجاد کاربر مدیر: " . $e->getMessage();
    echo "<p class='error'>✗ خطا در ایجاد کاربر مدیر: " . $e->getMessage() . "</p>";
}

// Check file permissions
echo "<h2>بررسی مجوزها...</h2>";
$writable_paths = ['uploads', 'config'];
foreach ($writable_paths as $path) {
    if (is_writable($path)) {
        echo "<p class='success'>✓ پوشه $path قابل نوشتن است</p>";
    } else {
        echo "<p class='error'>✗ پوشه $path قابل نوشتن نیست</p>";
        $errors[] = "پوشه $path قابل نوشتن نیست";
    }
}

// Configuration recommendations
echo "<h2>تنظیمات توصیه شده</h2>";
echo "<div style='background: #f0f8ff; padding: 15px; border-radius: 5px; margin: 15px 0;'>";
echo "<h3>قبل از شروع کار:</h3>";
echo "<ol>";
echo "<li>فایل <code>config/database.php</code> را ویرایش کنید و اطلاعات دیتابیس خود را وارد کنید</li>";
echo "<li>فایل <code>config/config.php</code> را ویرایش کنید و آدرس سایت خود را تنظیم کنید</li>";
echo "<li>برای امنیت بیشتر، رمز عبور پیش‌فرض مدیر را تغییر دهید</li>";
echo "<li>فایل <code>setup.php</code> را بعد از راه‌اندازی حذف کنید</li>";
echo "</ol>";
echo "</div>";

// Create htaccess for security
echo "<h2>ایجاد فایل‌های امنیتی...</h2>";
$htaccess_content = "# Security Headers
<IfModule mod_headers.c>
    Header always set X-Content-Type-Options nosniff
    Header always set X-Frame-Options DENY
    Header always set X-XSS-Protection \"1; mode=block\"
</IfModule>

# Prevent access to sensitive files
<Files \"*.sql\">
    Require all denied
</Files>

<Files \"setup.php\">
    Require all denied
</Files>

# PHP Security
<IfModule mod_php.c>
    php_flag display_errors off
    php_flag log_errors on
    php_value error_log error.log
</IfModule>

# Uploads security
<Directory \"uploads/\">
    <Files \"*.php\">
        Require all denied
    </Files>
</Directory>";

if (file_put_contents('.htaccess', $htaccess_content)) {
    echo "<p class='success'>✓ فایل .htaccess ایجاد شد</p>";
} else {
    echo "<p class='error'>✗ خطا در ایجاد فایل .htaccess</p>";
}

// Summary
echo "<h2>خلاصه راه‌اندازی</h2>";
if (empty($errors)) {
    echo "<p class='success' style='font-size: 18px; font-weight: bold;'>✓ راه‌اندازی با موفقیت تکمیل شد!</p>";
    
    // Create setup completion flag
    file_put_contents('setup_done.flag', date('Y-m-d H:i:s'));
    
    echo "<div style='background: #e8f5e8; padding: 20px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3>مراحل بعدی:</h3>";
    echo "<ul>";
    echo "<li><a href='index.php'>مشاهده سایت</a></li>";
    echo "<li><a href='login.php'>ورود به پنل مدیریت</a> (admin@gaming-store.com / admin123)</li>";
    echo "<li><a href='admin/'>مدیریت محصولات</a></li>";
    echo "</ul>";
    echo "</div>";
} else {
    echo "<p class='error' style='font-size: 18px; font-weight: bold;'>✗ راه‌اندازی با خطا مواجه شد</p>";
    echo "<ul>";
    foreach ($errors as $error) {
        echo "<li class='error'>$error</li>";
    }
    echo "</ul>";
}

echo "<hr>";
echo "<p style='text-align: center; color: #666; margin-top: 30px;'>";
echo "فروشگاه گیمینگ - " . date('Y') . " | برای پشتیبانی با ما تماس بگیرید";
echo "</p>";

echo "</body></html>";
?>