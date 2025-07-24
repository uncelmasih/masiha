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
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE is_active = 1 ORDER BY sort_order LIMIT 8");
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

require_once 'includes/header_new.php';
?>

<div class="container">
    <!-- Game Slider Section -->
    <section class="game-slider-section">
        <div class="slider-container">
            <div class="game-slider">
                <div class="slide active">
                    <div class="slide-bg" style="background-image: url('https://images.unsplash.com/photo-1542751371-adc38448a05e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80')"></div>
                    <div class="slide-content">
                        <h2>Steam گیفت کارت</h2>
                        <p>بهترین قیمت برای گیفت کارت Steam</p>
                        <a href="category.php?slug=steam-gift-cards" class="slide-btn">خرید کنید</a>
                    </div>
                </div>
                
                <div class="slide">
                    <div class="slide-bg" style="background-image: url('https://images.unsplash.com/photo-1511512578047-dfb367046420?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80')"></div>
                    <div class="slide-content">
                        <h2>PUBG Mobile UC</h2>
                        <p>UC پابجی موبایل با تحویل فوری</p>
                        <a href="product.php?slug=pubg-uc-8100" class="slide-btn">خرید کنید</a>
                    </div>
                </div>
                
                <div class="slide">
                    <div class="slide-bg" style="background-image: url('https://images.unsplash.com/photo-1493711662062-fa541adb3fc8?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80')"></div>
                    <div class="slide-content">
                        <h2>PlayStation Plus</h2>
                        <p>اشتراک PS Plus با تخفیف ویژه</p>
                        <a href="category.php?slug=playstation-gift-cards" class="slide-btn">خرید کنید</a>
                    </div>
                </div>
                
                <div class="slide">
                    <div class="slide-bg" style="background-image: url('https://images.unsplash.com/photo-1550745165-9bc0b252726f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80')"></div>
                    <div class="slide-content">
                        <h2>Free Fire الماس</h2>
                        <p>الماس فری فایر با بهترین قیمت</p>
                        <a href="product.php?slug=free-fire-diamond-2200" class="slide-btn">خرید کنید</a>
                    </div>
                </div>
            </div>
            
            <div class="slider-navigation">
                <button class="nav-btn prev-btn" onclick="changeSlide(-1)"><i class="fas fa-chevron-right"></i></button>
                <button class="nav-btn next-btn" onclick="changeSlide(1)"><i class="fas fa-chevron-left"></i></button>
            </div>
            
            <div class="slider-dots">
                <span class="dot active" onclick="currentSlide(1)"></span>
                <span class="dot" onclick="currentSlide(2)"></span>
                <span class="dot" onclick="currentSlide(3)"></span>
                <span class="dot" onclick="currentSlide(4)"></span>
            </div>
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
                    <a href="category.php?slug=<?php echo $category['slug']; ?>" class="category-card">
                        <div class="category-icon">
                            <i class="<?php echo $category['icon'] ?? 'fas fa-gift'; ?>"></i>
                        </div>
                        <div class="category-name"><?php echo htmlspecialchars($category['name']); ?></div>
                        <div class="category-desc"><?php echo htmlspecialchars(substr($category['description'], 0, 50)) . '...'; ?></div>
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
                                <div class="default-product-image">
                                    <i class="fas fa-gift"></i>
                                    <span><?php echo htmlspecialchars($product['name']); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($product['discount_price']): ?>
                                <div class="product-badge">
                                    <?php echo round((($product['price'] - $product['discount_price']) / $product['price']) * 100); ?>% تخفیف
                                </div>
                            <?php endif; ?>
                            
                            <div class="product-overlay">
                                <a href="product.php?slug=<?php echo $product['slug']; ?>" class="quick-view">
                                    <i class="fas fa-eye"></i> مشاهده سریع
                                </a>
                            </div>
                        </div>
                        
                        <div class="product-info">
                            <div class="product-category"><?php echo htmlspecialchars($product['category_name']); ?></div>
                            <h3 class="product-title">
                                <a href="product.php?slug=<?php echo $product['slug']; ?>">
                                    <?php echo htmlspecialchars($product['name']); ?>
                                </a>
                            </h3>
                            <p class="product-description">
                                <?php echo htmlspecialchars($product['short_description'] ?? substr($product['description'], 0, 100)) . '...'; ?>
                            </p>
                            
                            <div class="product-price">
                                <div class="price-container">
                                    <span class="current-price">
                                        <?php echo formatPrice($product['discount_price'] ?: $product['price']); ?>
                                    </span>
                                    <?php if ($product['discount_price']): ?>
                                        <span class="old-price"><?php echo formatPrice($product['price']); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="delivery-info">
                                    <i class="fas fa-bolt"></i> تحویل فوری
                                </div>
                            </div>
                            
                            <div class="product-actions">
                                <?php if ($product['stock_quantity'] > 0): ?>
                                    <button class="add-to-cart-btn" onclick="addToCart(<?php echo $product['id']; ?>)">
                                        <i class="fas fa-cart-plus"></i> افزودن به سبد
                                    </button>
                                <?php else: ?>
                                    <button class="add-to-cart-btn out-of-stock" disabled>
                                        <i class="fas fa-times"></i> ناموجود
                                    </button>
                                <?php endif; ?>
                                <a href="product.php?slug=<?php echo $product['slug']; ?>" class="view-product-btn">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">هنوز محصولی تعریف نشده است.</p>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-30">
            <a href="products.php" class="btn btn-primary">مشاهده همه محصولات</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="section features-section">
        <div class="section-title">
            <h2>چرا BNG Shop؟</h2>
            <p>مزایای خرید از ما</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <div class="feature-content">
                    <h4>تحویل فوری</h4>
                    <p><?php echo DELIVERY_TIME; ?></p>
                </div>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="feature-content">
                    <h4>اورجینال 100%</h4>
                    <p>تمامی محصولات اورجینال و معتبر</p>
                </div>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <div class="feature-content">
                    <h4>پشتیبانی 24/7</h4>
                    <p><?php echo BUSINESS_HOURS; ?></p>
                </div>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="feature-content">
                    <h4>قیمت مناسب</h4>
                    <p>بهترین قیمت در بازار</p>
                </div>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-undo"></i>
                </div>
                <div class="feature-content">
                    <h4>بازگشت وجه</h4>
                    <p>تا زمان عدم تحویل کالا</p>
                </div>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="feature-content">
                    <h4>پرداخت امن</h4>
                    <p>درگاه پرداخت زرین‌پال</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="section stats-section">
        <div class="stats-container">
            <div class="stat-item">
                <div class="stat-number">5000+</div>
                <div class="stat-label">مشتری راضی</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">10000+</div>
                <div class="stat-label">فروش موفق</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">500+</div>
                <div class="stat-label">محصول متنوع</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">24/7</div>
                <div class="stat-label">پشتیبانی آنلاین</div>
            </div>
        </div>
    </section>
