<?php
require_once 'config/config.php';

// Clear all session data
session_unset();
session_destroy();

// Start new session for flash message
session_start();
$_SESSION['logout_message'] = 'با موفقیت خارج شدید.';

// Redirect to home page
header('Location: index.php');
exit();
?>