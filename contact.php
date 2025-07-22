<?php
require_once 'config/config.php';

$page_title = 'تماس با ما';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize_input($_POST['name'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $subject = sanitize_input($_POST['subject'] ?? '');
    $message = sanitize_input($_POST['message'] ?? '');
    $csrf_token = $_POST['csrf_token'] ?? '';
    
    // Verify CSRF token
    if (!verify_csrf_token($csrf_token)) {
        $error = 'درخواست نامعتبر است.';
    } elseif (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = 'لطفا تمام فیلدها را پر کنید.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'فرمت ایمیل صحیح نیست.';
    } else {
        // Here you can add email sending functionality
        // For now, we'll just show a success message
        $success = 'پیام شما با موفقیت ارسال شد. به زودی با شما تماس خواهیم گرفت.';
        
        // Clear form data
        $name = $email = $subject = $message = '';
    }
}

require_once 'includes/header.php';
?>

<div class="container">
    <div class="section-title">
        <h2>تماس با ما</h2>
        <p>ما آماده پاسخگویی به سوالات شما هستیم</p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 30px;">
        
        <!-- Contact Form -->
        <div class="form-container">
            <h3 style="margin-bottom: 20px;">ارسال پیام</h3>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <?php echo generate_csrf_field(); ?>
                
                <div class="form-group">
                    <label for="name">نام و نام خانوادگی:</label>
                    <input type="text" id="name" name="name" class="form-control" 
                           value="<?php echo htmlspecialchars($name ?? ''); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email">ایمیل:</label>
                    <input type="email" id="email" name="email" class="form-control" 
                           value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="subject">موضوع:</label>
                    <select id="subject" name="subject" class="form-control" required>
                        <option value="">انتخاب کنید...</option>
                        <option value="سوال عمومی" <?php echo (($subject ?? '') == 'سوال عمومی') ? 'selected' : ''; ?>>سوال عمومی</option>
                        <option value="مشکل فنی" <?php echo (($subject ?? '') == 'مشکل فنی') ? 'selected' : ''; ?>>مشکل فنی</option>
                        <option value="سفارش" <?php echo (($subject ?? '') == 'سفارش') ? 'selected' : ''; ?>>مربوط به سفارش</option>
                        <option value="پیشنهاد" <?php echo (($subject ?? '') == 'پیشنهاد') ? 'selected' : ''; ?>>انتقاد و پیشنهاد</option>
                        <option value="همکاری" <?php echo (($subject ?? '') == 'همکاری') ? 'selected' : ''; ?>>درخواست همکاری</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="message">پیام:</label>
                    <textarea id="message" name="message" class="form-control" rows="5" 
                              placeholder="پیام خود را بنویسید..." required><?php echo htmlspecialchars($message ?? ''); ?></textarea>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <i class="fas fa-paper-plane"></i> ارسال پیام
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Contact Info -->
        <div>
            <div style="background: #fff; border-radius: 15px; padding: 30px; box-shadow: 0 5px 25px rgba(0,0,0,0.1); margin-bottom: 30px;">
                <h3 style="margin-bottom: 25px; color: #333;">اطلاعات تماس</h3>
                
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="width: 50px; height: 50px; background: #667eea; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h4 style="margin-bottom: 5px; color: #333;">آدرس</h4>
                            <p style="color: #666; margin: 0;">تهران، خیابان ولیعصر، پلاک 123، طبقه 2</p>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="width: 50px; height: 50px; background: #51cf66; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <h4 style="margin-bottom: 5px; color: #333;">تلفن</h4>
                            <p style="color: #666; margin: 0;">021-12345678</p>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="width: 50px; height: 50px; background: #ff6b6b; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h4 style="margin-bottom: 5px; color: #333;">ایمیل</h4>
                            <p style="color: #666; margin: 0;">info@gaming-store.com</p>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="width: 50px; height: 50px; background: #ffd93d; color: #333; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h4 style="margin-bottom: 5px; color: #333;">ساعات کاری</h4>
                            <p style="color: #666; margin: 0;">شنبه تا پنج‌شنبه: 9:00 - 18:00</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Social Media -->
            <div style="background: #fff; border-radius: 15px; padding: 30px; box-shadow: 0 5px 25px rgba(0,0,0,0.1);">
                <h3 style="margin-bottom: 25px; color: #333;">شبکه‌های اجتماعی</h3>
                
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                    <a href="#" style="display: flex; align-items: center; gap: 10px; padding: 15px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: #fff; text-decoration: none; border-radius: 10px; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                        <i class="fab fa-instagram" style="font-size: 24px;"></i>
                        <span>اینستاگرام</span>
                    </a>
                    
                    <a href="#" style="display: flex; align-items: center; gap: 10px; padding: 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; text-decoration: none; border-radius: 10px; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                        <i class="fab fa-telegram" style="font-size: 24px;"></i>
                        <span>تلگرام</span>
                    </a>
                    
                    <a href="#" style="display: flex; align-items: center; gap: 10px; padding: 15px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: #fff; text-decoration: none; border-radius: 10px; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                        <i class="fab fa-twitter" style="font-size: 24px;"></i>
                        <span>توییتر</span>
                    </a>
                    
                    <a href="#" style="display: flex; align-items: center; gap: 10px; padding: 15px; background: linear-gradient(135deg, #ff9a56 0%, #ff6b95 100%); color: #fff; text-decoration: none; border-radius: 10px; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                        <i class="fab fa-youtube" style="font-size: 24px;"></i>
                        <span>یوتیوب</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- FAQ Section -->
    <section class="section">
        <div class="section-title">
            <h2>سوالات متداول</h2>
        </div>
        
        <div style="background: #fff; border-radius: 15px; padding: 30px; box-shadow: 0 5px 25px rgba(0,0,0,0.1);">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                <div>
                    <h4 style="color: #667eea; margin-bottom: 10px;">چگونه سفارش دهم؟</h4>
                    <p style="color: #666; line-height: 1.6;">محصول مورد نظر را انتخاب کرده، به سبد خرید اضافه کنید و مراحل پرداخت را تکمیل کنید.</p>
                </div>
                
                <div>
                    <h4 style="color: #667eea; margin-bottom: 10px;">زمان ارسال چقدر است؟</h4>
                    <p style="color: #666; line-height: 1.6;">معمولاً ارسال کالاها بین 1 تا 3 روز کاری انجام می‌شود.</p>
                </div>
                
                <div>
                    <h4 style="color: #667eea; margin-bottom: 10px;">آیا امکان مرجوعی وجود دارد؟</h4>
                    <p style="color: #666; line-height: 1.6;">بله، تا 7 روز پس از خرید امکان بازگشت کالا وجود دارد.</p>
                </div>
                
                <div>
                    <h4 style="color: #667eea; margin-bottom: 10px;">روش‌های پرداخت چیست؟</h4>
                    <p style="color: #666; line-height: 1.6;">پرداخت آنلاین با کلیه کارت‌های بانکی و درگاه‌های معتبر.</p>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
@media (max-width: 768px) {
    .container > div[style*="grid-template-columns: 1fr 1fr"] {
        display: block !important;
    }
    
    .form-container {
        margin-bottom: 30px;
    }
}
</style>

<?php require_once 'includes/footer.php'; ?>