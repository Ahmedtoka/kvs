<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,400..700&display=swap" rel="stylesheet">
    <title>@yield('title', 'Knowledge Valley International School')</title>
    <meta name="description" content="@yield('meta_description', 'KVS is a top-tier British curriculum international school in Giza, Egypt — accredited by Cambridge, Pearson Edexcel, Oxford AQA and the British Council.')">
    <link rel="icon" type="image/png" href="/img/logo-mark.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $ga4 = setting('ga4_id');
        $gAds = setting('google_ads_id');
        $metaPixel = setting('meta_pixel_id') ?: config('services.meta.pixel_id') ?: '1363243909311016';
        $tiktokPixel = setting('tiktok_pixel_id');
    @endphp

    {{-- Google gtag.js — Google Analytics 4 + Google Ads --}}
    @if ($ga4 || $gAds)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $ga4 ?: $gAds }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        @if ($ga4) gtag('config', @json($ga4)); @endif
        @if ($gAds) gtag('config', @json($gAds)); @endif
    </script>
    @endif

    {{-- Meta (Facebook / Instagram) Pixel --}}
    @if ($metaPixel)
    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
        n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
        document,'script','https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', @json($metaPixel));
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id={{ $metaPixel }}&ev=PageView&noscript=1"/></noscript>
    @endif

    {{-- TikTok Pixel --}}
    @if ($tiktokPixel)
    <script>
        !function (w, d, t) {
          w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie","holdConsent","revokeConsent","grantConsent"];ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e};ttq.load=function(e,n){var r="https://analytics.tiktok.com/i18n/pixel/events.js",o=n&&n.partner;ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=r,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};var a=document.createElement("script");a.type="text/javascript",a.async=!0,a.src=r+"?sdkid="+e+"&lib="+t;var s=document.getElementsByTagName("script")[0];s.parentNode.insertBefore(a,s)};
          ttq.load(@json($tiktokPixel));
          ttq.page();
        }(window, document, 'ttq');
    </script>
    @endif
</head>
<body class="pb-16 lg:pb-0">

<a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:z-[100] focus:bg-gold-500 focus:text-maroon-950 focus:px-4 focus:py-2">Skip to main content</a>

@include('partials.topbar')
@include('partials.header')

<main id="main">
    @yield('content')
</main>

@include('partials.footer')
@include('partials.floats')


{{-- Meta Pixel - full-funnel events (KVS) --}}
@if ($metaPixel)
<script>
(function () {
    function boot() {
        if (!window.fbq) { return; }
        var path = (location.pathname || '/').replace(/\/+$/, '') || '/';
        var MAP = {
            '/': 'Home', '/about': 'About Us', '/leadership': 'Leadership',
            '/accreditations': 'Accreditations', '/academics': 'Academics',
            '/admissions': 'Admissions', '/book-a-tour': 'Book a Tour',
            '/fees': 'Tuition & Fees', '/faqs': 'FAQs', '/school-life': 'School Life',
            '/services': 'Parent Services', '/events': 'Events', '/contact': 'Contact',
            '/careers': 'Careers'
        };
        var name = MAP[path];
        if (!name) {
            if (path.indexOf('/academics') === 0) { name = 'Academics'; }
            else if (path.indexOf('/events') === 0) { name = 'Events'; }
            else if (path.indexOf('/thank-you') === 0) { name = 'Thank You'; }
            else { name = (document.title || path).slice(0, 60); }
        }
        fbq('track', 'ViewContent', { content_name: name, content_category: 'page' });
        if (path === '/book-a-tour') { fbq('track', 'Schedule', { content_name: 'Book a Tour page' }); }
        if (path === '/admissions') { fbq('trackCustom', 'ViewAdmissions'); }
        if (path === '/fees') { fbq('trackCustom', 'ViewFees'); }

        document.addEventListener('click', function (e) {
            var a = e.target && e.target.closest ? e.target.closest('a, button') : null;
            if (!a) { return; }
            var href = (a.getAttribute('href') || '').toLowerCase();
            var label = a.getAttribute('data-track') || a.getAttribute('data-label') || (a.textContent || '').trim().slice(0, 40);
            if (href.indexOf('wa.me') > -1 || href.indexOf('whatsapp') > -1) {
                fbq('track', 'Contact', { method: 'whatsapp', label: label });
            } else if (href.indexOf('tel:') === 0) {
                fbq('track', 'Contact', { method: 'phone', label: label });
            } else if (href.indexOf('mailto:') === 0) {
                fbq('track', 'Contact', { method: 'email', label: label });
            } else if (href.indexOf('book-a-tour') > -1 || /book a tour/i.test(label)) {
                fbq('track', 'Schedule', { content_name: label });
            } else if (href.indexOf('/admissions') > -1) {
                fbq('trackCustom', 'AdmissionsClick', { label: label });
            } else if (a.hasAttribute('data-track')) {
                fbq('trackCustom', 'CTAClick', { label: label });
            }
        }, true);

        document.addEventListener('submit', function (e) {
            var f = e.target;
            if (!f || f.tagName !== 'FORM') { return; }
            var action = (f.getAttribute('action') || '').toLowerCase();
            if (action.indexOf('/leads') > -1) {
                fbq('trackCustom', 'FormSubmit', { form: 'Lead / Enquiry' });
            } else if (action.indexOf('/careers') > -1) {
                fbq('trackCustom', 'FormSubmit', { form: 'Career Application' });
            }
        }, true);

        try {
            var seen = {};
            var secs = document.querySelectorAll('main section[id]');
            if (secs.length && 'IntersectionObserver' in window) {
                var io = new IntersectionObserver(function (entries) {
                    entries.forEach(function (en) {
                        if (en.isIntersecting && en.target.id && !seen[en.target.id]) {
                            seen[en.target.id] = 1;
                            fbq('trackCustom', 'ViewSection', { section: en.target.id });
                        }
                    });
                }, { threshold: 0.4 });
                secs.forEach(function (s) { io.observe(s); });
            }
        } catch (err) {}
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
})();
</script>
@endif

</body>
</html>
