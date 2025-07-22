<?php
require_once 'config/config.php';

$page_title = 'درباره ما';

require_once 'includes/header.php';
?>

<div class="container">
    <div class="section-title">
        <h2>درباره ما</h2>
        <p>بهترین فروشگاه آنلاین محصولات گیمینگ</p>
    </div>

    <!-- Hero Section -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px; padding: 50px 30px; text-align: center; color: #fff; margin-bottom: 50px;">
        <h2 style="font-size: 36px; margin-bottom: 20px;">گیمینگ استور</h2>
        <p style="font-size: 18px; line-height: 1.8; max-width: 600px; margin: 0 auto;">
            ما با هدف ارائه بهترین و جدیدترین محصولات گیمینگ، خدمات باکیفیتی را به علاقه‌مندان بازی‌های رایانه‌ای ارائه می‌دهیم.
        </p>
    </div>

    <!-- Stats -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px; margin-bottom: 50px;">
        <div style="text-align: center; background: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 5px 25px rgba(0,0,0,0.1);">
            <div style="width: 80px; height: 80px; background: #667eea; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 32px;">
                <i class="fas fa-users"></i>
            </div>
            <h3 style="font-size: 28px; color: #333; margin-bottom: 10px;">1000+</h3>
            <p style="color: #666;">مشتری راضی</p>
        </div>
        
        <div style="text-align: center; background: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 5px 25px rgba(0,0,0,0.1);">
            <div style="width: 80px; height: 80px; background: #51cf66; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 32px;">
                <i class="fas fa-box"></i>
            </div>
            <h3 style="font-size: 28px; color: #333; margin-bottom: 10px;">500+</h3>
            <p style="color: #666;">محصول متنوع</p>
        </div>
        
        <div style="text-align: center; background: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 5px 25px rgba(0,0,0,0.1);">
            <div style="width: 80px; height: 80px; background: #ff6b6b; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 32px;">
                <i class="fas fa-shipping-fast"></i>
            </div>
            <h3 style="font-size: 28px; color: #333; margin-bottom: 10px;">24/7</h3>
            <p style="color: #666;">ارسال سریع</p>
        </div>
        
        <div style="text-align: center; background: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 5px 25px rgba(0,0,0,0.1);">
            <div style="width: 80px; height: 80px; background: #ffd93d; color: #333; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 32px;">
                <i class="fas fa-star"></i>
            </div>
            <h3 style="font-size: 28px; color: #333; margin-bottom: 10px;">4.8/5</h3>
            <p style="color: #666;">امتیاز مشتریان</p>
        </div>
    </div>

    <!-- About Content -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 50px; margin-bottom: 50px; align-items: center;">
        <div>
            <h3 style="font-size: 28px; color: #333; margin-bottom: 20px;">داستان ما</h3>
            <div style="line-height: 1.8; color: #666;">
                <p style="margin-bottom: 20px;">
                    گیمینگ استور در سال 1400 با هدف ارائه بهترین محصولات گیمینگ آغاز به کار کرد. ما معتقدیم که هر گیمر حق دسترسی به باکیفیت‌ترین تجهیزات را دارد.
                </p>
                <p style="margin-bottom: 20px;">
                    تیم ما متشکل از افرادی است که خود علاقه‌مند به دنیای گیمینگ هستند و تجربه عمیقی در این زمینه دارند. همین موضوع باعث شده تا بتوانیم بهترین انتخاب‌ها را برای شما فراهم کنیم.
                </p>
                <p>
                    هدف ما ایجاد تجربه‌ای فوق‌العاده برای مشتریان از ابتدای خرید تا پس از آن است. ما به کیفیت، سرعت ارسال و پشتیبانی عالی اعتقاد داریم.
                </p>
            </div>
        </div>
        
        <div style="background: #f8f9fa; border-radius: 15px; padding: 30px; text-align: center;">
            <i class="fas fa-gamepad" style="font-size: 120px; color: #667eea; margin-bottom: 20px;"></i>
            <h4 style="color: #333; margin-bottom: 15px;">ماموریت ما</h4>
            <p style="color: #666; line-height: 1.7;">
                ارائه بهترین محصولات گیمینگ با کیفیت برتر، قیمت مناسب و خدمات عالی به تمامی علاقه‌مندان بازی‌های رایانه‌ای در سراسر کشور.
            </p>
        </div>
    </div>

    <!-- Values -->
    <section class="section">
        <div class="section-title">
            <h2>ارزش‌های ما</h2>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
            <div style="background: #fff; border-radius: 15px; padding: 30px; box-shadow: 0 5px 25px rgba(0,0,0,0.1); text-align: center;">
                <div style="width: 80px; height: 80px; background: #667eea; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 32px;">
                    <i class="fas fa-award"></i>
                </div>
                <h4 style="color: #333; margin-bottom: 15px;">کیفیت برتر</h4>
                <p style="color: #666; line-height: 1.6;">
                    تمامی محصولات ما از برندهای معتبر و با گارانتی معتبر هستند.
                </p>
            </div>
            
            <div style="background: #fff; border-radius: 15px; padding: 30px; box-shadow: 0 5px 25px rgba(0,0,0,0.1); text-align: center;">
                <div style="width: 80px; height: 80px; background: #51cf66; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 32px;">
                    <i class="fas fa-handshake"></i>
                </div>
                <h4 style="color: #333; margin-bottom: 15px;">اعتماد</h4>
                <p style="color: #666; line-height: 1.6;">
                    رضایت شما مهم‌ترین هدف ما است و همواره سعی در جلب اعتماد شما داریم.
                </p>
            </div>
            
            <div style="background: #fff; border-radius: 15px; padding: 30px; box-shadow: 0 5px 25px rgba(0,0,0,0.1); text-align: center;">
                <div style="width: 80px; height: 80px; background: #ff6b6b; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 32px;">
                    <i class="fas fa-rocket"></i>
                </div>
                <h4 style="color: #333; margin-bottom: 15px;">نوآوری</h4>
                <p style="color: #666; line-height: 1.6;">
                    همواره به دنبال جدیدترین و بهترین محصولات در دنیای گیمینگ هستیم.
                </p>
            </div>
        </div>
    </section>

    <!-- Team -->
    <section class="section">
        <div class="section-title">
            <h2>تیم ما</h2>
            <p>افرادی که گیمینگ استور را می‌سازند</p>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px;">
            <div style="background: #fff; border-radius: 15px; padding: 30px; box-shadow: 0 5px 25px rgba(0,0,0,0.1); text-align: center;">
                <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: #fff; font-size: 32px;">
                    <i class="fas fa-user"></i>
                </div>
                <h4 style="color: #333; margin-bottom: 10px;">علی احمدی</h4>
                <p style="color: #667eea; margin-bottom: 15px;">مدیرعامل</p>
                <p style="color: #666; font-size: 14px;">
                    بیش از 10 سال تجربه در صنعت فناوری و گیمینگ
                </p>
            </div>
            
            <div style="background: #fff; border-radius: 15px; padding: 30px; box-shadow: 0 5px 25px rgba(0,0,0,0.1); text-align: center;">
                <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #51cf66 0%, #40c057 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: #fff; font-size: 32px;">
                    <i class="fas fa-user"></i>
                </div>
                <h4 style="color: #333; margin-bottom: 10px;">مریم کریمی</h4>
                <p style="color: #51cf66; margin-bottom: 15px;">مدیر فروش</p>
                <p style="color: #666; font-size: 14px;">
                    متخصص در ارائه بهترین راهکارهای فروش و خدمات مشتریان
                </p>
            </div>
            
            <div style="background: #fff; border-radius: 15px; padding: 30px; box-shadow: 0 5px 25px rgba(0,0,0,0.1); text-align: center;">
                <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: #fff; font-size: 32px;">
                    <i class="fas fa-user"></i>
                </div>
                <h4 style="color: #333; margin-bottom: 10px;">حسین رضایی</h4>
                <p style="color: #ff6b6b; margin-bottom: 15px;">مدیر فنی</p>
                <p style="color: #666; font-size: 14px;">
                    کارشناس ارشد کامپیوتر و متخصص سخت‌افزار گیمینگ
                </p>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px; padding: 50px 30px; text-align: center; color: #fff;">
        <h3 style="font-size: 28px; margin-bottom: 20px;">آماده‌اید تجربه گیمینگ خود را ارتقا دهید؟</h3>
        <p style="font-size: 18px; margin-bottom: 30px; opacity: 0.9;">
            بهترین محصولات گیمینگ را از ما تهیه کنید و از تجربه‌ای بی‌نظیر لذت ببرید.
        </p>
        <a href="products.php" class="btn" style="background: #fff; color: #667eea; padding: 15px 30px; font-size: 18px;">
            <i class="fas fa-shopping-bag"></i> شروع خرید
        </a>
    </div>
</div>

<style>
@media (max-width: 768px) {
    .container > div[style*="grid-template-columns: 1fr 1fr"] {
        display: block !important;
    }
    
    .section-title h2 {
        font-size: 28px !important;
    }
    
    .hero-section h2 {
        font-size: 28px !important;
    }
}
</style>

<?php require_once 'includes/footer.php'; ?>