@php
    $nav = [
        ['label' => 'About KVS', 'href' => '/about', 'children' => [
            ['label' => 'Our Story & Philosophy', 'href' => '/about'],
            ['label' => 'Leadership Messages', 'href' => '/leadership'],
            ['label' => 'Accreditations & Partners', 'href' => '/accreditations'],
        ]],
        ['label' => 'Academics', 'href' => '/academics', 'children' => [
            ['label' => 'The British Curriculum', 'href' => '/academics'],
            ['label' => 'Early Years (FS1–FS2)', 'href' => '/academics/early-years'],
            ['label' => 'Primary (Years 1–6)', 'href' => '/academics/primary'],
            ['label' => 'Secondary & IGCSE', 'href' => '/academics/secondary'],
        ]],
        ['label' => 'Admissions', 'href' => '/admissions', 'children' => [
            ['label' => 'How to Apply', 'href' => '/admissions'],
            ['label' => 'Book a School Tour', 'href' => '/book-a-tour'],
            ['label' => 'Tuition & Fees', 'href' => '/fees'],
            ['label' => 'FAQs', 'href' => '/faqs'],
        ]],
        ['label' => 'School Life', 'href' => '/school-life', 'children' => [
            ['label' => 'Events & Gallery', 'href' => '/school-life'],
            ['label' => 'Parent Services', 'href' => '/services'],
        ]],
        ['label' => 'Contact', 'href' => '/contact', 'children' => [
            ['label' => 'Contact & Location', 'href' => '/contact'],
            ['label' => 'Join Our Team', 'href' => '/careers'],
        ]],
    ];
@endphp
<header id="site-header" class="sticky top-0 z-50 bg-ivory/95 backdrop-blur border-b border-beige-200 transition-shadow duration-200">
    <div class="container-site flex items-center justify-between py-3">
        <a href="/" class="flex items-center gap-3" aria-label="Knowledge Valley International School — Home">
            <img src="/img/logo-mark.png" alt="" width="74" height="64" class="h-14 sm:h-16 w-auto">
            <span class="leading-tight">
                <span class="block font-display font-bold text-lg sm:text-xl text-maroon-900">Knowledge Valley</span>
                <span class="block text-[10px] sm:text-[11px] font-semibold tracking-[0.22em] uppercase text-gold-700">International School</span>
            </span>
        </a>

        <nav class="hidden lg:flex items-center gap-7" aria-label="Main navigation">
            @foreach ($nav as $item)
            <div class="relative group">
                <a href="{{ $item['href'] }}" class="flex items-center gap-1 py-4 text-sm font-medium text-charcoal-700 hover:text-maroon-800 transition-colors">
                    {{ $item['label'] }}
                    <svg class="w-3 h-3 text-charcoal-600/60 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                </a>
                <div class="absolute left-0 top-full pt-3 opacity-0 invisible translate-y-1 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 group-focus-within:opacity-100 group-focus-within:visible group-focus-within:translate-y-0 transition-all duration-200">
                    <ul class="w-64 bg-white rounded-sm shadow-xl border border-beige-200 py-2">
                        @foreach ($item['children'] as $child)
                        <li>
                            <a href="{{ $child['href'] }}" class="block px-5 py-2.5 text-sm text-charcoal-700 hover:bg-beige-100 hover:text-maroon-800 transition-colors">{{ $child['label'] }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endforeach
        </nav>

        <div class="flex items-center gap-3">
            <a href="/book-a-tour" class="btn-gold !px-5 !py-2.5 !text-[13px] hidden sm:inline-flex">Book a Tour</a>
            <button id="mobile-menu-btn" aria-expanded="false" aria-controls="mobile-menu" aria-label="Open menu" class="lg:hidden p-2 -mr-2 text-maroon-900 cursor-pointer">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5"/></svg>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div id="mobile-menu" class="hidden lg:hidden border-t border-beige-200 bg-ivory max-h-[calc(100dvh-4rem)] overflow-y-auto">
        <nav class="container-site py-4" aria-label="Mobile navigation">
            @foreach ($nav as $item)
            <div class="border-b border-beige-100 py-1">
                <a href="{{ $item['href'] }}" class="block py-2.5 px-2 font-semibold text-maroon-900">{{ $item['label'] }}</a>
                <div class="pb-2">
                    @foreach ($item['children'] as $child)
                    <a href="{{ $child['href'] }}" class="block py-2 px-6 text-sm text-charcoal-700">{{ $child['label'] }}</a>
                    @endforeach
                </div>
            </div>
            @endforeach
            <a href="/book-a-tour" class="btn-gold w-full mt-4">Book a School Tour</a>
        </nav>
    </div>
</header>
