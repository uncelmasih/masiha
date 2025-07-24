<?php
// Safe Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'bngshopi_bng_shop');
define('DB_USER', 'bngshopi_masiha1380');
define('DB_PASS', 'masihabadboy');
define('DB_CHARSET', 'utf8mb4');

// Initialize PDO as null
$pdo = null;

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    // Log error instead of dying
    error_log("Database connection error: " . $e->getMessage());
    
    // Don't die, just set pdo to null
    $pdo = null;
    
    // Optional: show user-friendly message in development
    if (isset($_GET['debug'])) {
        echo "Database connection error: " . $e->getMessage();
        exit;
    }
}
?>