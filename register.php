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
        $error = 'درخواست نامعتبر است.';
    } elseif (empty($username) || empty($email) || empty($password) || empty($full_name)) {
        $error = 'لطفا فیلدهای ضروری را پر کنید.';
    } elseif ($password !== $confirm_password) {
        $error = 'رمز عبور و تکرار آن یکسان نیست.';
    } elseif (strlen($password) < 6) {
        $error = 'رمز عبور باید حداقل 6 کاراکتر باشد.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'فرمت ایمیل صحیح نیست.';
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
                $stmt->execute([$username, $email, $hashed_password, $full_name, $phone]);
                
                $success = 'ثبت نام با موفقیت انجام شد. می‌توانید وارد شوید.';
                
                // Clear form data
                $username = $email = $full_name = $phone = '';
            }
        } catch (PDOException $e) {
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
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <?php echo generate_csrf_field(); ?>
            
            <div class="form-group">
                <label for="full_name">نام و نام خانوادگی: *</label>
                <input type="text" id="full_name" name="full_name" class="form-control" 
                       value="<?php echo htmlspecialchars($full_name ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="username">نام کاربری: *</label>
                <input type="text" id="username" name="username" class="form-control" 
                       value="<?php echo htmlspecialchars($username ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">ایمیل: *</label>
                <input type="email" id="email" name="email" class="form-control" 
                       value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="phone">شماره تماس:</label>
                <input type="text" id="phone" name="phone" class="form-control" 
                       value="<?php echo htmlspecialchars($phone ?? ''); ?>" placeholder="09123456789">
            </div>
            
            <div class="form-group">
                <label for="password">رمز عبور: *</label>
                <input type="password" id="password" name="password" class="form-control" required minlength="6">
                <small style="color: #666;">حداقل 6 کاراکتر</small>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">تکرار رمز عبور: *</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary" style="width: 100%;">ثبت نام</button>
            </div>
        </form>
        
        <div style="text-align: center; margin-top: 20px;">
            <p>قبلا ثبت نام کرده اید؟ <a href="login.php">وارد شوید</a></p>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>