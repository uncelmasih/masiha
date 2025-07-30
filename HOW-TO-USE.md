# 🎮 راهنمای استفاده از سیستم ثبت نام

## ✅ مشکل ثبت نام حل شد!

سیستم ثبت نام اکنون کاملاً کار می‌کند و نیازی به دیتابیس MySQL ندارد.

## 🚀 نحوه استفاده:

### 1️⃣ **ثبت نام جدید:**
- برو به: `register-simple.php`
- اطلاعات خود را پر کن
- روی "ثبت نام" کلیک کن

### 2️⃣ **ورود:**
- برو به: `login-simple.php`  
- نام کاربری/ایمیل و رمز عبور را وارد کن
- روی "ورود" کلیک کن

### 3️⃣ **مشاهده اطلاعات:**
- پس از ورود، به صفحه `dashboard-simple.php` هدایت می‌شوی
- همه اطلاعات حساب کاربری نمایش داده می‌شود

## 🔧 ویژگی‌های سیستم:

### ✨ **امنیت:**
- ✅ رمز عبور هش شده (password_hash)
- ✅ محافظت CSRF فعال
- ✅ اعتبارسنجی سمت کلاینت و سرور
- ✅ Sanitization داده‌ها

### 📱 **طراحی:**
- ✅ کاملاً ریسپانسیو 
- ✅ طراحی زیبا و مدرن
- ✅ انیمیشن‌های نرم
- ✅ Glass morphism effect

### 💾 **ذخیره‌سازی:**
- ✅ بدون نیاز به MySQL
- ✅ ذخیره در فایل JSON
- ✅ ایجاد خودکار پوشه users
- ✅ UTF-8 encoding برای فارسی

## 📂 فایل‌های اصلی:

```
register-simple.php  ← صفحه ثبت نام
login-simple.php     ← صفحه ورود  
dashboard-simple.php ← داشبورد کاربر
users/users.json     ← فایل ذخیره کاربران (خودکار ایجاد می‌شود)
```

## 🌐 لینک‌های مستقیم:

### 📁 **GitHub Repository:**
https://github.com/uncelmasih/masiha

### 🌿 **برنچ با تغییرات جدید:**
https://github.com/uncelmasih/masiha/tree/cursor/upload-mobile-css-and-fix-registration-9e3c

### 📋 **فایل‌های کلیدی:**
- [register-simple.php](https://github.com/uncelmasih/masiha/blob/cursor/upload-mobile-css-and-fix-registration-9e3c/register-simple.php)
- [login-simple.php](https://github.com/uncelmasih/masiha/blob/cursor/upload-mobile-css-and-fix-registration-9e3c/login-simple.php)  
- [dashboard-simple.php](https://github.com/uncelmasih/masiha/blob/cursor/upload-mobile-css-and-fix-registration-9e3c/dashboard-simple.php)

## 🔧 نصب و راه‌اندازی:

### روش 1: سرور محلی
```bash
# دانلود فایل‌ها از GitHub
git clone https://github.com/uncelmasih/masiha.git
cd masiha
git checkout cursor/upload-mobile-css-and-fix-registration-9e3c

# اجرا با PHP built-in server
php -S localhost:8000

# برو به:
http://localhost:8000/register-simple.php
```

### روش 2: XAMPP/WAMP
1. فایل‌ها را در `htdocs` کپی کن
2. برو به `http://localhost/masiha/register-simple.php`

### روش 3: سرور آنلاین
1. فایل‌ها را آپلود کن
2. مطمئن شو PHP 7.4+ فعال باشد
3. برو به `yoursite.com/register-simple.php`

## 📱 تست موبایل:

سیستم کاملاً روی موبایل کار می‌کند:
- ✅ نوار ناوبری اسکرول می‌شود
- ✅ فرم‌ها ریسپانسیو هستند  
- ✅ دکمه‌ها قابل لمس
- ✅ اعلان‌ها موقعیت درست دارند

## 🎯 نکات مهم:

1. **مجوزها:** مطمئن شو پوشه writable باشد
2. **PHP:** نسخه 7.4 یا بالاتر
3. **Session:** PHP sessions فعال باشد
4. **Encoding:** UTF-8 برای فارسی

## 🆘 عیب‌یابی:

### اگر ثبت نام کار نمی‌کند:
```php
// چک کن که PHP sessions کار می‌کند
<?php 
session_start();
echo "Session ID: " . session_id();
?>
```

### اگر فایل ذخیره نمی‌شود:
```bash
# مجوزها را چک کن
chmod 755 .
mkdir users
chmod 777 users
```

---

## 🎉 **ثبت نام اکنون کاملاً کار می‌کند!**

برای تست، برو به `register-simple.php` و یک حساب بساز! 🚀