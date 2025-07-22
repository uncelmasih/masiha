<?php
require_once 'config/config.php';

$search_query = sanitize_input($_GET['q'] ?? '');
$page_title = 'جستجو';

if ($search_query) {
    $page_title .= ': ' . $search_query;
}

// Redirect to products page with search parameter
$redirect_url = 'products.php';
if ($search_query) {
    $redirect_url .= '?search=' . urlencode($search_query);
}

header('Location: ' . $redirect_url);
exit();
?>