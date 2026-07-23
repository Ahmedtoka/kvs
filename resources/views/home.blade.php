@extends('layouts.app')

@section('title', 'Knowledge Valley International School — A British International School in Giza, Egypt')
@section('meta_description', 'KVS is a top-tier British curriculum international school in Giza, Egypt — accredited by Cambridge, Pearson Edexcel, Oxford AQA and the British Council. Book your school tour today.')

@section('content')
@php
    $valleyImgs = ['/img/campus.jpg'];
    $stageImgs  = ['/img/stage-early-years.jpg', '/img/stage-primary.jpg', '/img/stage-secondary.jpg'];
    $lifeImgs   = ['/img/life-1.jpg','/img/life-2.jpg','/img/life-3.jpg','/img/life-4.jpg','/img/life-5.jpg','/img/life-6.jpg'];
@endphp
{{-- ============ 1. HERO ============ --}}
<section class="relative overflow-hidden bg-maroon-950 text-ivory">
    {{-- photo layer (replace placeholder with real campus photo) --}}
    <div class="absolute inset-0">
        <img src="{{ $valleyImgs[0] ?? '/img/hero-campus.svg' }}" alt="" class="w-full h-full object-cover {{ count($valleyImgs) ? 'opacity-[0.32]' : 'opacity-[0.14]' }}" width="1600" height="1000">
        <div class="absolute inset-0 bg-gradient-to-b from-maroon-950/80 via-maroon-900/70 to-maroon-950"></div>
        <div class="absolute -right-40 -bottom-48 w-[42rem] opacity-[0.05] pointer-events-none select-none" aria-hidden="true">
            <img src="/img/logo-mark.png" alt="" class="w-full h-auto">
        </div>
    </div>

    <div class="relative container-site py-24 sm:py-32 lg:py-40 text-center">
        <div class="flex flex-col items-center gap-4 mb-6">
            <span class="inline-flex items-center gap-2.5 rounded-full border border-gold-500/40 bg-gold-500/10 px-6 py-2.5 text-[13px] sm:text-sm font-semibold tracking-[0.18em] uppercase text-gold-300">
                <svg class="w-4 h-4 text-gold-400" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg>
                Since 2008 · 18 Years of Excellence
            </span>
            <p class="eyebrow !text-gold-400">A British International School</p>
        </div>
        <h1 class="font-display font-bold text-4xl sm:text-5xl lg:text-[64px] leading-[1.12] max-w-4xl mx-auto">
            Rooted in Tradition.<br>
            <span class="text-gold-400">Inspired by the Future.</span>
        </h1>
        <p class="mt-6 max-w-2xl mx-auto text-base sm:text-lg text-ivory/80 leading-relaxed">
            Knowledge Valley International School is a leading British international school delivering the Cambridge
            curriculum from Early Years to IGCSE. We combine academic excellence, character development, innovation,
            and global perspectives to prepare confident, compassionate, and future-ready learners.
        </p>
        <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="#book-tour" data-track="Hero &middot; Book a Tour" class="btn-gold w-full sm:w-auto">
                Book a School Tour
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5M21 12H3"/></svg>
            </a>
            <a href="#admissions" data-track="Hero &middot; Explore Admissions" class="btn-outline-ivory w-full sm:w-auto">Explore Admissions</a>
        </div>
    </div>

    @include('partials.trust-marquee')
</section>

{{-- ============ 2. WELCOME ============ --}}
<section id="about" class="py-20 sm:py-28 bg-ivory">
    <div class="container-site grid lg:grid-cols-2 gap-14 lg:gap-20 items-center">
        <div class="reveal">
            <p class="eyebrow">Welcome to Knowledge Valley</p>
            <h2 class="heading-serif text-3xl sm:text-4xl lg:text-[42px] leading-tight mt-3 gold-rule-left">
                A Valley of Character&#8209;Building
            </h2>
            <p class="mt-6 text-charcoal-600 leading-[1.75]">
                Founded on the belief that education extends far beyond the classroom, KVS shapes individuals who
                think critically, act with integrity, and contribute positively to society. Our learning environment
                balances rigorous British academics with leadership, creativity, and global awareness.
            </p>
            <p class="mt-4 text-charcoal-600 leading-[1.75]">
                Every student is encouraged to discover their strengths, embrace challenges, and pursue excellence
                with confidence — prepared not only for university, but for life.
            </p>
            <a href="/about" class="inline-flex items-center gap-2 mt-8 font-semibold text-maroon-800 hover:text-maroon-600 transition-colors group">
                Discover our story
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5M21 12H3"/></svg>
            </a>
        </div>
        <div class="reveal relative">
            <div class="absolute -top-4 -left-4 w-full h-full border-2 border-gold-500/60 rounded-sm" aria-hidden="true"></div>
            <video data-welcome-video src="/videos/Homevideo.webm" poster="{{ $valleyImgs[0] ?? '/img/campus.jpg' }}" muted loop playsinline preload="none" aria-label="Life at Knowledge Valley International School" class="relative w-full aspect-[16/10] object-cover rounded-sm shadow-xl" width="1600" height="1000"></video>
            <div class="absolute -bottom-6 right-6 bg-maroon-900 text-ivory px-6 py-4 rounded-sm shadow-lg">
                <span class="block font-display text-2xl font-bold text-gold-400">Since 2008</span>
                <span class="block text-xs tracking-widest uppercase text-ivory/70">Excellence in Education</span>
            </div>
        </div>
    </div>
