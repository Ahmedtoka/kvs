{{-- Accreditation / partner logo wall.
     DEMO wordmark badges — replace SVGs in /public/img/accred- with official brand assets (same filenames). --}}
@php
    $accreditors = [
        ['file' => 'cambridge',         'name' => 'University of Cambridge',       'tag' => 'Cambridge Pathway School'],
        ['file' => 'edexcel',           'name' => 'Pearson Edexcel',               'tag' => 'Approved Centre'],
        ['file' => 'oxford-aqa',        'name' => 'Oxford International AQA',      'tag' => 'Registered Centre', 'img' => '/img/OxfordAQAMasterLogo.png'],
        ['file' => 'british-council',   'name' => 'British Council',               'tag' => 'Partner School'],
        ['file' => 'goethe',            'name' => 'Goethe-Institut',               'tag' => 'German Certification'],
        ['file' => 'institut-francais', 'name' => "Institut Français d'Égypte",    'tag' => 'French Certification'],
    ];
@endphp

<div class="mt-10 grid grid-cols-2 md:grid-cols-3 {{ !empty($compact) ? 'lg:grid-cols-6' : '' }} gap-4 sm:gap-6">
    @foreach ($accreditors as $a)
    <div class="reveal bg-white rounded-sm border border-beige-200 shadow-sm hover:shadow-md transition-shadow p-5 flex flex-col items-center text-center">
        <img src="{{ $a['img'] ?? '/img/accred-'.$a['file'].'.svg' }}" alt="{{ $a['name'] }} logo" class="h-14 w-auto max-w-full object-contain" width="220" height="80" loading="lazy">
        @if (empty($compact))
        <p class="mt-3 text-sm font-semibold text-maroon-900">{{ $a['name'] }}</p>
        <p class="mt-1 text-xs text-charcoal-600">{{ $a['tag'] }}</p>
        @endif
    </div>
    @endforeach
</div>
