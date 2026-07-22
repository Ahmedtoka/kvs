{{-- Accreditations marquee — partner & accreditation logos in public/img/ --}}
@php
    $accLogos = ['/img/partner-1.jpg','/img/partner-2.jpg','/img/partner-3.jpg','/img/partner-4.jpg','/img/partner-5.jpg','/img/OxfordAQAMasterLogo.png','/img/partner-7.jpg'];
    $accNames = ['University of Cambridge', 'Pearson Edexcel', 'Oxford International AQA', 'British Council', 'Goethe-Institut', 'Institut Français'];
@endphp

<div class="relative border-t border-gold-700/25 bg-black/25">
    <div class="container-site py-6">
        <p class="text-center text-[11px] tracking-[0.3em] uppercase text-ivory/50 mb-4">Accredited by &amp; partnered with</p>

        @if (count($accLogos))
        {{-- Animated logo marquee — logos on ivory chips so any logo format looks right --}}
        <div class="marquee" aria-label="Our accreditations and partners">
            <div class="marquee-track">
                @foreach ([0, 1] as $half)
                <div class="marquee-half flex items-center" @if ($half === 1) aria-hidden="true" @endif>
                    @foreach ($accLogos as $logo)
                    <div class="mx-1.5 sm:mx-2 flex items-center justify-center h-16 sm:h-20 w-36 sm:w-44 shrink-0 bg-ivory rounded-sm p-1.5 shadow-sm">
                        <img src="{{ $logo }}" alt="{{ $half === 0 ? 'Accreditation partner' : '' }}"
                             class="max-h-full max-w-full object-contain"
                             loading="lazy" height="80">
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>
        @else
        {{-- Fallback: text marquee until logo images are added --}}
        <div class="marquee" aria-label="Our accreditations and partners">
            <div class="marquee-track">
                @foreach ([0, 1] as $half)
                <div class="marquee-half flex items-center" @if ($half === 1) aria-hidden="true" @endif>
                    @foreach ($accNames as $name)
                    <span class="mx-8 sm:mx-10 whitespace-nowrap font-display font-semibold text-lg text-gold-300/90 flex items-center gap-8 sm:gap-10">
                        {{ $name }}
                        <span class="text-gold-700 text-sm" aria-hidden="true">✦</span>
                    </span>
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