</section>

{{-- ============ 3. FACTS & FIGURES ============ --}}
<section class="bg-maroon-900 text-ivory relative overflow-hidden">
    <div class="absolute inset-0 opacity-[0.04] pointer-events-none" aria-hidden="true" style="background-image: radial-gradient(circle at 25% 40%, #c9a24b 0, transparent 40%), radial-gradient(circle at 80% 70%, #c9a24b 0, transparent 35%);"></div>
    <div class="relative container-site py-14 grid grid-cols-2 lg:grid-cols-4 gap-10 text-center">
        <div class="reveal">
            <p class="font-display text-4xl sm:text-5xl font-bold text-gold-400"><span data-counter="18">0</span>+</p>
            <p class="mt-2 text-sm tracking-wide text-ivory/75">Years of Excellence</p>
        </div>
        <div class="reveal">
            <p class="font-display text-4xl sm:text-5xl font-bold text-gold-400"><span data-counter="6">0</span></p>
            <p class="mt-2 text-sm tracking-wide text-ivory/75">International Accreditations</p>
        </div>
        <div class="reveal">
            <p class="font-display text-4xl sm:text-5xl font-bold text-gold-400"><span data-counter="3">0</span></p>
            <p class="mt-2 text-sm tracking-wide text-ivory/75">Languages Taught</p>
        </div>
        <div class="reveal">
            <p class="font-display text-4xl sm:text-5xl font-bold text-gold-400"><span data-counter="17">0</span></p>
            <p class="mt-2 text-sm tracking-wide text-ivory/75">Sustainable Development Goals</p>
        </div>
    </div>
</section>

