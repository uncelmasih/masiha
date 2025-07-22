<?php
require_once 'config/config.php';

$product_id = (int)($_GET['id'] ?? 0);

if (!$product_id) {
    header('Location: products.php');
    exit();
}

// Get product details
try {
    $stmt = $pdo->prepare("
        SELECT p.*, c.name as category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        WHERE p.id = ? AND p.is_active = 1
    ");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();
    
    if (!$product) {
        header('Location: products.php');
        exit();
    }
    
    // Update views
    $stmt = $pdo->prepare("UPDATE products SET views = views + 1 WHERE id = ?");
    $stmt->execute([$product_id]);
    
} catch (PDOException $e) {
    header('Location: products.php');
    exit();
}

// Get related products
try {
    $stmt = $pdo->prepare("
        SELECT p.*, c.name as category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        WHERE p.category_id = ? AND p.id != ? AND p.is_active = 1 
        ORDER BY RAND() 
        LIMIT 4
    ");
    $stmt->execute([$product['category_id'], $product_id]);
    $related_products = $stmt->fetchAll();
} catch (PDOException $e) {
    $related_products = [];
}

$page_title = $product['name'];
$specifications = $product['specifications'] ? json_decode($product['specifications'], true) : [];

require_once 'includes/header.php';
?>

<div class="container">
    <nav style="margin: 20px 0; font-size: 14px; color: #666;">
        <a href="index.php">خانه</a> / 
        <a href="products.php">محصولات</a> / 
        <?php if ($product['category_name']): ?>
            <a href="category.php?id=<?php echo $product['category_id']; ?>"><?php echo htmlspecialchars($product['category_name']); ?></a> / 
        <?php endif; ?>
        <span><?php echo htmlspecialchars($product['name']); ?></span>
    </nav>

    <div style="background: #fff; border-radius: 15px; padding: 30px; box-shadow: 0 5px 25px rgba(0,0,0,0.1); margin-bottom: 40px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 40px;">
            
            <!-- Product Images -->
            <div>
                <div class="main-image" style="width: 100%; height: 400px; border-radius: 10px; overflow: hidden; margin-bottom: 20px; background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                    <?php if ($product['main_image']): ?>
                        <img src="uploads/products/<?php echo htmlspecialchars($product['main_image']); ?>" 
                             alt="<?php echo htmlspecialchars($product['name']); ?>"
                             style="width: 100%; height: 100%; object-fit: cover;">
                    <?php else: ?>
                        <i class="fas fa-image" style="font-size: 64px; color: #ddd;"></i>
                    <?php endif; ?>
                </div>
                
                <?php if ($product['gallery']): ?>
                    <?php $gallery = json_decode($product['gallery'], true); ?>
                    <?php if ($gallery && is_array($gallery)): ?>
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;">
                            <?php foreach (array_slice($gallery, 0, 4) as $image): ?>
                                <div style="width: 100%; height: 80px; border-radius: 5px; overflow: hidden; cursor: pointer;">
                                    <img src="uploads/products/<?php echo htmlspecialchars($image); ?>" 
                                         alt="تصویر محصول" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            
            <!-- Product Info -->
            <div>
                <h1 style="font-size: 28px; margin-bottom: 15px; color: #333;"><?php echo htmlspecialchars($product['name']); ?></h1>
                
                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                    <span style="background: #e3f2fd; color: #1976d2; padding: 5px 10px; border-radius: 15px; font-size: 14px;">
                        <?php echo htmlspecialchars($product['category_name']); ?>
                    </span>
                    
                    <?php if ($product['brand']): ?>
                        <span style="background: #f3e5f5; color: #7b1fa2; padding: 5px 10px; border-radius: 15px; font-size: 14px;">
                            برند: <?php echo htmlspecialchars($product['brand']); ?>
                        </span>
                    <?php endif; ?>
                    
                    <span style="color: #666; font-size: 14px;">
                        <i class="fas fa-eye"></i> <?php echo number_format($product['views']); ?> بازدید
                    </span>
                </div>
                
                <div style="margin-bottom: 25px;">
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 10px;">
                        <span style="font-size: 28px; font-weight: 700; color: #667eea;">
                            <?php echo number_format($product['discount_price'] ?: $product['price']); ?> تومان
                        </span>
                        
                        <?php if ($product['discount_price']): ?>
                            <span style="text-decoration: line-through; color: #999; font-size: 20px;">
                                <?php echo number_format($product['price']); ?> تومان
                            </span>
                            <span style="background: #ff6b6b; color: #fff; padding: 5px 10px; border-radius: 15px; font-size: 14px;">
                                <?php echo round((($product['price'] - $product['discount_price']) / $product['price']) * 100); ?>% تخفیف
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <div style="color: #666; font-size: 14px;">
                        <?php if ($product['stock_quantity'] > 0): ?>
                            <i class="fas fa-check-circle" style="color: #51cf66;"></i> 
                            <?php echo number_format($product['stock_quantity']); ?> عدد موجود در انبار
                        <?php else: ?>
                            <i class="fas fa-times-circle" style="color: #ff6b6b;"></i> ناموجود
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Add to Cart -->
                <div style="margin-bottom: 30px;">
                    <?php if ($product['stock_quantity'] > 0): ?>
                        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                            <label style="font-weight: 500;">تعداد:</label>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <button onclick="changeQuantity(-1)" style="background: #f8f9fa; border: 1px solid #dee2e6; width: 35px; height: 35px; border-radius: 5px; cursor: pointer;">-</button>
                                <input type="number" id="quantity" value="1" min="1" max="<?php echo $product['stock_quantity']; ?>" 
                                       style="width: 80px; text-align: center; border: 1px solid #dee2e6; border-radius: 5px; padding: 8px;">
                                <button onclick="changeQuantity(1)" style="background: #f8f9fa; border: 1px solid #dee2e6; width: 35px; height: 35px; border-radius: 5px; cursor: pointer;">+</button>
                            </div>
                        </div>
                        
                        <button onclick="addToCartWithQuantity()" class="btn btn-primary" style="width: 100%; padding: 15px; font-size: 18px; margin-bottom: 10px;">
                            <i class="fas fa-cart-plus"></i> افزودن به سبد خرید
                        </button>
                    <?php else: ?>
                        <button class="btn" disabled style="width: 100%; padding: 15px; font-size: 18px; background: #ccc; color: #666;">
                            <i class="fas fa-times"></i> ناموجود
                        </button>
                    <?php endif; ?>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 15px;">
                        <button class="btn" style="background: #f8f9fa; color: #333;">
                            <i class="fas fa-heart"></i> افزودن به علاقه‌مندی‌ها
                        </button>
                        <button class="btn" style="background: #f8f9fa; color: #333;">
                            <i class="fas fa-share"></i> اشتراک گذاری
                        </button>
                    </div>
                </div>
                
                <!-- Features -->
                <div style="background: #f8f9fa; padding: 20px; border-radius: 10px;">
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-shipping-fast" style="color: #667eea;"></i>
                            <span style="font-size: 14px;">ارسال سریع</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-shield-alt" style="color: #51cf66;"></i>
                            <span style="font-size: 14px;">گارانتی معتبر</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-undo" style="color: #ff8800;"></i>
                            <span style="font-size: 14px;">7 روز ضمانت بازگشت</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-headset" style="color: #e91e63;"></i>
                            <span style="font-size: 14px;">پشتیبانی 24/7</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Product Tabs -->
        <div class="product-tabs">
            <div style="border-bottom: 1px solid #eee; margin-bottom: 20px;">
                <nav style="display: flex; gap: 30px;">
                    <button class="tab-button active" onclick="showTab('description')" style="background: none; border: none; padding: 15px 0; border-bottom: 2px solid #667eea; color: #667eea; font-weight: 500; cursor: pointer;">توضیحات</button>
                    <?php if ($specifications): ?>
                        <button class="tab-button" onclick="showTab('specifications')" style="background: none; border: none; padding: 15px 0; border-bottom: 2px solid transparent; color: #666; font-weight: 500; cursor: pointer;">مشخصات</button>
                    <?php endif; ?>
                    <button class="tab-button" onclick="showTab('reviews')" style="background: none; border: none; padding: 15px 0; border-bottom: 2px solid transparent; color: #666; font-weight: 500; cursor: pointer;">نظرات</button>
                </nav>
            </div>
            
            <div id="description" class="tab-content">
                <div style="line-height: 1.8; color: #333;">
                    <?php echo nl2br(htmlspecialchars($product['description'])); ?>
                </div>
            </div>
            
            <?php if ($specifications): ?>
                <div id="specifications" class="tab-content" style="display: none;">
                    <div class="table-responsive">
                        <table class="table">
                            <?php foreach ($specifications as $key => $value): ?>
                                <tr>
                                    <td style="font-weight: 500; width: 200px;"><?php echo htmlspecialchars($key); ?></td>
                                    <td><?php echo htmlspecialchars($value); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
            
            <div id="reviews" class="tab-content" style="display: none;">
                <p style="text-align: center; color: #666; padding: 40px;">
                    سیستم نظرات به زودی راه‌اندازی خواهد شد.
                </p>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    <?php if (!empty($related_products)): ?>
        <section class="section">
            <div class="section-title">
                <h2>محصولات مشابه</h2>
            </div>
            
            <div class="products-grid">
                <?php foreach ($related_products as $related): ?>
                    <div class="product-card">
                        <div class="product-image">
                            <?php if ($related['main_image']): ?>
                                <img src="uploads/products/<?php echo htmlspecialchars($related['main_image']); ?>" 
                                     alt="<?php echo htmlspecialchars($related['name']); ?>">
                            <?php else: ?>
                                <i class="fas fa-image" style="font-size: 64px; color: #ddd;"></i>
                            <?php endif; ?>
                            
                            <?php if ($related['discount_price']): ?>
                                <div class="product-badge">
                                    <?php echo round((($related['price'] - $related['discount_price']) / $related['price']) * 100); ?>% تخفیف
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="product-info">
                            <h3 class="product-title"><?php echo htmlspecialchars($related['name']); ?></h3>
                            
                            <div class="product-price">
                                <span class="price">
                                    <?php echo number_format($related['discount_price'] ?: $related['price']); ?> تومان
                                </span>
                                <?php if ($related['discount_price']): ?>
                                    <span class="old-price"><?php echo number_format($related['price']); ?> تومان</span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="product-actions">
                                <?php if ($related['stock_quantity'] > 0): ?>
                                    <button class="add-to-cart" onclick="addToCart(<?php echo $related['id']; ?>)">
                                        <i class="fas fa-cart-plus"></i> افزودن به سبد
                                    </button>
                                <?php else: ?>
                                    <button class="add-to-cart" disabled style="background: #ccc;">
                                        <i class="fas fa-times"></i> ناموجود
                                    </button>
                                <?php endif; ?>
                                <a href="product.php?id=<?php echo $related['id']; ?>" class="view-product">
                                    <i class="fas fa-eye"></i> مشاهده
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
</div>

<script>
function changeQuantity(change) {
    const input = document.getElementById('quantity');
    const newValue = parseInt(input.value) + change;
    const max = parseInt(input.max);
    
    if (newValue >= 1 && newValue <= max) {
        input.value = newValue;
    }
}

function addToCartWithQuantity() {
    const quantity = parseInt(document.getElementById('quantity').value);
    addToCart(<?php echo $product_id; ?>, quantity);
}

function showTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.style.display = 'none';
    });
    
    // Remove active class from all buttons
    document.querySelectorAll('.tab-button').forEach(btn => {
        btn.style.borderBottomColor = 'transparent';
        btn.style.color = '#666';
        btn.classList.remove('active');
    });
    
    // Show selected tab
    document.getElementById(tabName).style.display = 'block';
    
    // Add active class to clicked button
    event.target.style.borderBottomColor = '#667eea';
    event.target.style.color = '#667eea';
    event.target.classList.add('active');
}
</script>

<style>
@media (max-width: 768px) {
    .container > div[style*="grid-template-columns"] {
        display: block !important;
    }
    
    .main-image {
        height: 300px !important;
    }
    
    .product-tabs nav {
        flex-wrap: wrap;
        gap: 15px !important;
    }
}
</style>

<?php require_once 'includes/footer.php'; ?>