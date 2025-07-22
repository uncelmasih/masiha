<?php
require_once 'config/config.php';

$category_id = (int)($_GET['id'] ?? 0);

if (!$category_id) {
    header('Location: products.php');
    exit();
}

// Get category details
try {
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ? AND is_active = 1");
    $stmt->execute([$category_id]);
    $category = $stmt->fetch();
    
    if (!$category) {
        header('Location: products.php');
        exit();
    }
} catch (PDOException $e) {
    header('Location: products.php');
    exit();
}

// Redirect to products page with category filter
$redirect_url = 'products.php?category=' . $category_id;

// Preserve other parameters
$allowed_params = ['search', 'sort', 'min_price', 'max_price', 'page'];
foreach ($allowed_params as $param) {
    if (isset($_GET[$param]) && !empty($_GET[$param])) {
        $redirect_url .= '&' . $param . '=' . urlencode($_GET[$param]);
    }
}

header('Location: ' . $redirect_url);
exit();
?>