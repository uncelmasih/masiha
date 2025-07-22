<?php
require_once 'config/config.php';

$page_title = 'سبد خرید';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?redirect=cart.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Get cart items
try {
    $stmt = $pdo->prepare("
        SELECT c.*, p.name, p.price, p.discount_price, p.main_image, p.stock_quantity,
               COALESCE(p.discount_price, p.price) as final_price
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ? AND p.is_active = 1
        ORDER BY c.created_at DESC
    ");
    $stmt->execute([$user_id]);
    $cart_items = $stmt->fetchAll();
} catch (PDOException $e) {
    $cart_items = [];
}

// Calculate totals
$subtotal = 0;
$total_quantity = 0;
foreach ($cart_items as $item) {
    $subtotal += $item['final_price'] * $item['quantity'];
    $total_quantity += $item['quantity'];
}

$shipping_cost = $subtotal >= 2000000 ? 0 : 50000; // Free shipping over 2M
$total = $subtotal + $shipping_cost;

require_once 'includes/header.php';
?>

<div class="container">
    <div class="section-title">
        <h2>سبد خرید</h2>
        <p><?php echo number_format($total_quantity); ?> کالا در سبد خرید شما</p>
    </div>

    <?php if (!empty($cart_items)): ?>
        <div style="display: grid; grid-template-columns: 1fr 350px; gap: 30px; margin-top: 30px;">
            
            <!-- Cart Items -->
            <div>
                <?php foreach ($cart_items as $item): ?>
                    <div class="cart-item" style="background: #fff; border-radius: 10px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 20px;">
                        
                        <div class="item-image" style="width: 100px; height: 100px; border-radius: 8px; overflow: hidden; flex-shrink: 0;">
                            <?php if ($item['main_image']): ?>
                                <img src="uploads/products/<?php echo htmlspecialchars($item['main_image']); ?>" 
                                     alt="<?php echo htmlspecialchars($item['name']); ?>"
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            <?php else: ?>
                                <div style="width: 100%; height: 100%; background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-image" style="font-size: 24px; color: #ddd;"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="item-info" style="flex: 1;">
                            <h3 style="margin-bottom: 10px; font-size: 18px;">
                                <a href="product.php?id=<?php echo $item['product_id']; ?>" style="color: #333; text-decoration: none;">
                                    <?php echo htmlspecialchars($item['name']); ?>
                                </a>
                            </h3>
                            
                            <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 15px;">
                                <div class="price">
                                    <span style="font-size: 18px; font-weight: 600; color: #667eea;">
                                        <?php echo number_format($item['final_price']); ?> تومان
                                    </span>
                                    <?php if ($item['discount_price']): ?>
                                        <span style="text-decoration: line-through; color: #999; margin-right: 10px;">
                                            <?php echo number_format($item['price']); ?> تومان
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if ($item['quantity'] > $item['stock_quantity']): ?>
                                    <span style="color: #ff6b6b; font-size: 14px;">
                                        <i class="fas fa-exclamation-triangle"></i> موجودی کافی نیست
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div class="quantity-controls" style="display: flex; align-items: center; gap: 10px;">
                                    <label style="font-weight: 500;">تعداد:</label>
                                    <button onclick="updateCartQuantity(<?php echo $item['product_id']; ?>, <?php echo $item['quantity'] - 1; ?>)" 
                                            style="background: #f8f9fa; border: 1px solid #dee2e6; width: 30px; height: 30px; border-radius: 5px; cursor: pointer;">-</button>
                                    <input type="number" value="<?php echo $item['quantity']; ?>" min="1" max="<?php echo $item['stock_quantity']; ?>"
                                           style="width: 60px; text-align: center; border: 1px solid #dee2e6; border-radius: 5px; padding: 5px;"
                                           onchange="updateCartQuantity(<?php echo $item['product_id']; ?>, this.value)">
                                    <button onclick="updateCartQuantity(<?php echo $item['product_id']; ?>, <?php echo $item['quantity'] + 1; ?>)"
                                            style="background: #f8f9fa; border: 1px solid #dee2e6; width: 30px; height: 30px; border-radius: 5px; cursor: pointer;">+</button>
                                </div>
                                
                                <button onclick="removeFromCart(<?php echo $item['product_id']; ?>)" 
                                        style="background: #ff6b6b; color: #fff; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer;">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </div>
                        </div>
                        
                        <div class="item-total" style="text-align: center; min-width: 120px;">
                            <div style="font-size: 18px; font-weight: 600; color: #333;">
                                <?php echo number_format($item['final_price'] * $item['quantity']); ?> تومان
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Order Summary -->
            <div style="background: #fff; border-radius: 10px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); height: fit-content; position: sticky; top: 100px;">
                <h3 style="margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f8f9fa;">خلاصه سفارش</h3>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span>جمع کالاها (<?php echo number_format($total_quantity); ?> کالا):</span>
                    <span><?php echo number_format($subtotal); ?> تومان</span>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                    <span>هزینه ارسال:</span>
                    <span><?php echo $shipping_cost ? number_format($shipping_cost) . ' تومان' : 'رایگان'; ?></span>
                </div>
                
                <?php if ($shipping_cost > 0): ?>
                    <div style="background: #e3f2fd; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 14px; text-align: center;">
                        برای ارسال رایگان <?php echo number_format(2000000 - $subtotal); ?> تومان کالای بیشتر خریداری کنید
                    </div>
                <?php endif; ?>
                
                <div style="display: flex; justify-content: space-between; font-size: 18px; font-weight: 600; padding: 15px 0; border-top: 2px solid #f8f9fa; margin-bottom: 20px;">
                    <span>قابل پرداخت:</span>
                    <span style="color: #667eea;"><?php echo number_format($total); ?> تومان</span>
                </div>
                
                <a href="checkout.php" class="btn btn-primary" style="width: 100%; display: block; text-align: center; margin-bottom: 10px;">
                    <i class="fas fa-credit-card"></i> ادامه خرید
                </a>
                
                <a href="products.php" class="btn" style="width: 100%; display: block; text-align: center; background: #f8f9fa; color: #333;">
                    <i class="fas fa-arrow-right"></i> ادامه خرید
                </a>
            </div>
            
        </div>
        
    <?php else: ?>
        <div style="text-align: center; padding: 50px; background: #fff; border-radius: 10px; margin-top: 30px;">
            <i class="fas fa-shopping-cart" style="font-size: 64px; color: #ddd; margin-bottom: 20px;"></i>
            <h3>سبد خرید شما خالی است</h3>
            <p style="margin: 20px 0;">هنوز محصولی به سبد خرید اضافه نکرده‌اید.</p>
            <a href="products.php" class="btn btn-primary">
                <i class="fas fa-shopping-bag"></i> شروع خرید
            </a>
        </div>
    <?php endif; ?>
</div>

<style>
@media (max-width: 768px) {
    .container > div[style*="grid-template-columns"] {
        display: block !important;
    }
    
    .cart-item {
        flex-direction: column !important;
        text-align: center !important;
    }
    
    .cart-item .item-info {
        order: 2;
    }
    
    .cart-item .item-total {
        order: 3;
        margin-top: 15px;
    }
    
    .quantity-controls {
        justify-content: center !important;
        margin-bottom: 15px;
    }
}
</style>

<?php require_once 'includes/footer.php'; ?>