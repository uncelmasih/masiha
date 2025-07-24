<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?><?php echo SITE_NAME; ?></title>
    <meta name="description" content="BNG Shop - فروشگاه آنلاین گیفت کارت، پرداخت درون برنامه‌ای و محصولات دیجیتالی">
    <meta name="keywords" content="گیفت کارت, steam, google play, pubg uc, free fire, playstation, xbox">
    
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link href="https://fonts.googleapis.com/css2?family=Vazir:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?php echo SITE_NAME; ?> - فروشگاه گیفت کارت و محصولات دیجیتالی">
    <meta property="og:description" content="خرید گیفت کارت Steam، Google Play، پرداخت درون برنامه‌ای و محصولات دیجیتال">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo SITE_URL; ?>">
    <meta property="og:site_name" content="<?php echo SITE_NAME; ?>">
</head>
<body>
    <!-- Notification Container -->
    <div id="notification-container"></div>

    <header class="main-header">
        <div class="container">
            <!-- Header Top -->
            <div class="header-top">
                <div class="contact-info">
                    <span><i class="fas fa-phone"></i> <?php echo SITE_PHONE; ?></span>
                    <span><i class="fas fa-envelope"></i> <?php echo SITE_EMAIL; ?></span>
                    <span><i class="fas fa-clock"></i> <?php echo BUSINESS_HOURS; ?></span>
                </div>
                <div class="user-actions">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="account.php"><i class="fas fa-user"></i> حساب کاربری</a>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                            <a href="admin/"><i class="fas fa-cog"></i> پنل مدیریت</a>
                        <?php endif; ?>
                        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> خروج</a>
                    <?php else: ?>
                        <a href="login.php"><i class="fas fa-sign-in-alt"></i> ورود</a>
                        <a href="register.php"><i class="fas fa-user-plus"></i> ثبت نام</a>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Header Main -->
            <div class="header-main">
                <div class="logo">
                    <a href="index.php">
                        <h1><?php echo SITE_NAME; ?></h1>
                        <span>فروشگاه گیفت کارت و محصولات دیجیتالی</span>
                    </a>
                </div>
                
                <div class="search-box">
                    <form action="search.php" method="GET">
                        <input type="text" name="q" placeholder="جستجو در محصولات..." 
                               value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>" required>
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
            
            <!-- Navigation -->
            <nav class="main-nav">
                <ul>
                    <li><a href="index.php" <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'class="active"' : ''; ?>><i class="fas fa-home"></i> خانه</a></li>
                    
                    <li class="dropdown mega-dropdown">
                        <a href="products.php"><i class="fas fa-gift"></i> محصولات <i class="fas fa-chevron-down"></i></a>
                        <div class="mega-menu">
                            <div class="mega-menu-content">
                                <div class="mega-menu-column">
                                    <h4><i class="fas fa-gift"></i> گیفت کارت‌ها</h4>
                                    <ul>
                                        <li><a href="category.php?slug=steam-gift-cards">Steam گیفت کارت</a></li>
                                        <li><a href="category.php?slug=google-play-gift-cards">Google Play گیفت کارت</a></li>
                                        <li><a href="category.php?slug=apple-store-gift-cards">Apple Store گیفت کارت</a></li>
                                        <li><a href="category.php?slug=playstation-gift-cards">PlayStation گیفت کارت</a></li>
                                        <li><a href="category.php?slug=xbox-gift-cards">Xbox گیفت کارت</a></li>
                                        <li><a href="category.php?slug=other-gift-cards">Netflix گیفت کارت</a></li>
                                        <li><a href="category.php?slug=other-gift-cards">Spotify گیفت کارت</a></li>
                                        <li><a href="category.php?slug=other-gift-cards">Discord Nitro</a></li>
                                        <li><a href="category.php?slug=other-gift-cards">YouTube Premium</a></li>
                                        <li><a href="category.php?slug=other-gift-cards">Amazon گیفت کارت</a></li>
                                    </ul>
                                </div>
                                
                                <div class="mega-menu-column">
                                    <h4><i class="fas fa-mobile-alt"></i> پرداخت درون برنامه‌ای</h4>
                                    <ul>
                                        <li><a href="category.php?slug=in-app-purchases">PUBG UC خرید</a></li>
                                        <li><a href="category.php?slug=in-app-purchases">Free Fire الماس</a></li>
                                        <li><a href="category.php?slug=in-app-purchases">Clash of Clans جم</a></li>
                                        <li><a href="category.php?slug=in-app-purchases">Clash Royale جم</a></li>
                                        <li><a href="category.php?slug=in-app-purchases">Fortnite V-Bucks</a></li>
                                        <li><a href="category.php?slug=in-app-purchases">Genshin Impact</a></li>
                                        <li><a href="category.php?slug=in-app-purchases">Mobile Legends</a></li>
                                        <li><a href="category.php?slug=in-app-purchases">Brawl Stars</a></li>
                                        <li><a href="category.php?slug=in-app-purchases">Coin Master</a></li>
                                        <li><a href="category.php?slug=in-app-purchases">Roblox Robux</a></li>
                                    </ul>
                                </div>
                                
                                <div class="mega-menu-column">
                                    <h4><i class="fas fa-gamepad"></i> بازی‌ها و اکانت‌ها</h4>
                                    <ul>
                                        <li><a href="category.php?slug=pc-games">بازی‌های PC</a></li>
                                        <li><a href="category.php?slug=pc-games">بازی‌های Steam</a></li>
                                        <li><a href="category.php?slug=pc-games">بازی‌های Origin</a></li>
                                        <li><a href="category.php?slug=pc-games">بازی‌های Epic Games</a></li>
                                        <li><a href="category.php?slug=premium-accounts">Netflix اکانت</a></li>
                                        <li><a href="category.php?slug=premium-accounts">Spotify اکانت</a></li>
                                        <li><a href="category.php?slug=premium-accounts">YouTube Premium</a></li>
                                        <li><a href="category.php?slug=premium-accounts">Disney+ اکانت</a></li>
                                        <li><a href="category.php?slug=premium-accounts">Adobe اکانت</a></li>
                                        <li><a href="category.php?slug=premium-accounts">Office 365</a></li>
                                    </ul>
                                </div>
                                
                                <div class="mega-menu-column">
                                    <h4><i class="fas fa-cloud"></i> خدمات آنلاین</h4>
                                    <ul>
                                        <li><a href="category.php?slug=online-services">VPN خدمات</a></li>
                                        <li><a href="category.php?slug=online-services">آنتی ویروس</a></li>
                                        <li><a href="category.php?slug=online-services">Windows اکتیویشن</a></li>
                                        <li><a href="category.php?slug=online-services">نرم افزارها</a></li>
                                    </ul>
                                    
                                    <h4 style="margin-top: 20px;"><i class="fas fa-fire"></i> ویژه</h4>
                                    <ul>
                                        <li><a href="offers.php" style="color: #ff6b6b; font-weight: 600;">تخفیف‌های ویژه</a></li>
                                        <li><a href="products.php?featured=1" style="color: #667eea; font-weight: 600;">محصولات پرفروش</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                    
                    <li><a href="offers.php" <?php echo basename($_SERVER['PHP_SELF']) == 'offers.php' ? 'class="active"' : ''; ?>><i class="fas fa-fire"></i> تخفیف‌ها</a></li>
                    <li><a href="about.php" <?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'class="active"' : ''; ?>><i class="fas fa-info-circle"></i> درباره ما</a></li>
                    <li><a href="contact.php" <?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'class="active"' : ''; ?>><i class="fas fa-phone"></i> تماس با ما</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main-content">