{{-- ============ 4. ACADEMIC STAGES ============ --}}
<section id="academics" class="py-20 sm:py-28 bg-ivory">
    <div class="container-site">
        <div class="text-center max-w-2xl mx-auto reveal">
            <p class="eyebrow">Academics</p>
            <h2 class="heading-serif text-3xl sm:text-4xl lg:text-[42px] mt-3 gold-rule">Find Your Child's Place at KVS</h2>
            <p class="mt-6 text-charcoal-600 leading-relaxed">
                A seamless British curriculum journey — from first steps in Early Years to Cambridge, Edexcel
                and Oxford AQA qualifications in Secondary.
            </p>
        </div>

        <div class="mt-14 grid md:grid-cols-3 gap-8">
            {{-- Early Years --}}
            <article class="reveal group bg-white rounded-sm shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-beige-200">
                <div class="overflow-hidden">
                    <img src="{{ $stageImgs[0] ?? '/img/stage-early.svg' }}" alt="Early Years classroom at KVS" class="w-full aspect-[16/10] object-cover transition-transform duration-500 group-hover:scale-[1.03]" width="1600" height="1000" loading="lazy">
                </div>
                <div class="p-7">
                    <span class="inline-block text-xs font-semibold bg-gold-100 text-gold-800 px-3 py-1 rounded-full">FS1 – FS2 · Ages 3–5</span>
                    <h3 class="font-display text-2xl font-semibold text-maroon-900 mt-4">Early Years</h3>
                    <p class="mt-3 text-sm text-charcoal-600 leading-relaxed">
                        Our Early Years programme provides a joyful, nurturing, and inspiring start to every child's
                        educational journey. Through play-based learning, exploration, and meaningful experiences, we
                        foster curiosity, creativity, confidence, and independence while building strong foundations in
                        communication, literacy, numeracy, and personal development. In a safe and caring environment,
                        every child is encouraged to discover their unique potential and develop a lifelong love of learning.
                    </p>
                    <a href="/academics/early-years" class="inline-flex items-center gap-2 mt-5 text-sm font-semibold text-maroon-800 hover:text-maroon-600 transition-colors">
                        Explore Early Years
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>
            </article>

            {{-- Primary --}}
            <article class="reveal group bg-white rounded-sm shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-beige-200">
                <div class="overflow-hidden">
                    <img src="{{ $stageImgs[1] ?? '/img/stage-primary.svg' }}" alt="Primary students at KVS" class="w-full aspect-[16/10] object-cover transition-transform duration-500 group-hover:scale-[1.03]" width="1600" height="1000" loading="lazy">
                </div>
                <div class="p-7">
                    <span class="inline-block text-xs font-semibold bg-gold-100 text-gold-800 px-3 py-1 rounded-full">Years 1 – 6 · Ages 5–11</span>
                    <h3 class="font-display text-2xl font-semibold text-maroon-900 mt-4">Primary</h3>
                    <p class="mt-3 text-sm text-charcoal-600 leading-relaxed">
                        Our Primary programme empowers pupils to become confident, curious, and independent learners.
                        Through a broad and engaging curriculum, we inspire academic excellence, critical thinking,
                        creativity, and collaboration while nurturing strong values, resilience, and a sense of
                        responsibility. We prepare every child with the knowledge, skills, and character needed to thrive
                        in an ever-changing world.
                    </p>
                    <a href="/academics/primary" class="inline-flex items-center gap-2 mt-5 text-sm font-semibold text-maroon-800 hover:text-maroon-600 transition-colors">
                        Explore Primary
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>
            </article>

            {{-- Secondary --}}
            <article class="reveal group bg-white rounded-sm shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-beige-200">
                <div class="overflow-hidden">
                    <img src="{{ $stageImgs[2] ?? '/img/stage-secondary.svg' }}" alt="Secondary students at KVS" class="w-full aspect-[16/10] object-cover transition-transform duration-500 group-hover:scale-[1.03]" width="1600" height="1000" loading="lazy">
                </div>
                <div class="p-7">
                    <span class="inline-block text-xs font-semibold bg-gold-100 text-gold-800 px-3 py-1 rounded-full">Years 7+ · IGCSE Pathway</span>
                    <h3 class="font-display text-2xl font-semibold text-maroon-900 mt-4">Secondary &amp; IGCSE</h3>
                    <p class="mt-3 text-sm text-charcoal-600 leading-relaxed">
                        Rigorous preparation for Cambridge, Pearson Edexcel and Oxford AQA qualifications — the
                        gateway to leading universities.
                    </p>
                    <a href="/academics/secondary" class="inline-flex items-center gap-2 mt-5 text-sm font-semibold text-maroon-800 hover:text-maroon-600 transition-colors">
                        Explore Secondary
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>
            </article>
        </div>
    </div>
</section>