</div>

<script>
// Slider functionality
let currentSlideIndex = 0;
const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.dot');

function showSlide(index) {
    slides.forEach(slide => slide.classList.remove('active'));
    dots.forEach(dot => dot.classList.remove('active'));
    
    slides[index].classList.add('active');
    dots[index].classList.add('active');
}

function changeSlide(direction) {
    currentSlideIndex += direction;
    
    if (currentSlideIndex >= slides.length) {
        currentSlideIndex = 0;
    } else if (currentSlideIndex < 0) {
        currentSlideIndex = slides.length - 1;
    }
    
    showSlide(currentSlideIndex);
}

function currentSlide(index) {
    currentSlideIndex = index - 1;
    showSlide(currentSlideIndex);
}

// Auto slide
setInterval(() => {
    changeSlide(1);
}, 5000);

// Add to cart function
function addToCart(productId) {
    fetch('cart-handler.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=add&product_id=${productId}&quantity=1&csrf_token=<?php echo $_SESSION['csrf_token']; ?>`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart count
            document.querySelector('.cart-count').textContent = data.cart_count;
            
            // Show success message
            showNotification('محصول به سبد خرید اضافه شد!', 'success');
        } else {
            showNotification(data.message || 'خطا در افزودن به سبد خرید', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('خطا در اتصال به سرور', 'error');
    });
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);
    
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}
</script>

<?php require_once 'includes/footer_new.php'; ?>