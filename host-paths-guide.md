# 📂 راهنمای مسیر قرار دادن فایل‌ها

## هاست‌های مختلف و مسیرهایشان:

### 🌟 **هاست‌های ایرانی محبوب:**

#### **پارس پک (Parspack):**
```
/home/username/public_html/
```

#### **ایران سرور:**
```
/home/username/domains/yoursite.com/public_html/
```

#### **آسیاتک:**
```
/home/username/public_html/
```

#### **رایانه کوثر:**
```
/home/username/public_html/
```

### 🌍 **هاست‌های بین‌المللی:**

#### **cPanel استандارد:**
```
/home/username/public_html/
```

#### **DirectAdmin:**
```
/home/username/domains/yoursite.com/public_html/
```

#### **Plesk:**
```
/var/www/vhosts/yoursite.com/httpdocs/
```

## 🎯 **سناریوهای مختلف:**

### سناریو 1: سایت اصلی
```
yoursite.com → public_html/index.php
```

### سناریو 2: زیر مجموعه
```
yoursite.com/shop → public_html/shop/index.php
```

### سناریو 3: ساب دامین
```
shop.yoursite.com → public_html/subdomains/shop/index.php
```

## ⚙️ **تنظیمات SITE_URL:**

### برای سایت اصلی:
```php
define('SITE_URL', 'https://yoursite.com');
```

### برای زیر پوشه:
```php
define('SITE_URL', 'https://yoursite.com/shop');
```

### برای ساب دامین:
```php
define('SITE_URL', 'https://shop.yoursite.com');
```