{{-- ============ 5. THE KVS MODEL ============ --}}
<section class="py-20 sm:py-28 bg-maroon-950 text-ivory relative overflow-hidden">
    <div class="absolute -left-40 top-10 w-[36rem] opacity-[0.04] pointer-events-none select-none" aria-hidden="true">
        <img src="/img/logo-mark.png" alt="" class="w-full h-auto">
    </div>
    <div class="relative container-site">
        <div class="text-center max-w-2xl mx-auto reveal">
            <p class="eyebrow !text-gold-400">Our Educational Framework</p>
            <h2 class="font-display font-semibold text-3xl sm:text-4xl lg:text-[42px] mt-3 gold-rule">The KVS Model</h2>
            <p class="mt-6 text-ivory/75 leading-relaxed">
                At Knowledge Valley International School, every child benefits from an educational experience that
                combines academic excellence, character development, global citizenship, and innovation. Our distinctive
                approach ensures pupils are prepared not only for examinations, but for success in university, careers, and life.
            </p>
        </div>

        <div class="mt-14 grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $pillars = [
                    ['title' => 'Academic Excellence', 'desc' => 'We deliver the Cambridge curriculum through expert teaching, high expectations, personalised support, and continuous assessment, enabling every learner to achieve their full potential.', 'icon' => 'M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5'],
                    ['title' => 'Cambridge Learner Attributes', 'desc' => 'We nurture confident, responsible, reflective, innovative, and engaged learners who demonstrate integrity, resilience, and leadership inside and outside the classroom.', 'icon' => 'M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z'],
                    ['title' => 'Global Citizenship', 'desc' => 'Learning extends beyond the classroom as pupils engage with the Sustainable Development Goals, developing empathy, environmental responsibility, cultural awareness, and a commitment to making a positive impact.', 'icon' => 'M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418'],
                    ['title' => 'Digital Learning', 'desc' => 'Every classroom integrates technology to enrich learning, strengthen digital literacy, encourage creativity, and prepare students for an increasingly connected world.', 'icon' => 'M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25'],
                    ['title' => 'Wellbeing & Character Development', 'desc' => 'Our PSHEE programme promotes emotional wellbeing, resilience, confidence, respect, and healthy relationships, helping pupils develop the character, values, and life skills needed to become responsible and compassionate global citizens.', 'icon' => 'M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z'],
                    ['title' => 'STEAM & Innovation', 'desc' => 'Our STEAM programme inspires curiosity, creativity, and innovation through hands-on, inquiry-based learning. By integrating Science, Technology, Engineering, Arts, and Mathematics, pupils develop critical thinking, problem-solving, collaboration, and future-ready skills to thrive in a rapidly changing world.', 'icon' => 'M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5'],
                    ['title' => 'University & Career Readiness', 'desc' => 'We prepare students for success beyond school by developing the knowledge, skills, and mindset needed for higher education and future careers. Through academic guidance, leadership opportunities, career exploration, and real-world experiences, pupils are empowered to achieve their aspirations with confidence.', 'icon' => 'M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z'],
                    ['title' => 'Community Service', 'desc' => 'We inspire students to make a positive difference through meaningful community service initiatives. By participating in charitable projects, environmental campaigns, and community partnerships, pupils develop compassion, leadership, social responsibility, and a lifelong commitment to serving others.', 'icon' => 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z'],
                ];
            @endphp
            @foreach ($pillars as $pillar)
            <div class="reveal bg-maroon-900/70 border border-gold-700/25 rounded-sm p-7 hover:border-gold-600/50 transition-colors duration-300">
                <div class="w-12 h-12 rounded-sm bg-gold-500/15 border border-gold-600/40 flex items-center justify-center">
                    <svg class="w-6 h-6 text-gold-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $pillar['icon'] }}"/></svg>
                </div>
                <h3 class="font-display text-xl font-semibold mt-5 text-ivory">{{ $pillar['title'] }}</h3>
                <p class="mt-3 text-sm text-ivory/70 leading-relaxed">{{ $pillar['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ 6. WHY KVS ============ --}}
<section class="py-20 sm:py-28 bg-beige-100">
    <div class="container-site">
        <div class="text-center max-w-2xl mx-auto reveal">
            <p class="eyebrow">Why Knowledge Valley</p>
            <h2 class="heading-serif text-3xl sm:text-4xl lg:text-[42px] mt-3 gold-rule">The KVS Distinct Advantage</h2>
        </div>

        <div class="mt-14 grid sm:grid-cols-2 lg:grid-cols-3 gap-x-10 gap-y-12">
            @php
                $advantages = [
                    ['title' => 'Top-Tier British Curriculum', 'desc' => 'Accredited pathways through Cambridge, Pearson Edexcel and Oxford International AQA — from Early Years to IGCSE.'],
                    ['title' => 'French Language Excellence', 'desc' => 'In partnership with the Institut Français d\'Égypte, our French programme provides high-quality language education that develops fluency, cultural awareness, and effective communication. Students gain internationally recognised language skills while building a strong foundation for future academic and global opportunities.'],
                    ['title' => 'German Language Excellence', 'desc' => 'In partnership with the Goethe-Institut, our German programme provides internationally recognised language learning that develops confidence, cultural awareness, and communication skills. Students are prepared for globally recognised Goethe examinations while building a strong foundation for future academic and professional opportunities.'],
                    ['title' => 'A Smart, Cashless Campus', 'desc' => 'SPARE and Kashier systems let parents handle fees, uniforms, canteen and transport digitally — with full peace of mind.'],
                    ['title' => 'Our House System', 'desc' => 'Every student is welcomed into one of our four houses — Resilience, Wisdom, Innovation, and Compassion — each representing the core values of Knowledge Valley School. Through friendly competitions, leadership opportunities, community service, and collaborative activities, our House System fosters teamwork, confidence, school spirit, and a strong sense of belonging.'],
                    ['title' => 'A Vibrant School Life', 'desc' => 'Science fairs, book fairs, chess academy, art exhibitions, charity initiatives and performances all year round.'],
                ];
            @endphp
            @foreach ($advantages as $i => $adv)
            <div class="reveal flex gap-5">
                <div class="shrink-0 w-11 h-11 rounded-full bg-maroon-900 text-gold-400 flex items-center justify-center font-display font-bold">
                    {{ sprintf('%02d', $i + 1) }}
                </div>
                <div>
                    <h3 class="font-semibold text-lg text-maroon-900">{{ $adv['title'] }}</h3>
                    <p class="mt-2 text-sm text-charcoal-600 leading-relaxed">{{ $adv['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ 7. LIFE AT KVS ============ --}}
<section id="school-life" class="py-20 sm:py-28 bg-ivory">
    <div class="container-site">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6 reveal">
            <div>
                <p class="eyebrow">School Life</p>
                <h2 class="heading-serif text-3xl sm:text-4xl lg:text-[42px] mt-3 gold-rule-left">Life at KVS</h2>
            </div>
            <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 font-semibold text-maroon-800 hover:text-maroon-600 transition-colors shrink-0 group">
                View all events
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5M21 12H3"/></svg>
            </a>
        </div>

        <div class="mt-12 grid grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @php
                $gallery = rescue(fn () => \App\Models\Event::active()->where('is_featured', true)->ordered()->limit(6)->get(), collect());
            @endphp
            @foreach ($gallery as $item)
            <a href="{{ route('events.show', $item->slug) }}" class="reveal group relative rounded-sm overflow-hidden block focus:outline-2 focus:outline-offset-2 focus:outline-gold-600">
                <img src="{{ $item->image }}" alt="{{ $item->title }} at KVS" class="w-full aspect-[4/3] object-cover transition-transform duration-500 group-hover:scale-[1.04]" width="1600" height="1000" loading="lazy">
                <div class="absolute inset-0 bg-gradient-to-t from-maroon-950/85 via-maroon-950/10 to-transparent"></div>
                <span class="absolute bottom-0 inset-x-0 p-4 sm:p-5 text-ivory font-display font-semibold text-sm sm:text-lg">{{ $item->title }}</span>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ 8. TESTIMONIALS — VIDEO SLIDER ============ --}}
<section id="testimonials" class="py-20 sm:py-28 bg-maroon-50">
    <div class="container-site">
        <div class="text-center max-w-2xl mx-auto reveal">
            <p class="eyebrow">Our Community</p>
            <h2 class="heading-serif text-3xl sm:text-4xl lg:text-[42px] mt-3 gold-rule">What Parents Say</h2>
            <p class="mt-6 text-charcoal-600 leading-relaxed">Hear directly from KVS families — in their own words.</p>
        </div>

        @php
            $reviewsFallback = [
                ['src' => '/videos/testimonial-1.mp4', 'poster' => '/videos/posters/testimonial-1.jpg'],
                ['src' => '/videos/testimonial-2.mp4', 'poster' => '/videos/posters/testimonial-2.jpg'],
                ['src' => '/videos/testimonial-3.mp4', 'poster' => '/videos/posters/testimonial-3.jpg'],
                ['src' => '/videos/testimonial-4.mp4', 'poster' => '/videos/posters/testimonial-4.jpg'],
                ['src' => '/videos/testimonial-5.mp4', 'poster' => '/videos/posters/testimonial-5.jpg'],
            ];
            $reviews = rescue(function () {
                return \App\Models\ContentItem::where('group', 'testimonial')->where('is_active', true)
                    ->orderBy('sort_order')->orderBy('id')->get()
                    ->filter(fn ($i) => $i->icon)
                    ->map(fn ($i) => ['src' => $i->icon, 'poster' => $i->body ?: ''])
                    ->values()->all();
            }, []);
            if (empty($reviews)) { $reviews = $reviewsFallback; }
        @endphp

        <div class="relative mt-14 reveal">
            <button type="button" data-vslide="prev" aria-label="Previous videos"
                    class="hidden md:flex absolute -left-3 lg:-left-5 top-1/2 -translate-y-1/2 z-10 w-11 h-11 rounded-full bg-white shadow-lg border border-beige-200 items-center justify-center text-maroon-800 hover:bg-gold-500 hover:text-maroon-950 hover:border-gold-500 transition-colors cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            </button>

            <div id="reviews-track" class="flex gap-5 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-2 px-1">
                @foreach ($reviews as $i => $v)
                <div data-review class="snap-center shrink-0 w-[76vw] sm:w-64 md:w-[290px]">
                    <div class="relative rounded-lg overflow-hidden shadow-xl bg-maroon-950 aspect-[9/16] ring-1 ring-maroon-900/10">
                        <video class="w-full h-full object-cover" preload="none" playsinline muted controls
                               poster="{{ $v['poster'] }}" src="{{ $v['src'] }}" data-index="{{ $i }}">
                            Your browser does not support the video tag.
                        </video>
                        <div data-spinner class="absolute inset-0 hidden items-center justify-center bg-maroon-950/40 pointer-events-none">
                            <span class="w-10 h-10 rounded-full border-[3px] border-ivory/30 border-t-gold-400 animate-spin"></span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <button type="button" data-vslide="next" aria-label="Next videos"
                    class="hidden md:flex absolute -right-3 lg:-right-5 top-1/2 -translate-y-1/2 z-10 w-11 h-11 rounded-full bg-white shadow-lg border border-beige-200 items-center justify-center text-maroon-800 hover:bg-gold-500 hover:text-maroon-950 hover:border-gold-500 transition-colors cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            </button>
        </div>
        <p class="mt-4 text-center text-xs text-charcoal-600/70">Plays in sequence when you reach this section — tap the volume icon to hear sound.</p>
    </div>
</section>

<style>
    #reviews-track { scrollbar-width: none; -ms-overflow-style: none; }
    #reviews-track::-webkit-scrollbar { display: none; }
</style>
<script>
    (function () {
        var track = document.getElementById('reviews-track');
        if (!track) return;
        var cards = Array.prototype.slice.call(track.querySelectorAll('[data-review]'));
        var videos = cards.map(function (c) { return c.querySelector('video'); });
        var started = false, current = -1, soundOn = false;

        function spinner(i, show) {
            var s = cards[i] && cards[i].querySelector('[data-spinner]');
            if (s) { s.style.display = show ? 'flex' : 'none'; }
        }
        function centerCard(i) {
            var c = cards[i]; if (!c) return;
            track.scrollTo({ left: c.offsetLeft - (track.clientWidth - c.clientWidth) / 2, behavior: 'smooth' });
        }
        function pauseOthers(keep) {
            videos.forEach(function (v, i) { if (i !== keep) { try { v.pause(); } catch (e) {} } });
        }
        function play(i) {
            if (i < 0 || i >= videos.length) { current = -1; return; }
            current = i;
            var v = videos[i];
            pauseOthers(i);
            centerCard(i);
            spinner(i, true);
            v.muted = !soundOn;
            v.preload = 'auto';
            var p = v.play();
            if (p && p.catch) { p.catch(function () { spinner(i, false); }); }
        }

        videos.forEach(function (v, i) {
            v.addEventListener('playing', function () { spinner(i, false); });
            v.addEventListener('canplay', function () { spinner(i, false); });
            v.addEventListener('waiting', function () { spinner(i, true); });
            v.addEventListener('ended', function () { spinner(i, false); play(i + 1); });
            v.addEventListener('play', function () { current = i; pauseOthers(i); });
            v.addEventListener('volumechange', function () { if (!v.muted) { soundOn = true; } });
        });

        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) {
                    if (!started) { started = true; play(0); }
                    else if (current !== -1 && videos[current].paused) { videos[current].play().catch(function () {}); }
                } else if (current !== -1) {
                    try { videos[current].pause(); } catch (err) {}
                }
            });
        }, { threshold: 0.4 });
        io.observe(track);

        function step() { var c = cards[0]; return c ? c.offsetWidth + 20 : 300; }
        document.querySelectorAll('[data-vslide]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                track.scrollBy({ left: (btn.dataset.vslide === 'next' ? 1 : -1) * step(), behavior: 'smooth' });
            });
        });
    })();
