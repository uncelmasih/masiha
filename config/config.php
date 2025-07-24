<?php
session_start();

// Include database connection
require_once 'database.php';

// Site Configuration
define('SITE_NAME', 'BNG Shop');
define('SITE_URL', 'https://bngshop.ir');
define('SITE_EMAIL', 'bngshop@gmail.com');
define('ADMIN_EMAIL', 'masiha1380@bngshop.ir');
define('SITE_PHONE', '09352233616');
define('SITE_ADDRESS', 'تهران، خیابان ولیعصر');

// Business Hours
define('BUSINESS_HOURS', 'شنبه تا پنج‌شنبه: 10 صبح تا 11 شب');
define('DELIVERY_TIME', '1 تا 8 ساعت کاری');

// Payment Gateway
define('ZARINPAL_MERCHANT', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'); // ZarinPal Merchant ID
define('ZARINPAL_GATEWAY', 'https://payment.zarinpal.com/pg/StartPay/');
define('ZARINPAL_SANDBOX', false); // Set to true for testing

// Security
define('CSRF_TOKEN_NAME', 'csrf_token');
define('UPLOAD_PATH', 'uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB

// Email Configuration
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', ADMIN_EMAIL);
define('SMTP_PASSWORD', ''); // Add your email password here

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Helper Functions
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function redirect($url) {
    header("Location: " . $url);
    exit();
}

function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function formatPrice($price) {
    return number_format($price) . ' تومان';
}

function jalaliDate($timestamp = null) {
    if ($timestamp === null) {
        $timestamp = time();
    }
    // Simple Jalali date conversion (you can use a more advanced library)
    return date('Y/m/d H:i', $timestamp);
}

// Auto-generate CSRF token
generateCSRFToken();
?>