# 🛒 BNG Shop - فروشگاه گیفت کارت و محصولات دیجیتالی

فروشگاه آنلاین مدرن و کامل برای فروش گیفت کارت، پرداخت‌های درون برنامه‌ای و محصولات دیجیتال

## ✨ ویژگی‌ها

### 🎯 **محصولات و خدمات**
- 🎮 گیفت کارت‌های مختلف (Steam, Google Play, PlayStation, Xbox و...)
- 📱 پرداخت‌های درون برنامه‌ای (PUBG UC, Free Fire, Clash of Clans و...)
- 🎪 اکانت‌های پریمیوم (Netflix, Spotify, YouTube Premium)
- 💻 بازی‌های PC و کنسول
- ☁️ خدمات آنلاین (VPN, آنتی‌ویروس)

### 🚀 **ویژگی‌های فنی**
- **اسلایدر تصاویر** جذاب در صفحه اصلی
- **مگا منوی 4 ستونه** برای دسته‌بندی محصولات
- **طراحی ریسپانسیو** و موبایل فرندلی
- **سیستم پرداخت زرین‌پال** کاملاً عملکرد
- **پنل مدیریت** کامل و حرفه‌ای
- **سیستم سبد خرید** Ajax-based
- **تحویل فوری** محصولات دیجیتال

### 🔒 **امنیت**
- **CSRF Protection** پیشرفته
- **SQL Injection Prevention** با PDO
- **Password Hashing** با bcrypt
- **Session Management** امن
- **Input Validation** کامل

## 📋 **مشخصات فنی**

### 🛠️ **تکنولوژی‌ها**
- **Backend:** PHP 7.4+ / MySQL
- **Frontend:** HTML5, CSS3, JavaScript
- **Framework CSS:** Custom RTL Design
- **Icons:** Font Awesome 6.4
- **Fonts:** Vazir Persian Font

### 📦 **نیازمندی‌ها**
- PHP 7.4 یا بالاتر
- MySQL 5.7 یا بالاتر
- Apache/Nginx وب سرور
- mod_rewrite فعال
- cURL Extension
- PDO MySQL Extension

## 🚀 **نصب و راه‌اندازی**

### 1️⃣ **آپلود فایل‌ها**
```bash
# آپلود تمام فایل‌ها به public_html/
# یا ساب‌فولدر مورد نظر
```

### 2️⃣ **تنظیم دیتابیس**
```bash
# 1. دیتابیس جدید بسازید
# 2. فایل database/schema.sql را import کنید
# 3. اطلاعات دیتابیس را در config/database.php وارد کنید
```

### 3️⃣ **تنظیم مجوزها**
```bash
chmod 755 uploads/
chmod 644 *.php
chmod 644 assets/css/*.css
chmod 644 assets/js/*.js
```

### 4️⃣ **تنظیم درگاه پرداخت**
```php
// در config/config.php
define('ZARINPAL_MERCHANT', 'YOUR_MERCHANT_ID');
```

## 📊 **ساختار دیتابیس**

### 🗃️ **جداول اصلی**
- **users** - کاربران و ادمین‌ها
- **categories** - دسته‌بندی محصولات
- **products** - محصولات دیجیتال
- **cart** - سبد خرید کاربران
- **orders** - سفارشات و پرداخت‌ها
- **order_items** - آیتم‌های سفارش
- **payment_logs** - لاگ پرداخت‌ها

## 🎨 **طراحی و UI/UX**

### 🌟 **ویژگی‌های طراحی**
- **RTL Support** کامل برای فارسی
- **Dark/Light Theme** سازگار
- **Mobile First** طراحی
- **Modern CSS Grid** و Flexbox
- **Smooth Animations** و Transitions
- **Loading States** و Micro-interactions

### 📱 **ریسپانسیو**
- Desktop: 1200px+
- Tablet: 768px - 1199px
- Mobile: 320px - 767px

## 🔧 **تنظیمات پیشرفته**

### ⚙️ **فایل‌های کانفیگ**
```
config/
├── config.php      # تنظیمات اصلی سایت
├── database.php    # اتصال دیتابیس
└── .htaccess       # تنظیمات Apache
```

### 🛡️ **امنیت**
- HTTPS اجباری
- SQL Injection محافظت
- XSS Prevention
- CSRF Token Validation
- Session Hijacking Prevention

## 📈 **عملکرد**

### ⚡ **بهینه‌سازی**
- **CSS/JS Minification** آماده
- **Image Optimization** پشتیبانی
- **Browser Caching** تنظیم شده
- **Database Indexing** بهینه
- **Lazy Loading** برای تصاویر

## 🎯 **اطلاعات تماس**

### 📞 **پشتیبانی**
- **تلفن:** 09352233616
- **ایمیل:** bngshop@gmail.com
- **ادمین:** masiha1380@bngshop.ir
- **ساعت کاری:** 10 صبح تا 11 شب

### 🌐 **لینک‌ها**
- **سایت:** [bngshop.ir](https://bngshop.ir)
- **زرین‌پال:** [zarinp.al/masiha](https://zarinp.al/masiha)

## 📝 **مجوز**

این پروژه تحت مجوز MIT منتشر شده است.

## 🤝 **مشارکت**

برای مشارکت در این پروژه:
1. Fork کنید
2. Branch جدید بسازید
3. تغییرات خود را commit کنید
4. Pull Request ارسال کنید

---

**ساخته شده با ❤️ برای BNG Shop**