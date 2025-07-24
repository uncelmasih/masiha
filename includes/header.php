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
                    <li class="dropdown mega-dropdown">
                        <a href="products.php"><i class="fas fa-gift"></i> محصولات <i class="fas fa-chevron-down"></i></a>
                        <div class="mega-menu">
                            <div class="mega-menu-content">
                                <div class="mega-menu-column">
                                    <h4><i class="fas fa-gift"></i> گیفت کارت‌ها</h4>
                                    <ul>
                                        <li><a href="category.php?cat=steam">Steam گیفت کارت</a></li>
                                        <li><a href="category.php?cat=google-play">Google Play گیفت کارت</a></li>
                                        <li><a href="category.php?cat=apple-store">Apple Store گیفت کارت</a></li>
                                        <li><a href="category.php?cat=amazon">Amazon گیفت کارت</a></li>
                                        <li><a href="category.php?cat=playstation">PlayStation گیفت کارت</a></li>
                                        <li><a href="category.php?cat=xbox">Xbox گیفت کارت</a></li>
                                        <li><a href="category.php?cat=netflix">Netflix گیفت کارت</a></li>
                                        <li><a href="category.php?cat=spotify">Spotify گیفت کارت</a></li>
                                        <li><a href="category.php?cat=discord">Discord Nitro گیفت کارت</a></li>
                                        <li><a href="category.php?cat=youtube">YouTube Premium گیفت کارت</a></li>
                                    </ul>
                                </div>
                                
                                <div class="mega-menu-column">
                                    <h4><i class="fas fa-mobile-alt"></i> پرداخت‌های درون برنامه‌ای</h4>
                                    <ul>
                                        <li><a href="category.php?cat=pubg-uc">PUBG UC خرید</a></li>
                                        <li><a href="category.php?cat=free-fire">Free Fire الماس</a></li>
                                        <li><a href="category.php?cat=clash-of-clans">Clash of Clans جم</a></li>
                                        <li><a href="category.php?cat=clash-royale">Clash Royale جم</a></li>
                                        <li><a href="category.php?cat=fortnite-vbucks">Fortnite V-Bucks</a></li>
                                        <li><a href="category.php?cat=genshin-impact">Genshin Impact Genesis</a></li>
                                        <li><a href="category.php?cat=mobile-legends">Mobile Legends الماس</a></li>
                                        <li><a href="category.php?cat=brawl-stars">Brawl Stars جم</a></li>
                                        <li><a href="category.php?cat=coin-master">Coin Master سکه</a></li>
                                        <li><a href="category.php?cat=roblox">Roblox Robux</a></li>
                                    </ul>
                                </div>
                                
                                <div class="mega-menu-column">
                                    <h4><i class="fas fa-gamepad"></i> گیم‌ها</h4>
                                    <ul>
                                        <li><a href="category.php?cat=pc-games">بازی‌های PC</a></li>
                                        <li><a href="category.php?cat=steam-games">بازی‌های Steam</a></li>
                                        <li><a href="category.php?cat=origin-games">بازی‌های Origin</a></li>
                                        <li><a href="category.php?cat=ubisoft-games">بازی‌های Ubisoft</a></li>
                                        <li><a href="category.php?cat=epic-games">بازی‌های Epic Games</a></li>
                                        <li><a href="category.php?cat=psn-games">بازی‌های PlayStation</a></li>
                                        <li><a href="category.php?cat=xbox-games">بازی‌های Xbox</a></li>
                                        <li><a href="category.php?cat=nintendo-games">بازی‌های Nintendo</a></li>
                                        <li><a href="category.php?cat=android-games">بازی‌های Android</a></li>
                                        <li><a href="category.php?cat=ios-games">بازی‌های iOS</a></li>
                                    </ul>
                                </div>
                                
                                <div class="mega-menu-column">
                                    <h4><i class="fas fa-shopping-cart"></i> خرید‌های دیگر</h4>
                                    <ul>
                                        <li><a href="category.php?cat=vpn">VPN خدمات</a></li>
                                        <li><a href="category.php?cat=antivirus">آنتی ویروس</a></li>
                                        <li><a href="category.php?cat=software">نرم افزارها</a></li>
                                        <li><a href="category.php?cat=accounts">اکانت‌های پریمیوم</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li><a href="offers.php"><i class="fas fa-fire"></i> تخفیف‌ها</a></li>
                    <li><a href="about.php"><i class="fas fa-info-circle"></i> درباره ما</a></li>
                    <li><a href="contact.php"><i class="fas fa-phone"></i> تماس با ما</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>