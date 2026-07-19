# مشروع KVS — التوثيق الكامل

> **آخر تحديث:** 2026-07-16 (النسخة الموسعة — Multi-page + Funnel + Tracking)
> ملف مرجعي بكل تفاصيل المشروع — يتحدّث مع أي تغيير جوهري.

---

## 1. نظرة عامة

موقع ويب متكامل لمدرسة **Knowledge Valley International School (KVS)** — مدرسة بريطانية دولية في الجيزة، مصر (صفت اللبن، كرداسة). تأسست 2008.

**الوضع الحالي:** موقع تسويقي كامل من **24 صفحة** مبني على فانل واضح (Awareness → Interest → Desire → Action) + نظام إيفنتات وأخبار من الداتابيز + **نظام تراكينج داخلي** لسلوك الزوار + داشبورد أدمن (Leads + Analytics).

## 2. التقنيات

| المكوّن | الإصدار |
|---|---|
| PHP / Laravel | ^8.2 / ^12.0 (شغال فعليًا على 12.64.0) |
| Tailwind CSS / Vite | v4 / ^8 — التوكنز في `resources/css/app.css` |
| الخطوط | Playfair Display (عناوين) + Inter (نصوص) |
| قاعدة البيانات | MySQL — داتابيز `kvs` على XAMPP |
| التراكينج | داخلي (جدول `tracking_events`) + جاهزية GA4 (`GA4_MEASUREMENT_ID` في .env) |

## 3. خريطة الموقع (24 صفحة)

**الفانل:** كل الصفحات فيها CTA Band ثابت في الآخر → `/book-tour` (صفحة التحويل).

| القسم | الصفحات |
|---|---|
| الرئيسية | `/` — هيرو + ترست بار باللوجوهات + مراحل + KVS Model + Why KVS + إيفنتات قادمة + جاليري + أخبار + آراء + خطوات القبول + الفورم. كل قسم فيه **See All** لصفحته |
| About | `/about` (القصة والرسالة) · `/about/leadership` (3 رسائل قيادة ديمو) · `/about/kvs-model` (الركائز الستة موسعة) · `/about/accreditations` (الاعتمادات بالتفصيل + اللوجوهات) |
| Academics | `/academics` (نظرة عامة) · `/academics/early-years` · `/academics/primary` · `/academics/secondary` · `/academics/languages` — صفحات المراحل فيها Overview + Curriculum Highlights + جدول يوم دراسي + لينك للمرحلة التالية (funnel chain) |
| Admissions | `/admissions` (الخطوات الأربعة) · `/admissions/how-to-apply` (الأوراق والتقييم) · `/admissions/fees` (جدول مصاريف **ديمو XX,XXX**) · `/admissions/faq` (8 أسئلة أكورديون) |
| التحويل | **`/book-tour`** — صفحة conversion كاملة بالفورم (بدون CTA band لتقليل التشتيت) |
| School Life | `/school-life` (أنشطة + مرافق) · `/school-life/smart-campus` (SPARE/Kashier) · `/gallery` (12 صورة) |
| ديناميكي | `/events` + `/events/{slug}` · `/news` + `/news/{slug}` — من الداتابيز |
| أخرى | `/careers` · `/contact` |

**الناف:** قوائم منسدلة (hover على الديسكتوب / أكورديون في الموبايل) — معرّفة في `partials/header.blade.php` (مصفوفة `$nav` واحدة سهلة التعديل).

## 4. نظام التراكينج (اللي بيخليك تشوف الزائر بيعمل إيه)

### إزاي بيشتغل
- **كوكي `kvs_vid`** (UUID، سنة) بيتحط لكل زائر — مجهول الهوية.
- **Pageviews بتتسجل سيرفر-سايد** عبر middleware `TrackPageViews` (مسجّل في `bootstrap/app.php`) — بيسجل الصفحة والريفيرر وutm_source/medium/campaign ونوع الجهاز.
- **أحداث السلوك بتتسجل من الجافاسكريبت** (`resources/js/app.js`) على endpoint `POST /track`:
  - `cta_click` — أي زرار عليه `data-track` (كل الأزرار الرئيسية معلّمة بـ label مميز زي `hero-book-tour`)
  - `see_all_click` — كل لينكات See All
  - `nav_click` — استخدام المنيو
  - `form_view` — الفورم ظهر على الشاشة / `form_submit` — اتبعت (بيتسجل كمان سيرفر-سايد للدقة)
  - `whatsapp_click` / `call_click` — أي ضغطة واتساب أو اتصال
  - `scroll_75` — الزائر وصل 75% من الصفحة
- الكل بيتخزن في جدول **`tracking_events`**.

### داشبورد الأناليتكس — `/admin/analytics`
- كروت: زوار اليوم / زوار 7 أيام / صفحات 7 أيام / Leads 7 أيام
- **الفانل (30 يوم):** زار الموقع ← استكشف Academics/Admissions ← شاف الفورم ← بعت طلب — بنِسَب التحويل بين كل خطوة
- زوار يوميًا (14 يوم، bar chart) · أكثر الصفحات زيارة · أكثر التفاعلات (CTAs/واتساب/اتصال) · مصادر الترافيك (Direct/Referral/UTM)
- **نصيحة إعلانات:** حط `?utm_source=facebook&utm_medium=cpc&utm_campaign=admissions` في لينكات الإعلانات وهتتفصل تلقائيًا

