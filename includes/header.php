<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?><?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link href="https://fonts.googleapis.com/css2?family=Vazir:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="main-header">
        <div class="container">
            <div class="header-top">
                <div class="contact-info">
                    <span><i class="fas fa-phone"></i> 021-12345678</span>
                    <span><i class="fas fa-envelope"></i> info@gaming-store.com</span>
                </div>
                <div class="user-actions">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="account.php"><i class="fas fa-user"></i> حساب کاربری</a>
                        <?php if ($_SESSION['role'] == 'admin'): ?>
                            <a href="admin/"><i class="fas fa-cog"></i> پنل مدیریت</a>
                        <?php endif; ?>
                        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> خروج</a>
                    <?php else: ?>
                        <a href="login.php"><i class="fas fa-sign-in-alt"></i> ورود</a>
                        <a href="register.php"><i class="fas fa-user-plus"></i> ثبت نام</a>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="header-main">
                <div class="logo">
                    <a href="index.php">
                        <h1><?php echo SITE_NAME; ?></h1>
                    </a>
                </div>
                
                <div class="search-box">
                    <form action="search.php" method="GET">
                        <input type="text" name="q" placeholder="جستجو در محصولات..." value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                
                <div class="cart-info">
                    <a href="cart.php" class="cart-link">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count"><?php echo isset($_SESSION['cart_count']) ? $_SESSION['cart_count'] : 0; ?></span>
                        <span>سبد خرید</span>
                    </a>
                </div>
            </div>
            
            <nav class="main-nav">
                <ul>
                    <li><a href="index.php"><i class="fas fa-home"></i> خانه</a></li>
                    <li class="dropdown">
                        <a href="products.php"><i class="fas fa-gamepad"></i> محصولات <i class="fas fa-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <?php
                            try {
                                $stmt = $pdo->query("SELECT * FROM categories WHERE is_active = 1 ORDER BY name");
                                while ($category = $stmt->fetch()) {
                                    echo '<li><a href="category.php?id=' . $category['id'] . '">' . htmlspecialchars($category['name']) . '</a></li>';
                                }
                            } catch (PDOException $e) {
                                // Handle error silently
                            }
                            ?>
                        </ul>
                    </li>
                    <li><a href="brands.php"><i class="fas fa-tags"></i> برندها</a></li>
                    <li><a href="offers.php"><i class="fas fa-fire"></i> تخفیف ها</a></li>
                    <li><a href="about.php"><i class="fas fa-info-circle"></i> درباره ما</a></li>
                    <li><a href="contact.php"><i class="fas fa-phone"></i> تماس با ما</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main-content">