</script>

{{-- ============ 9. LEADERSHIP ============ --}}
<section class="py-20 sm:py-28 bg-ivory">
    <div class="container-site grid lg:grid-cols-5 gap-12 items-center">
        <div class="lg:col-span-2 reveal">
            <div class="relative max-w-sm mx-auto">
                <div class="absolute -top-4 -right-4 w-full h-full border-2 border-gold-500/60 rounded-sm" aria-hidden="true"></div>
                <img src="{{ '/img/leader-mohamed-farghaly.jpg' }}" alt="Mr. Mohamed Farghaly — KVS School Board" class="relative w-full aspect-[4/3] object-cover rounded-sm shadow-xl" width="1600" height="1000" loading="lazy">
            </div>
        </div>
        <div class="lg:col-span-3 reveal">
            <p class="eyebrow">A Word from Our Leadership</p>
            <blockquote class="font-display text-2xl sm:text-3xl leading-snug text-maroon-900 mt-5">
                "At KVS, our mission is to invest in future generations — guaranteeing every child not only a world-class education, but profound personal development, strong character, and a deep sense of community."
            </blockquote>
            <p class="mt-6 font-display text-xl font-semibold text-maroon-900">Mr. Mohamed Farghaly</p>
            <p class="text-sm font-semibold text-gold-700 tracking-wide uppercase mt-1">Founder &amp; Chairman</p>
            <a href="/leadership" class="inline-flex items-center gap-2 mt-6 font-semibold text-maroon-800 hover:text-maroon-600 transition-colors group">
                Read our leadership messages
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5M21 12H3"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- ============ 10. ADMISSION STEPS ============ --}}
<section id="admissions" class="py-20 sm:py-28 bg-beige-100">
    <div class="container-site">
        <div class="text-center max-w-2xl mx-auto reveal">
            <p class="eyebrow">Admissions</p>
            <h2 class="heading-serif text-3xl sm:text-4xl lg:text-[42px] mt-3 gold-rule">Joining KVS is Simple</h2>
            <p class="mt-6 text-charcoal-600">Admission for the 2026/2027 academic year is now open.</p>
        </div>

        <ol class="mt-14 grid sm:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-6">
            @php
                $steps = [
                    ['title' => 'Register Your Interest', 'desc' => 'Fill the short form below — or call our admissions team directly.'],
                    ['title' => 'Visit the School', 'desc' => 'Book a personal tour and see life at KVS with your own eyes.'],
                    ['title' => 'Student Assessment', 'desc' => 'A friendly age-appropriate assessment to place your child correctly.'],
                    ['title' => 'Welcome to the Valley', 'desc' => 'Complete the paperwork and your child\'s KVS journey begins.'],
                ];
            @endphp
            @foreach ($steps as $i => $step)
            <li class="reveal relative text-center px-2">
                @if ($i < 3)
                <div class="hidden lg:block absolute top-7 left-[calc(50%+2.5rem)] w-[calc(100%-5rem)] border-t-2 border-dashed border-gold-500/50" aria-hidden="true"></div>
                @endif
                <div class="mx-auto w-14 h-14 rounded-full bg-maroon-900 text-gold-400 font-display text-xl font-bold flex items-center justify-center shadow-md">{{ $i + 1 }}</div>
                <h3 class="font-semibold text-lg text-maroon-900 mt-5">{{ $step['title'] }}</h3>
                <p class="mt-2 text-sm text-charcoal-600 leading-relaxed">{{ $step['desc'] }}</p>
            </li>
            @endforeach
        </ol>

        <div class="mt-14 flex flex-col sm:flex-row items-center justify-center gap-4 reveal">
            <a href="#book-tour" class="btn-gold w-full sm:w-auto">Book a School Tour</a>
            <a href="/admissions" class="btn-maroon w-full sm:w-auto">How to Apply</a>
        </div>
    </div>
