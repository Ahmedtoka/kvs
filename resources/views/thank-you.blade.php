@extends('layouts.app')

@section('title', 'Thank You — Knowledge Valley International School')
@section('meta_description', 'Thank you for contacting Knowledge Valley International School. Our team will be in touch shortly.')

@section('content')
<section class="relative overflow-hidden bg-maroon-950 text-ivory">
    <div class="absolute inset-0">
        <img src="/img/campus.jpg" alt="" class="w-full h-full object-cover opacity-[0.18]" width="1600" height="1000">
        <div class="absolute inset-0 bg-gradient-to-b from-maroon-950/85 via-maroon-900/80 to-maroon-950"></div>
        <div class="absolute -right-40 -bottom-48 w-[42rem] opacity-[0.05] pointer-events-none select-none" aria-hidden="true">
            <img src="/img/logo-mark.png" alt="" class="w-full h-auto">
        </div>
    </div>

    <div class="relative container-site py-24 sm:py-32 text-center">
        <div class="mx-auto w-20 h-20 rounded-full bg-gold-500/15 border border-gold-500/50 flex items-center justify-center mb-8">
            <svg class="w-11 h-11 text-gold-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>

        <p class="eyebrow !text-gold-400">{{ $label }}</p>
        <h1 class="font-display font-bold text-4xl sm:text-5xl lg:text-[56px] leading-[1.12] max-w-3xl mx-auto mt-4">
            Thank You
        </h1>
        <p class="mt-6 max-w-xl mx-auto text-base sm:text-lg text-ivory/85 leading-relaxed">
            {{ $message }}
        </p>

        <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('home') }}" class="btn-gold !px-7 !py-4">Back to Home</a>
            <a href="{{ route('academics') }}" class="inline-flex items-center gap-2 px-7 py-4 rounded-sm border border-ivory/30 text-ivory hover:bg-ivory/10 transition-colors">
                Explore Our Academics
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5M21 12H3"/></svg>
            </a>
        </div>

        <p class="mt-10 text-sm text-ivory/60">
            Need us sooner? Call
            <a href="tel:{{ preg_replace('/\s+/', '', setting('phone_admissions', '01277771119')) }}" class="text-gold-300 font-semibold hover:underline">{{ setting('phone_admissions', '0127 777 1119') }}</a>
        </p>
    </div>
</section>

@if ($converted)
{{-- Conversion tracking — fires once, only after a genuine form submission --}}
<script>
    window.addEventListener('load', function () {
        var name = @json($label);
        var type = @json($type);
        var eid = @json(session('meta_event_id'));

        // Meta (Facebook / Instagram) Pixel
        try {
            if (window.fbq) {
                fbq('track', 'Lead', { content_name: name, content_category: type }, eid ? { eventID: eid } : undefined);
                if (type === 'tour') {
                    fbq('track', 'Schedule', { content_name: 'Book a Tour', content_category: 'tour' }, eid ? { eventID: eid + '-s' } : undefined);
                }
            }
        } catch (e) {}

        // TikTok Pixel
        try { if (window.ttq) { ttq.track('SubmitForm', { content_name: name, content_type: type }); } } catch (e) {}

        // Google Ads conversion
        @if (setting('google_ads_id') && setting('google_ads_label'))
        try { if (window.gtag) { gtag('event', 'conversion', { send_to: @json(setting('google_ads_id') . '/' . setting('google_ads_label')), event_category: type }); } } catch (e) {}
        @endif

        // Google Analytics 4 — generate_lead event
        @if (setting('ga4_id'))
        try { if (window.gtag) { gtag('event', 'generate_lead', { form_type: type, form_name: name }); } } catch (e) {}
        @endif
    });
</script>
@endif
@endsection
