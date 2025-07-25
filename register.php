<?php
require_once 'config/config.php';

$page_title = 'ثبت نام';
$error = '';
$success = '';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
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
        try {
            // Check if username or email already exists
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            
            if ($stmt->fetch()) {
                $error = 'نام کاربری یا ایمیل قبلا استفاده شده است.';
            } else {
                // Hash password and insert user
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password, full_name, phone) VALUES (?, ?, ?, ?, ?)");
                if ($stmt->execute([$username, $email, $hashed_password, $full_name, $phone])) {
                    $success = 'ثبت نام با موفقیت انجام شد. اکنون می‌توانید وارد شوید.';
                    
                    // Clear form data
                    $username = $email = $full_name = $phone = '';
                } else {
                    $error = 'خطا در ثبت اطلاعات. لطفا دوباره تلاش کنید.';
                }
            }
        } catch (PDOException $e) {
            error_log("Registration error: " . $e->getMessage());
            $error = 'خطا در ثبت نام. لطفا دوباره تلاش کنید.';
        }
    }
}

require_once 'includes/header.php';
?>

<div class="container">
    <div class="form-container">
        <h2 style="text-align: center; margin-bottom: 30px;">ثبت نام</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success">
                <?php echo $success; ?>
                <br><br>
                <a href="login.php" class="btn btn-primary">ورود به حساب کاربری</a>
            </div>
        <?php endif; ?>
        
        <?php if (!$success): ?>
        <form method="POST" action="" novalidate>
            <?php echo generate_csrf_field(); ?>
            
            <div class="form-group">
                <label for="full_name">نام و نام خانوادگی: *</label>
                <input type="text" id="full_name" name="full_name" class="form-control" 
                       value="<?php echo htmlspecialchars($full_name ?? ''); ?>" 
                       required minlength="2" maxlength="100"
                       placeholder="نام و نام خانوادگی خود را وارد کنید">
            </div>
            
            <div class="form-group">
                <label for="username">نام کاربری: *</label>
                <input type="text" id="username" name="username" class="form-control" 
                       value="<?php echo htmlspecialchars($username ?? ''); ?>" 
                       required minlength="3" maxlength="50"
                       pattern="[a-zA-Z0-9_]+"
                       placeholder="نام کاربری (حروف انگلیسی، اعداد و خط تیره)">
                <small style="color: #666;">حداقل 3 کاراکتر - فقط حروف انگلیسی، اعداد و خط تیره</small>
            </div>
            
            <div class="form-group">
                <label for="email">ایمیل: *</label>
                <input type="email" id="email" name="email" class="form-control" 
                       value="<?php echo htmlspecialchars($email ?? ''); ?>" 
                       required maxlength="100"
                       placeholder="example@domain.com">
            </div>
            
            <div class="form-group">
                <label for="phone">شماره تماس:</label>
                <input type="tel" id="phone" name="phone" class="form-control" 
                       value="<?php echo htmlspecialchars($phone ?? ''); ?>" 
                       maxlength="20"
                       pattern="09[0-9]{9}"
                       placeholder="09123456789">
                <small style="color: #666;">فرمت: 09123456789</small>
            </div>
            
            <div class="form-group">
                <label for="password">رمز عبور: *</label>
                <input type="password" id="password" name="password" class="form-control" 
                       required minlength="6" maxlength="255"
                       placeholder="رمز عبور (حداقل 6 کاراکتر)">
                <small style="color: #666;">حداقل 6 کاراکتر</small>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">تکرار رمز عبور: *</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" 
                       required minlength="6" maxlength="255"
                       placeholder="رمز عبور را دوباره وارد کنید">
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary" style="width: 100%;">ثبت نام</button>
            </div>
        </form>
        <?php endif; ?>
        
        <div style="text-align: center; margin-top: 20px;">
            <p>قبلا ثبت نام کرده اید؟ <a href="login.php">وارد شوید</a></p>
        </div>
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
                }
            }
        });
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>