# KVS Website — Project Context (Handoff)

> ملف تسليم لأي سيشن Claude جديدة تشتغل على المشروع ده. اقرأه هو وباقي ملفات project-docs/ الأول.

## المشروع
موقع تسويقي لمدرسة Knowledge Valley International School (KVS) — مدرسة بريطانية انترناشونال في الجيزة.
الهدف: الظهور بمستوى بريستيج عالي + توليد ليدز (أولياء أمور يسيبوا بياناتهم).

## الستاك
- Laravel 12 (PHP 8.2) + Blade + Tailwind CSS v4 (Vite)
- Fonts: Playfair Display (عناوين) + Inter (نصوص) — self-hosted عبر fontsource
- الهوية: Deep Maroon / Rich Gold / Ivory — كل الـ tokens في resources/css/app.css
- لوحة أدمن مبنية يدويًا (بدون Filament — لأن بيئة العمل الأولى كانت مقفولة عن Packagist)

## الحالة الحالية (تم إنجازه)
1. **16 صفحة كاملة**: home, about, leadership, accreditations, academics + 3 stage pages,
   admissions, book-a-tour, fees (بوابة ليدز), faqs, school-life, services, contact, careers.
2. **نظام صور تلقائي**: helpers في app/Support/helpers.php — كل سكشن بيقرأ صوره من
   public/images/<اسم الفولدر> (الأسماء الفعلية عند العميل: "A Valley of Character-Building",
   "Find Your Child's Place at KVS", "Life at KVS", "a ward from our leader", "accreditations", "lOGOS").
   الترتيب أبجدي — أول صورة في فولدر Valley هي خلفية الهيرو.
3. **Marquee متحرك** لشعارات الاعتمادات (partials/trust-marquee.blade.php) — بيقرأ فولدر accreditations تلقائيًا.
4. **نظام الليدز شغال live**: 4 فورمات (هوم callback / book-a-tour / fees / careers) بتسجل في الداتابيز
   مع honeypot + rate limiting. لوحة أدمن على /admin (auth يدوي): Dashboard + Leads pipeline
   (new→contacted→tour_booked→toured→applied→enrolled/lost) + فلترة/بحث/ملاحظات/CSV export
   + Career applications مع تحميل CV + Change password.
5. **منشور أونلاين على Cloudways** (phpstack-1216096-6562999.cloudwaysapps.com حاليًا).
   SESSION_DRIVER=file و CACHE_STORE=file علشان الموقع ميعتمدش على الداتابيز في العرض.
   أدمن: /admin — يوزر admin@kvs.edu.eg (الباسورد اتغير عند العميل).

## قرارات متفق عليها
- CTA الملك: Book a School Tour (هيدر + موبايل sticky bar + كل الصفحات)
- المصاريف: بوابة "Get Fees" بفورم (مش معروضة علنًا) — مغناطيس ليدز
- واتساب/تليفون الأدمشن: 01277771119
- "Since 2008" مؤقتًا — في تناقض 2007/2008 محتاج حسم من إدارة المدرسة

## المتبقي (Roadmap)
1. **النسخة العربية RTL** (اتفقنا إنجليزي أساسي + عربي كامل — لسه متنفذتش)
2. نصوص رسائل القيادة الحقيقية (الحالية placeholder) + testimonials حقيقية + أرقام حقيقية للـ counters
3. CMS للأحداث/الأخبار من الداشبورد (فولدر "Latest News" عند العميل مستني السكشن ده)
4. إشعار إيميل/واتساب عند وصول ليد جديد + UTM tracking للإعلانات
5. SEO: sitemap.xml, robots.txt, Open Graph, structured data
6. ضغط صور العميل (كبيرة) وتحويلها WebP

## ملاحظات تشغيل مهمة
- بعد أي تعديل CSS/JS: npm run build (فولدر public/build لازم يترفع للسيرفر)
- بعد إضافة ملفات PHP جديدة في composer.json: composer dump-autoload
- الميجريشنز فيها حماية hasTable ضد partial runs
- ملفات المرجع: 01-brand-brief.md / 02-old-site-analysis.md / 03-competitor-research.md / 04-proposed-structure.md
