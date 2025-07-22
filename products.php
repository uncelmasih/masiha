<?php
require_once 'config/config.php';

$page_title = 'محصولات';

// Pagination settings
$per_page = 12;
$page = (int)($_GET['page'] ?? 1);
$offset = ($page - 1) * $per_page;

// Filter parameters
$category_id = (int)($_GET['category'] ?? 0);
$search = sanitize_input($_GET['search'] ?? '');
$sort = sanitize_input($_GET['sort'] ?? 'newest');
$min_price = (int)($_GET['min_price'] ?? 0);
$max_price = (int)($_GET['max_price'] ?? 0);

// Build query
$where_conditions = ['p.is_active = 1'];
$params = [];

if ($category_id) {
    $where_conditions[] = 'p.category_id = ?';
    $params[] = $category_id;
}

if ($search) {
    $where_conditions[] = '(p.name LIKE ? OR p.description LIKE ? OR p.brand LIKE ?)';
    $search_term = '%' . $search . '%';
    $params[] = $search_term;
    $params[] = $search_term;
    $params[] = $search_term;
}

if ($min_price) {
    $where_conditions[] = 'COALESCE(p.discount_price, p.price) >= ?';
    $params[] = $min_price;
}

if ($max_price) {
    $where_conditions[] = 'COALESCE(p.discount_price, p.price) <= ?';
    $params[] = $max_price;
}

$where_clause = 'WHERE ' . implode(' AND ', $where_conditions);

// Sort options
$sort_options = [
    'newest' => 'p.created_at DESC',
    'oldest' => 'p.created_at ASC',
    'price_low' => 'COALESCE(p.discount_price, p.price) ASC',
    'price_high' => 'COALESCE(p.discount_price, p.price) DESC',
    'name' => 'p.name ASC',
    'popularity' => 'p.views DESC'
];

$order_by = $sort_options[$sort] ?? $sort_options['newest'];

try {
    // Get total count
    $count_query = "SELECT COUNT(*) as total FROM products p $where_clause";
    $stmt = $pdo->prepare($count_query);
    $stmt->execute($params);
    $total_products = $stmt->fetch()['total'];
    $total_pages = ceil($total_products / $per_page);

    // Get products
    $query = "SELECT p.*, c.name as category_name 
              FROM products p 
              LEFT JOIN categories c ON p.category_id = c.id 
              $where_clause 
              ORDER BY $order_by 
              LIMIT $per_page OFFSET $offset";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $products = $stmt->fetchAll();

    // Get categories for filter
    $stmt = $pdo->query("SELECT * FROM categories WHERE is_active = 1 ORDER BY name");
    $categories = $stmt->fetchAll();

} catch (PDOException $e) {
    $products = [];
    $categories = [];
    $total_products = 0;
    $total_pages = 0;
}

require_once 'includes/header.php';
?>

<div class="container">
    <div class="section-title">
        <h2>محصولات <?php echo $category_id ? '- ' . htmlspecialchars($categories[array_search($category_id, array_column($categories, 'id'))]['name'] ?? '') : ''; ?></h2>
        <p><?php echo number_format($total_products); ?> محصول یافت شد</p>
    </div>

    <!-- Filters -->
    <div style="background: #fff; padding: 20px; border-radius: 10px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <form method="GET" action="">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end;">
                
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="search">جستجو:</label>
                    <input type="text" id="search" name="search" class="form-control" 
                           value="<?php echo htmlspecialchars($search); ?>" placeholder="نام محصول، برند...">
                </div>
                
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="category">دسته بندی:</label>
                    <select id="category" name="category" class="form-control">
                        <option value="">همه دسته ها</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>" <?php echo $category_id == $cat['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="min_price">حداقل قیمت:</label>
                    <input type="number" id="min_price" name="min_price" class="form-control" 
                           value="<?php echo $min_price; ?>" placeholder="تومان">
                </div>
                
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="max_price">حداکثر قیمت:</label>
                    <input type="number" id="max_price" name="max_price" class="form-control" 
                           value="<?php echo $max_price; ?>" placeholder="تومان">
                </div>
                
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="sort">مرتب سازی:</label>
                    <select id="sort" name="sort" class="form-control">
                        <option value="newest" <?php echo $sort == 'newest' ? 'selected' : ''; ?>>جدیدترین</option>
                        <option value="oldest" <?php echo $sort == 'oldest' ? 'selected' : ''; ?>>قدیمی ترین</option>
                        <option value="price_low" <?php echo $sort == 'price_low' ? 'selected' : ''; ?>>ارزان ترین</option>
                        <option value="price_high" <?php echo $sort == 'price_high' ? 'selected' : ''; ?>>گران ترین</option>
                        <option value="name" <?php echo $sort == 'name' ? 'selected' : ''; ?>>نام (الفبا)</option>
                        <option value="popularity" <?php echo $sort == 'popularity' ? 'selected' : ''; ?>>محبوب ترین</option>
                    </select>
                </div>
                
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-primary">اعمال فیلتر</button>
                    <a href="products.php" class="btn" style="background: #6c757d; color: #fff;">پاک کردن</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Products Grid -->
    <?php if (!empty($products)): ?>
        <div class="products-grid">
            <?php foreach ($products as $product): ?>
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
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>">قبلی</a>
                <?php endif; ?>
                
                <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                    <?php if ($i == $page): ?>
                        <span class="current"><?php echo $i; ?></span>
                    <?php else: ?>
                        <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>"><?php echo $i; ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
                
                <?php if ($page < $total_pages): ?>
                    <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>">بعدی</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
    <?php else: ?>
        <div style="text-align: center; padding: 50px;">
            <i class="fas fa-search" style="font-size: 64px; color: #ddd; margin-bottom: 20px;"></i>
            <h3>محصولی یافت نشد</h3>
            <p>لطفا فیلترها را تغییر دهید یا جستجوی دیگری انجام دهید.</p>
            <a href="products.php" class="btn btn-primary">مشاهده همه محصولات</a>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>