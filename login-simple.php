<?php
session_start();

$page_title = 'ورود';
$error = '';
$success = '';

// Security functions
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard-simple.php');
    exit();
}

$users_file = 'users/users.json';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitize_input($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $csrf_token = $_POST['csrf_token'] ?? '';
    
    // Verify CSRF token
    if (!verify_csrf_token($csrf_token)) {
        $error = 'درخواست نامعتبر است. لطفا صفحه را تازه کنید و دوباره تلاش کنید.';
    } elseif (empty($username) || empty($password)) {
        $error = 'لطفا نام کاربری و رمز عبور را وارد کنید.';
    } else {
        // Load users from file
        if (file_exists($users_file)) {
            $users_data = file_get_contents($users_file);
            $users = json_decode($users_data, true) ?: [];
            
            // Find user
            $user_found = false;
            foreach ($users as $user) {
                if (($user['username'] === $username || $user['email'] === $username) && 
                    password_verify($password, $user['password'])) {
                    
                    if ($user['is_active']) {
                        // Login successful
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['full_name'] = $user['full_name'];
                        $_SESSION['role'] = $user['role'];
                        
                        header('Location: dashboard-simple.php');
                        exit();
                    } else {
                        $error = 'حساب کاربری شما غیرفعال است.';
                    }
                    $user_found = true;
                    break;
                }
            }
            
            if (!$user_found) {
                $error = 'نام کاربری یا رمز عبور اشتباه است.';
            }
        } else {
            $error = 'هیچ کاربری ثبت نام نکرده است. لطفا ابتدا ثبت نام کنید.';
        }
    }
}

$csrf_token = generate_csrf_token();
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - گیمینگ استور</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link href="https://fonts.googleapis.com/css2?family=Vazir:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 90%;
            margin: 20px auto;
        }
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        .alert-success {
            background: linear-gradient(135deg, #51cf66, #40c057);
            color: white;
            border: none;
        }
        .alert-error {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
            border: none;
        }
        .form-group {
            margin-bottom: 25px;
        }
        .form-control {
            width: 100%;
            padding: 15px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 16px;
            font-family: 'Vazir', Arial, sans-serif;
            transition: all 0.3s;
            box-sizing: border-box;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }
        .btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }
        label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-weight: 700;
        }
        .register-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        .demo-info {
            background: linear-gradient(135deg, #74b9ff, #0984e3);
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2><i class="fas fa-sign-in-alt"></i> ورود</h2>
        
        <div class="demo-info">
            <i class="fas fa-info-circle"></i>
            برای تست، ابتدا در صفحه ثبت نام یک حساب بسازید
        </div>
        
        <?php if ($error): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            
            <div class="form-group">
                <label for="username"><i class="fas fa-user"></i> نام کاربری یا ایمیل:</label>
                <input type="text" id="username" name="username" class="form-control" 
                       value="<?php echo htmlspecialchars($username ?? ''); ?>" 
                       required
                       placeholder="نام کاربری یا ایمیل خود را وارد کنید">
            </div>
            
            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> رمز عبور:</label>
                <input type="password" id="password" name="password" class="form-control" 
                       required
                       placeholder="رمز عبور خود را وارد کنید">
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn">
                    <i class="fas fa-sign-in-alt"></i> ورود
                </button>
            </div>
        </form>
        
        <div class="register-link">
            <p>حساب کاربری ندارید؟ <a href="register-simple.php">ثبت نام کنید</a></p>
        </div>
    </div>

    <script>
    // Auto-hide alerts after 8 seconds
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    if (alert.parentElement) {
                        alert.remove();
                    }
                }, 300);
            }, 8000);
        });
    });
    </script>
</body>
</html>