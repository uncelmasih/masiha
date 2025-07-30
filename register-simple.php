<?php
session_start();

$page_title = 'ثبت نام';
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
    header('Location: index.php');
    exit();
}

// Create users directory if not exists
if (!file_exists('users')) {
    mkdir('users', 0755, true);
}

$users_file = 'users/users.json';

// Load existing users
$users = [];
if (file_exists($users_file)) {
    $users_data = file_get_contents($users_file);
    $users = json_decode($users_data, true) ?: [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitize_input($_POST['username'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $full_name = sanitize_input($_POST['full_name'] ?? '');
    $phone = sanitize_input($_POST['phone'] ?? '');
    $csrf_token = $_POST['csrf_token'] ?? '';
    
    // Verify CSRF token
    if (!verify_csrf_token($csrf_token)) {
        $error = 'درخواست نامعتبر است. لطفا صفحه را تازه کنید و دوباره تلاش کنید.';
    } elseif (empty($username) || empty($email) || empty($password) || empty($full_name)) {
        $error = 'لطفا تمام فیلدهای ضروری (نشان داده شده با *) را پر کنید.';
    } elseif (strlen($username) < 3) {
        $error = 'نام کاربری باید حداقل 3 کاراکتر باشد.';
    } elseif ($password !== $confirm_password) {
        $error = 'رمز عبور و تکرار آن یکسان نیست.';
    } elseif (strlen($password) < 6) {
        $error = 'رمز عبور باید حداقل 6 کاراکتر باشد.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'فرمت ایمیل صحیح نیست.';
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $error = 'نام کاربری فقط می‌تواند شامل حروف انگلیسی، اعداد و خط تیره باشد.';
    } else {
        // Check if username or email already exists
        $user_exists = false;
        foreach ($users as $user) {
            if ($user['username'] === $username || $user['email'] === $email) {
                $user_exists = true;
                break;
            }
        }
        
        if ($user_exists) {
            $error = 'نام کاربری یا ایمیل قبلا استفاده شده است.';
        } else {
            // Create new user
            $new_user = [
                'id' => count($users) + 1,
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'full_name' => $full_name,
                'phone' => $phone,
                'role' => 'user',
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $users[] = $new_user;
            
            // Save to file
            if (file_put_contents($users_file, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
                $success = 'ثبت نام با موفقیت انجام شد. اکنون می‌توانید وارد شوید.';
                
                // Clear form data
                $username = $email = $full_name = $phone = '';
            } else {
                $error = 'خطا در ذخیره اطلاعات. لطفا دوباره تلاش کنید.';
            }
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
            max-width: 500px;
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
        small {
            color: #666;
            font-size: 14px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-weight: 700;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2><i class="fas fa-user-plus"></i> ثبت نام</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                <br><br>
                <a href="login-simple.php" class="btn" style="display: inline-block; width: auto; padding: 10px 20px;">ورود به حساب کاربری</a>
            </div>
        <?php endif; ?>
        
        <?php if (!$success): ?>
        <form method="POST" action="" novalidate>
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            
            <div class="form-group">
                <label for="full_name"><i class="fas fa-user"></i> نام و نام خانوادگی: *</label>
                <input type="text" id="full_name" name="full_name" class="form-control" 
                       value="<?php echo htmlspecialchars($full_name ?? ''); ?>" 
                       required minlength="2" maxlength="100"
                       placeholder="نام و نام خانوادگی خود را وارد کنید">
            </div>
            
            <div class="form-group">
                <label for="username"><i class="fas fa-at"></i> نام کاربری: *</label>
                <input type="text" id="username" name="username" class="form-control" 
                       value="<?php echo htmlspecialchars($username ?? ''); ?>" 
                       required minlength="3" maxlength="50"
                       pattern="[a-zA-Z0-9_]+"
                       placeholder="نام کاربری (حروف انگلیسی، اعداد و خط تیره)">
                <small>حداقل 3 کاراکتر - فقط حروف انگلیسی، اعداد و خط تیره</small>
            </div>
            
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> ایمیل: *</label>
                <input type="email" id="email" name="email" class="form-control" 
                       value="<?php echo htmlspecialchars($email ?? ''); ?>" 
                       required maxlength="100"
                       placeholder="example@domain.com">
            </div>
            
            <div class="form-group">
                <label for="phone"><i class="fas fa-phone"></i> شماره تماس:</label>
                <input type="tel" id="phone" name="phone" class="form-control" 
                       value="<?php echo htmlspecialchars($phone ?? ''); ?>" 
                       maxlength="20"
                       pattern="09[0-9]{9}"
                       placeholder="09123456789">
                <small>فرمت: 09123456789</small>
            </div>
            
            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> رمز عبور: *</label>
                <input type="password" id="password" name="password" class="form-control" 
                       required minlength="6" maxlength="255"
                       placeholder="رمز عبور (حداقل 6 کاراکتر)">
                <small>حداقل 6 کاراکتر</small>
            </div>
            
            <div class="form-group">
                <label for="confirm_password"><i class="fas fa-lock"></i> تکرار رمز عبور: *</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" 
                       required minlength="6" maxlength="255"
                       placeholder="رمز عبور را دوباره وارد کنید">
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn">
                    <i class="fas fa-user-plus"></i> ثبت نام
                </button>
            </div>
        </form>
        <?php endif; ?>
        
        <div class="login-link">
            <p>قبلا ثبت نام کرده اید؟ <a href="login-simple.php">وارد شوید</a></p>
        </div>
    </div>

    <script>
    // Additional client-side validation
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');
        
        if (form && password && confirmPassword) {
            function validatePasswords() {
                if (password.value !== confirmPassword.value) {
                    confirmPassword.setCustomValidity('رمز عبور و تکرار آن یکسان نیست');
                } else {
                    confirmPassword.setCustomValidity('');
                }
            }
            
            password.addEventListener('input', validatePasswords);
            confirmPassword.addEventListener('input', validatePasswords);
            
            form.addEventListener('submit', function(e) {
                validatePasswords();
                if (!form.checkValidity()) {
                    e.preventDefault();
                    const firstInvalid = form.querySelector(':invalid');
                    if (firstInvalid) {
                        firstInvalid.focus();
                        
                        // Show custom error message
                        const errorMsg = document.createElement('div');
                        errorMsg.className = 'alert alert-error';
                        errorMsg.innerHTML = '<i class="fas fa-exclamation-circle"></i> لطفا تمام فیلدها را به درستی پر کنید';
                        form.insertBefore(errorMsg, form.firstChild);
                        
                        setTimeout(() => {
                            errorMsg.remove();
                        }, 5000);
                    }
                }
            });
        }
        
        // Auto-hide alerts after 10 seconds
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    if (alert.parentElement) {
                        alert.remove();
                    }
                }, 300);
            }, 10000);
        });
    });
    </script>
</body>
</html>