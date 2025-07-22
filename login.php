<?php
require_once 'config/config.php';

$page_title = 'ورود';
$error = '';
$success = '';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = sanitize_input($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $csrf_token = $_POST['csrf_token'] ?? '';
    
    // Verify CSRF token
    if (!verify_csrf_token($csrf_token)) {
        $error = 'درخواست نامعتبر است.';
    } elseif (empty($email) || empty($password)) {
        $error = 'لطفا تمام فیلدها را پر کنید.';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND is_active = 1");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password'])) {
                // Successful login
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['full_name'] = $user['full_name'];
                
                // Update cart count
                $stmt = $pdo->prepare("SELECT SUM(quantity) as total FROM cart WHERE user_id = ?");
                $stmt->execute([$user['id']]);
                $cart_result = $stmt->fetch();
                $_SESSION['cart_count'] = $cart_result['total'] ?? 0;
                
                // Redirect to intended page or home
                $redirect = $_GET['redirect'] ?? 'index.php';
                header('Location: ' . $redirect);
                exit();
            } else {
                $error = 'ایمیل یا رمز عبور اشتباه است.';
            }
        } catch (PDOException $e) {
            $error = 'خطا در ورود. لطفا دوباره تلاش کنید.';
        }
    }
}

require_once 'includes/header.php';
?>

<div class="container">
    <div class="form-container">
        <h2 style="text-align: center; margin-bottom: 30px;">ورود به حساب کاربری</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <?php echo generate_csrf_field(); ?>
            
            <div class="form-group">
                <label for="email">ایمیل:</label>
                <input type="email" id="email" name="email" class="form-control" 
                       value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="password">رمز عبور:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary" style="width: 100%;">ورود</button>
            </div>
        </form>
        
        <div style="text-align: center; margin-top: 20px;">
            <p>حساب کاربری ندارید؟ <a href="register.php">ثبت نام کنید</a></p>
            <p><a href="forgot-password.php">رمز عبور خود را فراموش کرده اید؟</a></p>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>