### GA4 (اختياري)
حط `GA4_MEASUREMENT_ID=G-XXXXXXXXXX` في `.env` → سكريبت gtag بيتفعّل تلقائيًا في الـ layout.

## 5. الداتابيز

| جدول | الوظيفة |
|---|---|
| `leads` | طلبات الفورم (parent_name, phone, child_age, stage, status: new→contacted→toured→enrolled/closed) |
| `events` | الإيفنتات (slug, excerpt, body, image, location, starts_at, ends_at, is_featured) |
| `posts` | الأخبار (slug, excerpt, body, image, published_at) |
| `tracking_events` | التراكينج (visitor_id, event, page, label, referrer, utm_*, device) |
| `users` | الأدمن — `admin@kvs.edu.eg` / `KVS@Admin2026` ⚠️ **غيّر الباسورد** |

**محتوى ديمو:** `DemoContentSeeder` بيزرع 6 إيفنتات (منها 2 قادمة featured) و6 أخبار — كلها معلّمة "DEMO" في النص علشان تتبدل بمحتوى حقيقي.

## 6. هيكل الملفات المهمة

```
app/
├── Http/Controllers/
│   ├── LeadController.php          # فورم الحجز + إيميل + تتبع form_submit
│   ├── EventController.php / NewsController.php
│   ├── TrackController.php         # POST /track (rate-limited 120/دقيقة)
│   └── Admin/ AuthController · LeadAdminController · AnalyticsController
├── Http/Middleware/TrackPageViews.php   # pageviews + كوكي الزائر
├── Mail/NewLeadReceived.php
└── Models/ User · Lead · Event · Post · TrackingEvent

resources/views/
├── layouts/site.blade.php          # الأساس لكل صفحات الموقع
├── partials/                       # topbar · header (الناف) · footer · floats
│   │                               # cta-band · page-hero · lead-form
│   └── event-card · news-card · accreditation-logos · stage-page
├── pages/                          # 19 صفحة ثابتة
├── events/ + news/                 # index + show
├── admin/ login · leads · analytics
└── emails/new-lead.blade.php

public/images/accreditations/       # 6 لوجوهات SVG (ديمو wordmarks — بدّلها بالرسمية بنفس الأسماء)
```

## 7. نظام التصميم

زي ما هو (maroon/gold/ivory + Playfair/Inter) — موثق في `resources/css/app.css`. المكونات: `btn-gold` / `btn-maroon` / `btn-outline-ivory` / `eyebrow` / `heading-serif` / `gold-rule` / `container-site` / `.reveal`.

## 8. أوامر التشغيل بعد آخر تحديث

```bash
php artisan migrate          # جداول events + posts + tracking_events الجديدة
php artisan db:seed          # الأدمن + المحتوى الديمو
npm run build                # استايلات الصفحات الجديدة
php artisan serve
```

## 9. الأدمن

- `/admin/login` → **Leads** (إدارة الطلبات) + **Analytics** (سلوك الزوار والفانل)
- بيانات الدخول في القسم 5 — غيّر الباسورد

## 10. المتبقي / TODO

- [ ] **(مواد من المدرسة)** استبدال صور الـ placeholders (~26 SVG) بصور حقيقية بنفس الأسماء
- [ ] **(مواد من المدرسة)** لوجوهات الاعتمادات الرسمية بدل الـ wordmarks الديمو (نفس الأسماء في `public/images/accreditations/`)
- [ ] **(مواد من المدرسة)** أرقام المصاريف الحقيقية في `/admissions/fees` + آراء أولياء أمور حقيقية + لينكات السوشيال
- [ ] استبدال محتوى الإيفنتات/الأخبار الديمو بمحتوى حقيقي (حاليًا من الـ seeder — التعديل من phpMyAdmin أو ننفذ CRUD)
- [ ] CRUD للإيفنتات والأخبار من الداشبورد (اتأجلت بقرار 2026-07-16)
- [ ] النسخة العربية RTL (مؤجلة بقرار 2026-07-16)
- [ ] بيانات SMTP في `.env` علشان إيميلات الـ leads تتبعت فعليًا (حاليًا log)
- [ ] GA4 ID لو هتستخدم إعلانات جوجل
- [ ] WhatsApp Business API للإشعارات (قرار/حساب من المدرسة)

## 11. بيانات التواصل المعتمدة

أدميشن: **0127 777 1119** (تليفون + واتساب) · مدرسة: 02 3722 1413 / 02 3722 1206 · admission@kvs.edu.eg · info@kvs.edu.eg · الأحد–الخميس 7:30ص–2:45م
الاعتمادات: Cambridge · Pearson Edexcel · Oxford International AQA · British Council · Goethe-Institut · Institut Français d'Égypte