</section>

{{-- ============ 11. LEAD FORM ============ --}}
<section id="book-tour" class="py-20 sm:py-28 bg-maroon-950 text-ivory relative overflow-hidden">
    <div class="absolute -right-32 -top-24 w-[34rem] opacity-[0.05] pointer-events-none select-none" aria-hidden="true">
        <img src="/img/logo-mark.png" alt="" class="w-full h-auto">
    </div>
    <div class="relative container-site grid lg:grid-cols-2 gap-14 items-center">
        <div class="reveal">
            <p class="eyebrow !text-gold-400">Begin the Journey</p>
            <h2 class="font-display font-semibold text-3xl sm:text-4xl lg:text-[42px] mt-3 leading-tight">
                Give Your Child the Education They Deserve
            </h2>
            <p class="mt-6 text-ivory/75 leading-relaxed max-w-lg">
                Leave your details and our admissions team will contact you within 24 hours to answer your questions
                and arrange your personal school tour.
            </p>
            <div class="mt-10 space-y-4">
                <a href="tel:+201277771119" class="flex items-center gap-4 group">
                    <span class="w-11 h-11 rounded-full bg-gold-500/15 border border-gold-600/40 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                    </span>
                    <span>
                        <span class="block text-xs text-ivory/60 uppercase tracking-wider">Admissions Hotline</span>
                        <span class="block font-semibold text-lg group-hover:text-gold-300 transition-colors">0127 777 1119</span>
                    </span>
                </a>
                <a href="https://wa.me/201277771119" class="flex items-center gap-4 group">
                    <span class="w-11 h-11 rounded-full bg-gold-500/15 border border-gold-600/40 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-gold-400" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </span>
                    <span>
                        <span class="block text-xs text-ivory/60 uppercase tracking-wider">WhatsApp</span>
                        <span class="block font-semibold text-lg group-hover:text-gold-300 transition-colors">Message us directly</span>
                    </span>
                </a>
            </div>
        </div>

        <div class="reveal">
            <form class="bg-ivory text-charcoal-800 rounded-sm shadow-2xl p-7 sm:p-9" method="POST" action="{{ route('leads.store') }}">
                @csrf
                <input type="hidden" name="type" value="callback">
                <div class="hidden" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
                <h3 class="font-display text-2xl font-semibold text-maroon-900">Request a Call Back</h3>
                <p class="mt-1.5 text-sm text-charcoal-600">Our team replies within 24 hours, Sun–Thu.</p>

                <div class="mt-5">@include('partials.form-status')</div>

                <div class="mt-7 space-y-5">
                    <div>
                        <label for="parent_name" class="block text-sm font-medium mb-1.5">Parent's Full Name <span class="text-maroon-600" aria-hidden="true">*</span></label>
                        <input type="text" id="parent_name" name="parent_name" value="{{ old('parent_name') }}" required autocomplete="name"
                               class="w-full h-12 px-4 rounded-sm border border-beige-300 bg-white focus:border-gold-600 focus:ring-2 focus:ring-gold-500/30 focus:outline-none transition-colors">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium mb-1.5">Mobile Number <span class="text-maroon-600" aria-hidden="true">*</span></label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required autocomplete="tel" inputmode="numeric" maxlength="11" pattern="01[0-9]{9}" title="Please enter an 11-digit mobile number starting with 01" oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,11)" placeholder="01XXXXXXXXX"
                               class="w-full h-12 px-4 rounded-sm border border-beige-300 bg-white focus:border-gold-600 focus:ring-2 focus:ring-gold-500/30 focus:outline-none transition-colors">
                    </div>
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label for="child_age" class="block text-sm font-medium mb-1.5">Child's Age <span class="text-maroon-600" aria-hidden="true">*</span></label>
                            <select id="child_age" name="child_age" required
                                    class="w-full h-12 px-3 rounded-sm border border-beige-300 bg-white focus:border-gold-600 focus:ring-2 focus:ring-gold-500/30 focus:outline-none transition-colors">
                                <option value="" selected disabled>Select age</option>
                                @for ($age = 3; $age <= 17; $age++)
                                <option value="{{ $age }}">{{ $age }} years</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label for="stage" class="block text-sm font-medium mb-1.5">Stage of Interest</label>
                            <select id="stage" name="stage"
                                    class="w-full h-12 px-3 rounded-sm border border-beige-300 bg-white focus:border-gold-600 focus:ring-2 focus:ring-gold-500/30 focus:outline-none transition-colors">
                                <option value="" selected>Not sure yet</option>
                                <option value="early-years">Early Years (FS1–FS2)</option>
                                <option value="primary">Primary (Years 1–6)</option>
                                <option value="secondary">Secondary &amp; IGCSE</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn-gold w-full !py-4">
                        Request a Call Back
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5M21 12H3"/></svg>
                    </button>
                    <p class="text-xs text-charcoal-600/80 text-center">Your information is kept private and used only to contact you about admissions.</p>
                </div>
            </form>
        </div>
    </div>
</section>
{{-- Welcome-section video: muted autoplay only when scrolled into view (mobile + desktop) --}}
<script>
    (function () {
        var v = document.querySelector('[data-welcome-video]');
        if (!v) return;
        v.muted = true; // required for autoplay
        if (!('IntersectionObserver' in window)) { v.play().catch(function () {}); return; }
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting && e.intersectionRatio >= 0.4) {
                    var pr = v.play();
                    if (pr && pr.catch) { pr.catch(function () {}); }
                } else {
                    v.pause();
                }
            });
        }, { threshold: [0, 0.4, 0.6] });
        io.observe(v);
    })();
</script>
@endsection
