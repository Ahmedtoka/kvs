# تشغيل مشروع KVS على جهازك (XAMPP)

## المتطلبات
- PHP 8.2 أو أحدث (شغّل `php -v` من الـ CMD — لو أقل من 8.2 حدّث الـ XAMPP)
- Composer مسطب (https://getcomposer.org)
- Node.js 20+ (https://nodejs.org) — للـ Tailwind فقط

## الخطوات (مرة واحدة)
افتح CMD جوه فولدر المشروع `C:\xampp\htdocs\Kvs` ونفّذ:

```bash
composer install
copy .env.example .env
php artisan key:generate
npm install
npm run build
```

## التشغيل
```bash
php artisan serve
```
وافتح: http://127.0.0.1:8000

> **ملاحظة:** الأسهل تستخدم `php artisan serve` بدل ما تفتح المشروع من Apache بتاع XAMPP —
> لو عايز تشغله من Apache لازم توجّه الـ DocumentRoot على فولدر `public` جوه المشروع.

## أثناء التطوير (اختياري)
بدل `npm run build` شغّل `npm run dev` في نافذة تانية علشان الـ hot reload.

## قاعدة البيانات (هنحتاجها في مرحلة الداشبورد)
- افتح phpMyAdmin واعمل database اسمها `kvs`
- في ملف `.env` ظبط: `DB_DATABASE=kvs` و`DB_USERNAME=root` و`DB_PASSWORD=` (فاضية افتراضيًا في XAMPP)
- بعدين `php artisan migrate`

## فين أعدّل ايه؟
- الصفحة الرئيسية: `resources/views/home.blade.php`
- الألوان والخطوط (نظام التصميم): `resources/css/app.css`
- الجافاسكريبت: `resources/js/app.js`
- الصور: `public/images/` — استبدل ملفات `placeholders/` بالصور الحقيقية بنفس الأسماء
