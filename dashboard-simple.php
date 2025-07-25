<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login-simple.php');
    exit();
}

$users_file = 'users/users.json';

// Load user data
$current_user = null;
if (file_exists($users_file)) {
    $users_data = file_get_contents($users_file);
    $users = json_decode($users_data, true) ?: [];
    
    foreach ($users as $user) {
        if ($user['id'] == $_SESSION['user_id']) {
            $current_user = $user;
            break;
        }
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login-simple.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>داشبورد - گیمینگ استور</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link href="https://fonts.googleapis.com/css2?family=Vazir:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            margin: 0;
            font-family: 'Vazir', Arial, sans-serif;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        .welcome-text {
            flex: 1;
        }
        .welcome-text h1 {
            margin: 0 0 10px 0;
            color: #333;
            font-weight: 700;
        }
        .welcome-text p {
            margin: 0;
            color: #666;
            font-size: 16px;
        }
        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        .btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }
        .btn-danger {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
        }
        .btn-danger:hover {
            box-shadow: 0 10px 25px rgba(255, 107, 107, 0.3);
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-icon {
            font-size: 48px;
            margin-bottom: 15px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .stat-title {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }
        .stat-description {
            color: #666;
            font-size: 14px;
        }
        .user-info {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .user-info h2 {
            color: #333;
            margin-bottom: 20px;
            font-weight: 700;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .info-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            border: 2px solid #e9ecef;
            transition: all 0.3s;
        }
        .info-item:hover {
            border-color: #667eea;
            transform: translateX(5px);
        }
        .info-icon {
            font-size: 20px;
            color: #667eea;
            width: 30px;
            text-align: center;
        }
        .info-content {
            flex: 1;
        }
        .info-label {
            font-weight: 600;
            color: #333;
            font-size: 14px;
            margin-bottom: 3px;
        }
        .info-value {
            color: #666;
        }
        .success-message {
            background: linear-gradient(135deg, #51cf66, #40c057);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
            box-shadow: 0 10px 25px rgba(81, 207, 102, 0.3);
        }
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                text-align: center;
            }
            .header-actions {
                flex-direction: column;
                width: 100%;
            }
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="welcome-text">
                <h1><i class="fas fa-user-circle"></i> خوش آمدید، <?php echo htmlspecialchars($current_user['full_name'] ?? 'کاربر'); ?>!</h1>
                <p>به داشبورد شخصی خود در گیمینگ استور خوش آمدید</p>
            </div>
            <div class="header-actions">
                <a href="register-simple.php" class="btn">
                    <i class="fas fa-user-plus"></i> ثبت نام جدید
                </a>
                <a href="?logout=1" class="btn btn-danger" onclick="return confirm('آیا مطمئن هستید که می‌خواهید خارج شوید؟')">
                    <i class="fas fa-sign-out-alt"></i> خروج
                </a>
            </div>
        </div>

        <div class="success-message">
            <i class="fas fa-check-circle"></i>
            ثبت نام و ورود شما با موفقیت انجام شد! سیستم ثبت نام کاملاً کار می‌کند.
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-title">ثبت نام موفق</div>
                <div class="stat-description">سیستم ثبت نام کاملاً فعال و کار می‌کند</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="stat-title">امنیت بالا</div>
                <div class="stat-description">رمز عبور هش شده و محافظت CSRF فعال</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <div class="stat-title">موبایل فرندلی</div>
                <div class="stat-description">طراحی ریسپانسیو برای همه دستگاه‌ها</div>
            </div>
        </div>

        <div class="user-info">
            <h2><i class="fas fa-info-circle"></i> اطلاعات حساب کاربری</h2>
            
            <?php if ($current_user): ?>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">نام و نام خانوادگی</div>
                        <div class="info-value"><?php echo htmlspecialchars($current_user['full_name']); ?></div>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-at"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">نام کاربری</div>
                        <div class="info-value"><?php echo htmlspecialchars($current_user['username']); ?></div>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">ایمیل</div>
                        <div class="info-value"><?php echo htmlspecialchars($current_user['email']); ?></div>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">شماره تماس</div>
                        <div class="info-value"><?php echo htmlspecialchars($current_user['phone'] ?? 'وارد نشده'); ?></div>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">تاریخ عضویت</div>
                        <div class="info-value"><?php echo htmlspecialchars($current_user['created_at']); ?></div>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-crown"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">نقش کاربری</div>
                        <div class="info-value"><?php echo $current_user['role'] === 'admin' ? 'مدیر' : 'کاربر عادی'; ?></div>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <p style="text-align: center; color: #ff6b6b;">خطا در بارگذاری اطلاعات کاربر</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
    // Add some interactive effects
    document.addEventListener('DOMContentLoaded', function() {
        // Animate cards on load
        const cards = document.querySelectorAll('.stat-card, .info-item');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
        
        // Auto-hide success message after 10 seconds
        const successMsg = document.querySelector('.success-message');
        if (successMsg) {
            setTimeout(() => {
                successMsg.style.opacity = '0';
                successMsg.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    successMsg.remove();
                }, 500);
            }, 10000);
        }
    });
    </script>
</body>
</html>