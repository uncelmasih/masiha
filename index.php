<?php
require_once 'config/config.php';

$page_title = 'خانه';

// Get featured products
try {
    $stmt = $pdo->prepare("SELECT p.*, c.name as category_name FROM products p 
                          LEFT JOIN categories c ON p.category_id = c.id 
                          WHERE p.is_featured = 1 AND p.is_active = 1 
                          ORDER BY p.created_at DESC LIMIT 8");
    $stmt->execute();
    $featured_products = $stmt->fetchAll();
} catch (PDOException $e) {
    $featured_products = [];
}

// Get categories
try {
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE is_active = 1 ORDER BY name LIMIT 6");
    $stmt->execute();
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    $categories = [];
}

// Update cart count in session
if (isset($_SESSION['user_id'])) {
    try {
        $stmt = $pdo->prepare("SELECT SUM(quantity) as total FROM cart WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $cart_result = $stmt->fetch();
        $_SESSION['cart_count'] = $cart_result['total'] ?? 0;
    } catch (PDOException $e) {
        $_SESSION['cart_count'] = 0;
    }
}

require_once 'includes/header.php';
?>

<div class="container">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h2>گیفت کارت و محصولات دیجیتالی</h2>
            <p>خرید سریع و امن گیفت کارت، اکانت پریمیوم و کلیدهای بازی</p>
            <a href="products.php" class="btn">مشاهده محصولات</a>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="section">
        <div class="section-title">
            <h2>دسته‌بندی محصولات</h2>
            <p>انواع گیفت کارت و محصولات دیجیتالی</p>
        </div>
        
        <div class="categories-grid">
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <a href="category.php?id=<?php echo $category['id']; ?>" class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-gift"></i>
                        </div>
                        <div class="category-name"><?php echo htmlspecialchars($category['name']); ?></div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">هنوز دسته‌بندی تعریف نشده است.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="section">
        <div class="section-title">
            <h2>محصولات پرفروش</h2>
            <p>پرطرفدارترین گیفت کارت‌ها و محصولات دیجیتالی</p>
        </div>
        
        <div class="products-grid">
            <?php if (!empty($featured_products)): ?>
                <?php foreach ($featured_products as $product): ?>
                    <div class="product-card">
                        <div class="product-image">
                            <?php if ($product['main_image']): ?>
                                <img src="uploads/products/<?php echo htmlspecialchars($product['main_image']); ?>" 
                                     alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <?php else: ?>
                                <i class="fas fa-image" style="font-size: 64px; color: #ddd;"></i>
                            <?php endif; ?>
                            
                            <?php if ($product['discount_price']): ?>
                                <div class="product-badge">
                                    <?php echo round((($product['price'] - $product['discount_price']) / $product['price']) * 100); ?>% تخفیف
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="product-info">
                            <h3 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p class="product-description">
                                <?php echo htmlspecialchars(substr($product['description'], 0, 100)) . (strlen($product['description']) > 100 ? '...' : ''); ?>
                            </p>
                            
                            <div class="product-price">
                                <div>
                                    <span class="price">
                                        <?php echo number_format($product['discount_price'] ?: $product['price']); ?> تومان
                                    </span>
                                    <?php if ($product['discount_price']): ?>
                                        <span class="old-price"><?php echo number_format($product['price']); ?> تومان</span>
                                    <?php endif; ?>
                                </div>
                                <small class="text-muted"><?php echo htmlspecialchars($product['category_name']); ?></small>
                            </div>
                            
                            <div class="product-actions">
                                <?php if ($product['stock_quantity'] > 0): ?>
                                    <button class="add-to-cart" onclick="addToCart(<?php echo $product['id']; ?>)">
                                        <i class="fas fa-cart-plus"></i> افزودن به سبد
                                    </button>
                                <?php else: ?>
                                    <button class="add-to-cart" disabled style="background: #ccc;">
                                        <i class="fas fa-times"></i> ناموجود
                                    </button>
                                <?php endif; ?>
                                <a href="product.php?id=<?php echo $product['id']; ?>" class="view-product">
                                    <i class="fas fa-eye"></i> مشاهده
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">هنوز محصولی تعریف نشده است.</p>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-20">
            <a href="products.php" class="btn btn-primary">مشاهده همه محصولات</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="section">
        <div class="section-title">
            <h2>چرا ما را انتخاب کنید؟</h2>
        </div>
        
        <div class="categories-grid">
            <div class="category-card">
                <div class="category-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <div class="category-name">تحویل فوری</div>
                <p style="margin-top: 10px; color: #666;">دریافت کد یا اکانت در کمتر از 5 دقیقه</p>
            </div>
            
            <div class="category-card">
                <div class="category-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="category-name">اورجینال 100%</div>
                <p style="margin-top: 10px; color: #666;">تمامی محصولات اورجینال و معتبر</p>
            </div>
            
            <div class="category-card">
                <div class="category-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <div class="category-name">پشتیبانی 24/7</div>
                <p style="margin-top: 10px; color: #666;">پشتیبانی آنلاین در تمام ساعات</p>
            </div>
            
            <div class="category-card">
                <div class="category-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="category-name">قیمت مناسب</div>
                <p style="margin-top: 10px; color: #666;">بهترین قیمت در بازار</p>
            </div>
        </div>
    </section>
</div>

<?php require_once 'includes/footer.php'; ?>