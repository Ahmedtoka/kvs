# KVS — الاستراكشر المقترح للموقع الجديد
**النسخة 1.0 — للمناقشة قبل التنفيذ**

بُني على: البريف الرسمي + محتوى الموقع القديم (13 صفحة) + ريسيرش 6 منافسين (AIS, Ethos, HSE, Dwight, SILS, NIC)

---

## 1) الاستراتيجية في سطرين

الموقع ده مش "بروشور أونلاين" — ده **ماكينة ليدز** شكلها قصر. كل صفحة ليها وظيفة واحدة في رحلة الأب:
**يوصل → ينبهر (Prestige) → يتطمن (Proof) → يلاقي مرحلة ابنه (Relevance) → ياخد خطوة سهلة (Book a Tour / Leave Details)**

القاعدة الذهبية: **"Book a School Tour" هو الـ CTA الملك** — التزام خفيف، مناسب ثقافيًا (الأب المصري عايز يشوف بعينه)، وبيحوّل أونلاين لأوفلاين حيث المدرسة أقوى. كل صفحة في الموقع بتصب فيه.

---

## 2) Sitemap المقترح

```
KVS Website
│
├── Home
│
├── About KVS
│   ├── Our Story & Philosophy          ← (About Us القديمة + Since 2007/8 + timeline)
│   ├── Vision, Mission & Values        ← موجودة + Core Values الـ6 من البريف
│   ├── Leadership Messages             ← School Board: الرسائل الثلاثة بصور
│   ├── The KVS Model                   ← الـ6 Pillars + الرسم الدائري (نعيد تصميمه)
│   └── Accreditations & Partnerships   ← Cambridge/Pearson/Oxford AQA/British Council/Goethe/IF — صفحة كاملة مش شعارات
│
├── Academics                            ★ قسم جديد بالكامل — أكبر فجوة في الموقع القديم
│   ├── The British Curriculum          ← نظرة عامة + مسار الشهادات (Checkpoint → IGCSE → AS/A-Level)
│   ├── Early Years (FS1–FS2)           ← صفحة لكل مرحلة: الأعمار، المنهج، يوم الطالب، صور، CTA
│   ├── Primary (Years 1–6)
│   ├── Secondary (Years 7+ / IGCSE)
│   ├── Languages                       ← German (Goethe) + French (IF) — ميزة تنافسية نادرة
│   └── The KVS Learner                 ← Confident–Responsible–Innovative–Reflective–Engaged + Cambridge Learner Attributes
│
├── Admissions                           ★ قلب الفانل
│   ├── How to Apply                    ← Journey من 4 خطوات مرسومة + Age Placement Guide (جدول سن/مرحلة)
│   ├── Book a School Tour              ← فورم داخلي → ليد في الداشبورد
│   ├── Required Documents & Transfers  ← من الموقع القديم
│   ├── Tuition & Fees                  ← (استراتيجية العرض تُحسم — انظر بند 6)
│   └── FAQs                            ← 10–15 سؤال بأكورديون
│
├── School Life
│   ├── Events & Gallery                ← الـ9 أحداث + فلترة بالسنة/النوع — يتغذى من الداشبورد
│   ├── Beyond the Classroom            ← Chess Academy, Science Fair, Book Fair, Charity... (Brand Pillar جاهز)
│   ├── Parent Services                 ← SPARE + Kashier + Uniform + Canteen + Transport — "مدرسة رقمية بالكامل"
│   ├── Term Dates & Calendar           ← تقويم HTML حقيقي بدل صور الشهور
│   └── Newsletter                      ← أرشيف PDF قابل للإدارة من الداشبورد
│
├── News                                 ← أخبار + مقالات (SEO + دليل حياة) — Phase 2 محتملة
│
└── Contact Us
    ├── Contact & Location              ← فورم ليد + خريطة + كل الأرقام + WhatsApp
    └── Join Our Team                   ← فورم توظيف داخلي (يبني قاعدة CVs في الداشبورد)
```

**عناصر ثابتة في كل الصفحات:**
- Header: لوجو + منيو + زرار ذهبي ثابت **Book a Tour** + مبدّل اللغة AR/EN
- زرار WhatsApp عائم
- **Mobile sticky bar** أسفل الشاشة: 📞 اتصال · 💬 واتساب · 🏫 Book a Tour (معظم زوار إعلانات مصر موبايل)
- Footer غني: بيانات التواصل كاملة + خريطة مصغرة + روابط سريعة + شريط اعتمادات + سوشيال

---

## 3) الصفحة الرئيسية — سكشن بسكشن (أهم صفحة في الفانل)

