<?php
require_once 'inc/db.php';
require_once 'inc/header.php';

$stmt = $pdo->query('SELECT * FROM products ORDER BY id DESC');
$products = $stmt->fetchAll();
?>
<h2>محصولات گیمینگ</h2>
<?php if (count($products) == 0): ?>
    <p>هنوز محصولی ثبت نشده است.</p>
<?php endif; ?>
<?php foreach ($products as $product): ?>
    <div class="product">
        <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>">
        <div class="product-details">
            <h3><?php echo htmlspecialchars($product['title']); ?></h3>
            <p><?php echo htmlspecialchars($product['description']); ?></p>
            <strong><?php echo number_format($product['price']); ?> تومان</strong>
            <form action="cart.php" method="post" style="display:inline;">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <button class="button" type="submit">افزودن به سبد خرید</button>
            </form>
        </div>
    </div>
<?php endforeach; ?>
<?php require_once 'inc/footer.php'; ?>