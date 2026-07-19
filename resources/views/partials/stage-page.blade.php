{{-- Shared stage page body. Expects: $stage = [chip, title, intro, img, day[], subjects[], outcomes] --}}
<section class="py-20 sm:py-24 bg-ivory">
    <div class="container-site grid lg:grid-cols-2 gap-14 items-center">
        <div class="reveal">
            <span class="inline-block text-xs font-semibold bg-gold-100 text-gold-800 px-3 py-1 rounded-full">{{ $stage['chip'] }}</span>
            <h2 class="heading-serif text-3xl sm:text-4xl mt-4 gold-rule-left">{{ $stage['headline'] }}</h2>
            @foreach ($stage['intro'] as $para)
            <p class="mt-5 text-charcoal-600 leading-[1.75]">{{ $para }}</p>
            @endforeach
        </div>
        <div class="reveal relative">
            <div class="absolute -top-4 -right-4 w-full h-full border-2 border-gold-500/60 rounded-sm" aria-hidden="true"></div>
            <img src="{{ $stage['photo'] ?? '/images/placeholders/'.$stage['img'].'.svg' }}" alt="{{ $stage['title'] }} at KVS" class="relative w-full aspect-[16/10] object-cover rounded-sm shadow-xl" width="1600" height="1000">
        </div>
    </div>
</section>

<section class="py-20 sm:py-24 bg-beige-100">
    <div class="container-site">
        <div class="text-center max-w-2xl mx-auto reveal">
            <p class="eyebrow">What Your Child Learns</p>
            <h2 class="heading-serif text-3xl sm:text-4xl mt-3 gold-rule">{{ $stage['subjects_title'] }}</h2>
        </div>
        <div class="mt-12 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($stage['subjects'] as $subject)
            <div class="reveal bg-white border border-beige-200 rounded-sm p-6 flex items-start gap-4">
                <span class="mt-1.5 w-2 h-2 rounded-full bg-gold-500 shrink-0" aria-hidden="true"></span>
                <div>
                    <h3 class="font-semibold text-maroon-900">{{ $subject[0] }}</h3>
                    <p class="mt-1.5 text-sm text-charcoal-600 leading-relaxed">{{ $subject[1] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-20 sm:py-24 bg-ivory">
    <div class="container-site grid lg:grid-cols-2 gap-14">
        <div class="reveal">
            <p class="eyebrow">Beyond the Books</p>
            <h2 class="heading-serif text-2xl sm:text-3xl mt-3 gold-rule-left">A Day in {{ $stage['title'] }}</h2>
            <ul class="mt-8 space-y-5">
                @foreach ($stage['day'] as $item)
                <li class="flex gap-4">
                    <span class="shrink-0 w-9 h-9 rounded-full bg-maroon-900 text-gold-400 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    </span>
                    <p class="text-charcoal-600 leading-relaxed pt-1.5">{{ $item }}</p>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="reveal bg-maroon-950 text-ivory rounded-sm p-9 self-start">
            <h2 class="font-display text-2xl font-semibold text-gold-400">{{ $stage['next_title'] }}</h2>
            <p class="mt-4 text-ivory/80 leading-relaxed">{{ $stage['next_desc'] }}</p>
            <div class="mt-8 flex flex-col gap-3">
                <a href="/book-a-tour" class="btn-gold w-full">Book a School Tour</a>
                <a href="/admissions" class="btn-outline-ivory w-full">How to Apply</a>
            </div>
        </div>
    </div>
</section>