| # | السكشن | الوظيفة النفسية |
|---|--------|----------------|
| 1 | **Hero**: صورة/فيديو حقيقي من المدرسة + "Rooted in Tradition. Inspired by the Future." + سطر تعريفي + زرارين: Book a School Tour (ذهبي) / Explore Admissions | الانبهار الأول — قصر مش موقع |
| 2 | **Trust Bar**: شعارات Cambridge · Pearson Edexcel · Oxford AQA · British Council · Goethe · IF | "المدرسة دي بجد" في أول 5 ثواني |
| 3 | **Welcome + Facts & Figures**: فقرة قصيرة + أرقام متحركة (سنوات منذ 2007/8، عدد طلاب، جنسيات، اعتمادات) | مصداقية بالأرقام (نمط Dwight/NIC) |
| 4 | **Academic Stages**: 3 كروت كبيرة (Early Years / Primary / Secondary) بالأعمار + لينك لكل صفحة | "فين مكان ابني؟" — الإجابة فورًا |
| 5 | **The KVS Model**: الـ6 Pillars برسم تفاعلي مبسط | التميّز — محدش في السوق بيقدم ده |
| 6 | **Why KVS**: 6 مزايا (من Our Distinct Advantage) بأيقونات | حسم المقارنة مع المنافسين |
| 7 | **Life at KVS**: شبكة صور/فيديو من الأحداث + لينك للجاليري | العاطفة — الأب يتخيل ابنه هناك |
| 8 | **Testimonials**: 3–4 آراء أولياء أمور (تُجمع من الإدارة) | Social proof (نمط NIC) |
| 9 | **Leadership Snippet**: صورة + اقتباس من رسالة الإدارة + لينك | علاقة إنسانية |
| 10 | **Admission Steps**: 1 سجّل اهتمامك → 2 زور المدرسة → 3 التقييم → 4 أهلًا بيك | تبسيط الخطوة الجاية |
| 11 | **Lead Form Section**: خلفية Maroon فخمة — "ابدأ رحلة ابنك في KVS": الاسم، الموبايل، سن الطفل، المرحلة | الحصاد — الفورم بيجي للأب مش العكس |
| 12 | **Footer** | كل طرق التواصل |

---

## 4) الفانل ونظام الليدز

### نقاط التقاط الليدز (كلها تصب في الداشبورد):
1. **Book a School Tour** — الفورم الملك (اسم الطالب، ولي الأمر، موبايل، Year Group، ميعاد مفضل)
2. **Quick Lead Form** (الهوم + نهاية كل صفحة مرحلة): اسم + موبايل + سن الطفل + المرحلة — 4 حقول بس
3. **Apply Now** — طلب التقديم الكامل
4. **Fees Inquiry** — لو المصاريف مش هتتعرض علنًا: زرار "Get Fees Details" بفورم قصير = مغناطيس ليدز قوي جدًا
5. **WhatsApp / Call clicks** — تتبع كأحداث
6. **Join Our Team** — pipeline منفصل للـ CVs

### دورة حياة الليد في الداشبورد:
```
New → Contacted → Tour Booked → Toured → Applied → Enrolled ✅
                                                  ↘ Lost ✖ (مع السبب)
```
مع تسجيل: المصدر (أنهي صفحة/فورم + UTM من الإعلانات)، ملاحظات المكالمات، تعيين موظف مسؤول، تنبيه إيميل فوري عند وصول ليد جديد.

---

## 5) الداشبورد — الموديولات

| موديول | يتحكم في |
|--------|----------|
| **Leads CRM** | كل الليدز + الحالات + الفلترة + الملاحظات + التصدير Excel + إحصائيات (ليدز/أسبوع، معدل تحويل، أفضل مصدر) |
| Pages & Sections | نصوص وصور كل سكشن في كل صفحة (EN/AR) |
| Events & Gallery | إضافة حدث + رفع صور متعددة + تصنيف |
| News/Blog | مقالات بمحرر غني |
| Testimonials | آراء أولياء الأمور |
| Staff Messages | رسائل القيادة |
| Accreditations | الشعارات والشراكات |
| FAQs | سؤال/جواب بترتيب قابل للسحب |
| Term Dates | التقويم الأكاديمي |
| Newsletters | رفع PDFs |
| Careers | الوظائف + CVs المستلمة |
| Settings | أرقام، إيميلات، سوشيال، ساعات العمل، بانر إعلان الأدمشن (on/off) |
| Users & Roles | Super Admin / Admissions Team / Content Editor |

---

## 6) قرارات مفتوحة (محتاجة حسم)

1. **اللغات**: التوصية إنجليزي أساسي + عربي كامل RTL (الفانل الإعلاني مصري). ⏳
2. **الداشبورد**: التوصية Filament. ⏳
3. **حالة فولدر Kvs**: فاضي ولا فيه Laravel؟ ⏳
4. **المصاريف**: علنية (شفافية تبني ثقة — 4 من 6 منافسين بيعرضوها) ولا Fees Inquiry Gate (ليدز أكتر لكن ممكن تفلتر ناس جادة)؟ **توصيتي: Gate في السنة الأولى** — نستفيد بالليدز، ونقيس.
5. من الإدارة: سنة التأسيس النهائية، المراحل/الأعمار الفعلية المتاحة، أرقام (طلاب/معلمين/جنسيات)، 3–4 testimonials، روابط السوشيال الأصلية.

## 7) خطة التنفيذ المقترحة (Phases)

- **Phase 1 — الإطلاق**: كل الأقسام أعلاه ما عدا News/Blog و Alumni + الداشبورد كاملة بنظام الليدز. ثنائي اللغة من اليوم الأول.
- **Phase 2**: News/Blog (SEO) + Virtual Tour 360 لو توفرت + Testimonials فيديو.
- **Phase 3 (مستقبلًا)**: Alumni + بوابة تكامل أعمق مع SPARE.

## 8) ملاحظات مقارنة سريعة — إحنا فين من السوق بعد التنفيذ؟

- Facts & Figures بالأرقام → ناخدها من Dwight/NIC ✅ (سكشن 3 في الهوم)
- صفحات مراحل بالأعمار → من Ethos/HSE/SILS ✅ (قسم Academics)
- Age Placement Guide → من SILS ✅ (جوه How to Apply)
- FAQs → من AIS/HSE ✅
- Testimonials → من NIC ✅
- Why KVS → من SILS ✅
- Book a Tour بارز → أقوى من AIS نفسها (عندنا في الهيدر + الموبايل بار)
- الـ6 Pillars Model + لغتين أوروبيتين معتمدتين (Goethe/IF) → **مالهمش مثيل عند حد من الستة** — دي رأس الحربة
