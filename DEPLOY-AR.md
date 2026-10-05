# طريقة رفع مشروع FoodKing على سيرفر مجاني 🚀

## أولاً: تعريف بالمشروع
- المشروع: تطبيق لارافيل **Laravel 12** (مطعم / طلبات أكل) مع واجهة **Vue 3 + Vite**.
- يتطلب: **PHP 8.2+**، **MySQL**، **Composer**، **Node.js/NPM**.
- لا يوجد SQLite جاهز هنا، القاعدة الأساسية MySQL.

---

## الخيار الأول: استضافة مجانية عادية (InfinityFree / AwardSpace) — الأسهل

> ملاحظة: قد لا تدعم هذه الاستضافات أوامر SSH بشكل كامل، لذلك نجهّز كل شيء محلياً ثم نرفع الملفات.

### 1) تجهيز المشروع محلياً قبل الرفع
```bash
cd E:\foodking\foodking
composer install --optimize-autoloader --no-dev
npm install
npm run build
```
- تأكد أن مجلد `public/build` اتعمل بعد `npm run build`.
- جهّز ملف `.env` للسيرفر (شرحه في خطوة 4).

### 2) إنشاء حساب واستضافة مجانية
1. ادخل على موقع مثل **InfinityFree.com** وسجّل حساب مجاني.
2. أنشئ استضافة جديدة واختر **PHP 8.2 أو أحدث** إن أمكن.
3. من لوحة التحكم افتح **MySQL Databases** وأنشئ قاعدة بيانات، واحفظ:
   - اسم قاعدة البيانات
   - اسم المستخدم
   - كلمة المرور
   - Host (غالباً شيء مثل `sqlXXX.infinityfree.com`)

### 3) رفع الملفات
1. افتح **File Manager** من لوحة التحكم أو استخدم **FileZilla**.
2. ارفع **كل ملفات المشروع** (عدا `node_modules` و `vendor` لو هتتثبتهم على السيرفر بالـ SSH — الأفضل ترفع `vendor` كاملة) إلى مجلد `htdocs` أو `public_html`.
3. **مهم جداً**: مجلد `public` الخاص بلارافيل لازم يكون هو جذر الموقع. طريقتان:
   - الأفضل: خلي مجلد `public` هو الـ document root من إعدادات الموقع لو الاستضافة تتيح.
   - أو انقل محتويات `public` داخل `htdocs` وعدّل مسار `../vendor/autoload.php` و `../bootstrap/app.php` داخل `index.php` و `artisan` بتاع `htdocs`.

### 4) ملف `.env` على السيرفر
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.infinityfreeapp.com

DB_CONNECTION=mysql
DB_HOST=sqlXXX.infinityfree.com
DB_PORT=3306
DB_DATABASE=epiz_xxxxxx_foodking
DB_USERNAME=epiz_xxxxxx
DB_PASSWORD=********

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=local
MEDIA_DISK=public
```
ثم نفّذ (من SSH لو متاح أو Terminal في File Manager):
```bash
php artisan key:generate
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
> لو مفيش SSH: ممكن تنفّذ الـ migrations محلياً بعد تعديل `.env` لقاعدة السيرفر البعيدة (لو الاستضافة تسمح باتصال خارجي)، أو تستخدم أداة مثل **phpMyAdmin** لاستيراد القاعدة بعد تصديرها محلياً:
> ```bash
> php artisan migrate
> # ثم صدّر قاعدة البيانات من phpMyAdmin المحلي وارفعها على السيرفر
> ```

### 5) تصاريح المجلدات
```bash
chmod -R 775 storage bootstrap/cache
```

### 6) افتح الموقع
- جرّب `https://your-domain.infinityfreeapp.com`
- لو ظهر خطأ 500: افتح `storage/logs/laravel.log` وشوف السبب، وغالباً مشكلة صلاحيات أو قاعدة البيانات أو إصدار PHP أقل من 8.2.

---

## الخيار الثاني: Render.com (يدعم Docker/Dockerfile)

المميزات: يدعم Laravel كامل، لكن الخدمة المجانية تنام بعد عدم الاستخدام.

### 1) ارفع المشروع على GitHub
```bash
git init
git add .
git commit -m "first commit"
git remote add origin https://github.com/USERNAME/foodking.git
git push -u origin main
```

### 2) أنشئ قاعدة MySQL مجانية
- من **Railway.app** أو **Aiven** أو **PlanetScale** (خطة مجانية) واحصل على بيانات الاتصال.

### 3) أنشئ `Dockerfile` في جذر المشروع
```dockerfile
FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip git curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --optimize-autoloader --no-dev
RUN npm install && npm run build   # (يتطلب تثبيت node داخل الصورة، انظر Dockerfile موسع)

RUN chown -R www-data:www-data storage bootstrap/cache
RUN a2enmod rewrite

# عدّل DocumentRoot ليشير إلى public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80
CMD ["apache2-foreground"]
```
> نسخة جاهزة ومجربة أكتر: استخدم صورة على Docker Hub مثل `serversideup/php:8.2-apache`.

### 4) على Render
1. New → **Web Service** → اربط مستودع GitHub.
2. اختر **Docker**.
3. ضيف Environment Variables: `APP_ENV=production`, `APP_DEBUG=false`, `APP_KEY=...` (نتجه محلياً بـ `php artisan key:generate --show`), `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, `APP_URL`.
4. Deploy وانتظر البناء. بعدها افتح الرابط المُعطى.

> البديل الأسهل: **Railway.app** تعطي رصيد مجاني شهري وتشغل Laravel مباشرة مع MySQL بزر واحد.

---

## الخيار الثالث: سيرفر VPS مجاني (Oracle Cloud Always Free) — الأقوى
Oracle Cloud تعطي Ubuntu VPS مجاناً للأبد (ARM). خطوات مختصرة:
```bash
sudo apt update && sudo apt install -y nginx php8.2-fpm php8.2-mysql php8.2-mbstring php8.2-xml php8.2-curl php8.2-zip composer nodejs npm mysql-server

cd /var/www
git clone https://github.com/USERNAME/foodking.git
cd foodking
composer install --optimize-autoloader --no-dev
npm install && npm run build
cp .env.example .env
nano .env   # بيانات القاعدة
php artisan key:generate
php artisan migrate --force
php artisan storage:link
sudo chown -R www-data:www-data storage bootstrap/cache

# ثم وجّه Nginx إلى مجلد public وحدد PHP-FPM في server block
```

---

## نصائح مهمة قبل أي رفع ✅
1. **لا ترفع `node_modules`** أبداً للسيرفر.
2. شغّل `npm run build` محلياً وارفع مجلد `public/build`.
3. `APP_DEBUG=false` و `APP_ENV=production` في الإنتاج.
4. PHP المطلوب: **8.2 أو أعلى** (لأن Laravel 12).
5. أنشئ نسخة احتياطية من `.env` وقاعدة البيانات.
6. جداول البيانات وإعدادات bKash/PayPal الخ.. محتاجة مفاتيح API في `.env` — فعّلها لاحقاً.
7. إن واجهت خطأ في `bootstrap/cache` أو `storage` فعّل التصاريح: `chmod -R 775 storage bootstrap/cache`.

---

## ملخص سريع (لو مش عارف تختار)
| الاحتياج | الخيار |
|---|---|
| أبسط حل مجاني تمامًا | InfinityFree |
| Laravel كامل مع Docker | Render / Railway |
| تحكم كامل ومجاني دائمًا | Oracle Cloud Free VPS |
