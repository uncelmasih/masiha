# 🎮 فروشگاه گیمینگ استور

فروشگاه آنلاین محصولات گیمینگ با PHP و MySQL

## ✨ ویژگی‌ها

### 🔐 امنیت
- محافظت CSRF
- Hash کردن رمز عبور با bcrypt
- Session management امن
- Validation و sanitization ورودی‌ها
- فایل .htaccess برای امنیت

### 🛒 فروشگاه
- نمایش محصولات با تصاویر
- دسته‌بندی محصولات
- جستجو و فیلتر پیشرفته
- سبد خرید Ajax-based
- مدیریت موجودی
- محاسبه تخفیف و هزینه ارسال

### 👤 مدیریت کاربران
- ثبت نام و ورود
- پنل کاربری
- سیستم نقش‌ها (Admin/User)

### 📱 رابط کاربری
- طراحی Responsive
- زیبا و مدرن
- پشتیبانی از RTL
- انیمیشن‌ها و Effects

## 🚀 راه‌اندازی

### پیش‌نیازها
- PHP 7.4+
- MySQL 5.7+
- Apache/Nginx
- PDO MySQL extension

### مراحل نصب

1. **کپی فایل‌ها**
```bash
# فایل‌ها را در دایرکتوری وب سرور کپی کنید
cp -r * /var/www/html/gaming-store/
```

2. **ایجاد دیتابیس**
```sql
CREATE DATABASE gaming_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

3. **تنظیم دیتابیس**
فایل `config/database.php` را ویرایش کنید:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'gaming_store');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
```

4. **تنظیم کانفیگ**
فایل `config/config.php` را ویرایش کنید:
```php
define('SITE_URL', 'http://your-domain.com');
define('SITE_NAME', 'گیمینگ استور');
define('ADMIN_EMAIL', 'admin@your-domain.com');
```

5. **اجرای Setup**
```
http://your-domain.com/setup.php
```

6. **حذف فایل Setup** (اختیاری)
```bash
rm setup.php
```

## 📂 ساختار فایل‌ها

```
gaming-store/
├── config/                 # فایل‌های تنظیمات
│   ├── config.php          # تنظیمات اصلی
│   └── database.php        # اتصال دیتابیس
├── database/               # فایل‌های دیتابیس
│   └── schema.sql          # ساختار جداول
├── includes/               # فایل‌های include
│   ├── header.php          # هدر سایت
│   └── footer.php          # فوتر سایت
├── assets/                 # منابع استاتیک
│   ├── css/                # فایل‌های CSS
│   └── js/                 # فایل‌های JavaScript
├── uploads/                # فایل‌های آپلود شده
│   ├── products/           # تصاویر محصولات
│   ├── categories/         # تصاویر دسته‌ها
│   └── users/              # تصاویر کاربران
├── index.php               # صفحه اصلی
├── products.php            # لیست محصولات
├── product.php             # جزئیات محصول
├── cart.php                # سبد خرید
├── login.php               # ورود
├── register.php            # ثبت نام
├── contact.php             # تماس با ما
├── about.php               # درباره ما
└── setup.php               # راه‌اندازی اولیه
```

## 👥 کاربران پیش‌فرض

پس از راه‌اندازی، کاربر مدیر زیر ایجاد می‌شود:

- **ایمیل:** admin@gaming-store.com
- **رمز عبور:** admin123

⚠️ **هشدار امنیتی:** حتماً رمز عبور مدیر را تغییر دهید!

## 🔧 تنظیمات پیشرفته

### تنظیم Timezone
```php
// در config/config.php
date_default_timezone_set('Asia/Tehran');
```

### تنظیم حجم آپلود
```php
// در config/config.php
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
```

### تنظیم ارسال رایگان
```php
// در cart.php خط 32
$shipping_cost = $subtotal >= 2000000 ? 0 : 50000;
```

## 🎨 سفارشی‌سازی

### تغییر رنگ‌ها
فایل `assets/css/style.css` را ویرایش کنید:
```css
:root {
    --primary-color: #667eea;
    --secondary-color: #764ba2;
    --accent-color: #ff6b6b;
}
```

### اضافه کردن دسته‌بندی جدید
```sql
INSERT INTO categories (name, description) VALUES ('دسته جدید', 'توضیحات');
```

### اضافه کردن محصول جدید
```sql
INSERT INTO products (name, description, price, category_id, brand, stock_quantity) 
VALUES ('محصول جدید', 'توضیحات', 1000000, 1, 'برند', 10);
```

## 🛡️ امنیت

### توصیه‌های امنیتی
1. همیشه از HTTPS استفاده کنید
2. رمزهای عبور قوی انتخاب کنید
3. به‌روزرسانی‌های PHP را نصب کنید
4. دسترسی‌های فایل‌ها را محدود کنید
5. Backup منظم تهیه کنید

### فایل .htaccess
```apache
# امنیت اضافی
<Files "*.sql">
    Require all denied
</Files>

<Files "config.php">
    Require all denied
</Files>
```

## 🐛 عیب‌یابی

### مشکلات متداول

**خطای اتصال دیتابیس:**
- اطلاعات دیتابیس را بررسی کنید
- مطمئن شوید MySQL در حال اجرا است

**تصاویر نمایش داده نمی‌شوند:**
- مجوزهای پوشه uploads را بررسی کنید
- مسیر فایل‌ها را چک کنید

**صفحه سفید:**
- error_log PHP را بررسی کنید
- display_errors را فعال کنید

## 📚 منابع اضافی

- [مستندات PHP](https://www.php.net/docs.php)
- [راهنمای MySQL](https://dev.mysql.com/doc/)
- [آموزش PDO](https://www.php.net/manual/en/book.pdo.php)

## 🤝 مشارکت

برای مشارکت در پروژه:
1. Fork کنید
2. تغییرات خود را اعمال کنید
3. Pull Request ارسال کنید

## 📞 پشتیبانی

برای سوالات و پشتیبانی:
- ایمیل: support@gaming-store.com
- تلفن: 021-12345678

## 📄 مجوز

این پروژه تحت مجوز MIT منتشر شده است.

---

**نکته:** این یک پروژه آموزشی است. برای استفاده در محیط production، تست‌ها و بهینه‌سازی‌های اضافی انجام دهید.