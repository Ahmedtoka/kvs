{{-- Inner page hero: expects $title, optional $subtitle, optional $crumbs = [['label','href'], ...] --}}
<section class="relative bg-maroon-950 text-ivory overflow-hidden">
    <div class="absolute -right-32 -bottom-40 w-[30rem] opacity-[0.05] pointer-events-none select-none" aria-hidden="true">
        <img src="/images/logo-mark.png" alt="" class="w-full h-auto">
    </div>
    <div class="absolute inset-0 bg-gradient-to-br from-maroon-900/60 to-maroon-950 pointer-events-none" aria-hidden="true"></div>
    <div class="relative container-site py-16 sm:py-20">
        <nav aria-label="Breadcrumb" class="mb-4">
            <ol class="flex flex-wrap items-center gap-2 text-xs tracking-wide text-ivory/60">
                <li><a href="/" class="hover:text-gold-300 transition-colors">Home</a></li>
                @isset($crumbs)
                    @foreach ($crumbs as $crumb)
                    <li aria-hidden="true" class="text-gold-600">/</li>
                    <li>
                        @if ($crumb[1])<a href="{{ $crumb[1] }}" class="hover:text-gold-300 transition-colors">{{ $crumb[0] }}</a>
                        @else<span class="text-ivory/80">{{ $crumb[0] }}</span>@endif
                    </li>
                    @endforeach
                @endisset
            </ol>
        </nav>
        <h1 class="font-display font-bold text-3xl sm:text-4xl lg:text-5xl leading-tight">{{ $title }}</h1>
        @isset($subtitle)
        <p class="mt-4 max-w-2xl text-ivory/75 leading-relaxed">{{ $subtitle }}</p>
        @endisset
        <div class="mt-6 h-[3px] w-16 bg-gold-500" aria-hidden="true"></div>
    </div>
</section>
