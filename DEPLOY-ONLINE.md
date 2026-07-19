# نشر KVS أونلاين + تشغيل لوحة الأدمن

## 1) إصلاح إيرور الداتابيز الحالي (Access denied)

المشكلة إن بيانات الداتابيز في ملف `.env` على الاستضافة غلط. افتح `.env` وظبط:

```env
APP_ENV=production
APP_DEBUG=false          # مهم جدًا أونلاين — يمنع ظهور تفاصيل الأخطاء للزوار
APP_URL=https://yourdomain.com

# خلي الموقع نفسه ميعتمدش على الداتابيز في الجلسات والكاش:
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync

# بيانات الداتابيز — خدها بالظبط من لوحة الاستضافة (cPanel → MySQL Databases):
DB_CONNECTION=mysql
DB_HOST=localhost        # جرب localhost الأول — أغلب الاستضافات المشتركة بتشتغل بيه مش 127.0.0.1
DB_PORT=3306
DB_DATABASE=اسم_الداتابيز_من_السي_بانل
DB_USERNAME=اليوزر_من_السي_بانل
DB_PASSWORD=الباسورد_الصحيح
```

> ملحوظة: في cPanel لازم تتأكد إن اليوزر متضاف على الداتابيز بصلاحيات ALL PRIVILEGES
> (MySQL Databases → Add User To Database).

بعد التعديل نفّذ:
```bash
php artisan config:clear
php artisan migrate
php artisan db:seed --class=AdminUserSeeder
```

## 2) لوحة الأدمن

- **اللينك:** `https://yourdomain.com/admin`
- **الإيميل:** `admin@kvs.edu.eg`
- **الباسورد:** `KVS@Admin2026`

> ⚠️ أول ما تدخل غيّر الباسورد من صفحة **Change Password** في القائمة الجانبية.
> (تقدر كمان تحدد إيميل/باسورد مختلفين قبل تشغيل الـ seeder بإضافة
> `ADMIN_EMAIL=...` و `ADMIN_PASSWORD=...` في `.env`)

الموقع نفسه بيفتح عادي لأي زائر بدون أي لوجين — اللوجين على `/admin` بس.

## 3) اللي اتضاف في النسخة دي

- كل الفورمات بقت حقيقية وبتسجل في الداتابيز:
  - فورم الهوم (Request a Call Back) → ليد نوع Call Back
  - فورم Book a Tour → ليد نوع School Tour
  - فورم Get Fees → ليد نوع Fees Request
  - فورم التوظيف → Career Application مع رفع الـ CV
- حماية: honeypot ضد السبام + rate limiting + CSRF
- لوحة أدمن: Dashboard بالإحصائيات والـ pipeline · إدارة Leads (فلترة/بحث/تغيير حالة/ملاحظات/حذف/تصدير CSV/زرار واتساب لكل ليد) · طلبات التوظيف مع تحميل الـ CV · تغيير الباسورد

## 4) خطوات الرفع (لما تحدّث الملفات)

1. ارفع الملفات الجديدة مكان القديمة (من غير ما تلمس `.env` بتاع السيرفر ولا فولدر صورك)
2. `composer install` (أو update لو composer.json اتغير) ثم `composer dump-autoload`
3. `php artisan migrate` (بيضيف جداول leads و career_applications)
4. `php artisan db:seed --class=AdminUserSeeder` (مرة واحدة بس)
5. `php artisan config:clear && php artisan view:clear`
- فولدر `public/build` مبني جاهز وموجود في الزيب — مش محتاج npm على السيرفر.
