<?php
require_once 'config/config.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'لطفا وارد حساب کاربری خود شوید.']);
    exit();
}

// Verify CSRF token
$csrf_token = $_POST['csrf_token'] ?? '';
if (!verify_csrf_token($csrf_token)) {
    echo json_encode(['success' => false, 'message' => 'درخواست نامعتبر است.']);
    exit();
}

$action = sanitize_input($_POST['action'] ?? '');
$product_id = (int)($_POST['product_id'] ?? 0);
$quantity = (int)($_POST['quantity'] ?? 1);
$user_id = $_SESSION['user_id'];

if (!$product_id) {
    echo json_encode(['success' => false, 'message' => 'محصول نامعتبر است.']);
    exit();
}

try {
    switch ($action) {
        case 'add':
            // Check if product exists and is active
            $stmt = $pdo->prepare("SELECT id, name, stock_quantity FROM products WHERE id = ? AND is_active = 1");
            $stmt->execute([$product_id]);
            $product = $stmt->fetch();
            
            if (!$product) {
                echo json_encode(['success' => false, 'message' => 'محصول یافت نشد.']);
                exit();
            }
            
            if ($product['stock_quantity'] < $quantity) {
                echo json_encode(['success' => false, 'message' => 'موجودی کافی نیست.']);
                exit();
            }
            
            // Check if item already exists in cart
            $stmt = $pdo->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
            $stmt->execute([$user_id, $product_id]);
            $existing = $stmt->fetch();
            
            if ($existing) {
                // Update quantity
                $new_quantity = $existing['quantity'] + $quantity;
                if ($new_quantity > $product['stock_quantity']) {
                    echo json_encode(['success' => false, 'message' => 'موجودی کافی نیست.']);
                    exit();
                }
                
                $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
                $stmt->execute([$new_quantity, $user_id, $product_id]);
            } else {
                // Insert new item
                $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
                $stmt->execute([$user_id, $product_id, $quantity]);
            }
            
            break;
            
        case 'update':
            if ($quantity < 1) {
                echo json_encode(['success' => false, 'message' => 'تعداد نامعتبر است.']);
                exit();
            }
            
            // Check product stock
            $stmt = $pdo->prepare("SELECT stock_quantity FROM products WHERE id = ? AND is_active = 1");
            $stmt->execute([$product_id]);
            $product = $stmt->fetch();
            
            if (!$product || $product['stock_quantity'] < $quantity) {
                echo json_encode(['success' => false, 'message' => 'موجودی کافی نیست.']);
                exit();
            }
            
            $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
            $stmt->execute([$quantity, $user_id, $product_id]);
            
            break;
            
        case 'remove':
            $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
            $stmt->execute([$user_id, $product_id]);
            
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'عملیات نامعتبر است.']);
            exit();
    }
    
    // Get updated cart count
    $stmt = $pdo->prepare("SELECT SUM(quantity) as total FROM cart WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $cart_result = $stmt->fetch();
    $cart_count = $cart_result['total'] ?? 0;
    
    // Update session
    $_SESSION['cart_count'] = $cart_count;
    
    echo json_encode(['success' => true, 'cart_count' => $cart_count]);
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'خطا در پردازش درخواست.']);
}
?>