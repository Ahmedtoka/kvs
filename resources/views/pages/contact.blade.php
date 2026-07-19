@extends('layouts.site')

@section('title', 'Contact Us | Knowledge Valley International School')
@section('description', 'Contact KVS — Sherif Ismail Axis, Ring Road, Saft Al Laban, Kerdasa, Giza. Admissions: 0127 777 1119 · admission@kvs.edu.eg')

@section('content')

@include('partials.page-hero', [
    'eyebrow' => 'Contact',
    'title'   => 'We\'d Love to Hear From You',
    'lead'    => 'Call, WhatsApp, email or visit — a real person from our team answers, Sunday to Thursday.',
    'crumbs'  => [['label' => 'Contact']],
])

<section class="py-16 sm:py-24 bg-ivory">
    <div class="container-site grid lg:grid-cols-2 gap-14 items-start">
        <div class="reveal space-y-7">
            @php
                $channels = [
                    ['label' => 'Admissions Hotline', 'value' => '0127 777 1119', 'href' => 'tel:+201277771119', 'track' => 'call_click',
                     'icon' => 'M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z'],
                    ['label' => 'School Office', 'value' => '02 3722 1413 · 02 3722 1206', 'href' => 'tel:+20237221413', 'track' => 'call_click',
                     'icon' => 'M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z'],
                    ['label' => 'Admissions Email', 'value' => 'admission@kvs.edu.eg', 'href' => 'mailto:admission@kvs.edu.eg', 'track' => 'cta_click',
                     'icon' => 'M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75'],
                    ['label' => 'General Email', 'value' => 'info@kvs.edu.eg', 'href' => 'mailto:info@kvs.edu.eg', 'track' => 'cta_click',
                     'icon' => 'M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75'],
                ];
            @endphp
            @foreach ($channels as $ch)
            <a href="{{ $ch['href'] }}" data-track="{{ $ch['track'] }}" data-label="contact-{{ $ch['label'] }}" class="flex items-center gap-5 group">
                <span class="w-12 h-12 rounded-full bg-maroon-50 border border-maroon-200/60 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-maroon-800" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $ch['icon'] }}"/></svg>
                </span>
                <span>
                    <span class="block text-xs text-charcoal-600 uppercase tracking-wider">{{ $ch['label'] }}</span>
                    <span class="block font-semibold text-lg text-maroon-900 group-hover:text-maroon-700 transition-colors">{{ $ch['value'] }}</span>
                </span>
            </a>
            @endforeach

            <div class="pt-4 border-t border-beige-200">
                <h2 class="font-display text-xl font-semibold text-maroon-900">Visit Us</h2>
                <p class="mt-2 text-charcoal-600 leading-relaxed">
                    Sherif Ismail Axis, Ring Road, Saft Al Laban, Kerdasa — Giza, Egypt<br>
                    <span class="text-sm">Sunday – Thursday · 7:30 AM – 2:45 PM</span>
                </p>
                <a href="https://maps.google.com/?q=Knowledge+Valley+International+School+Giza" target="_blank" rel="noopener"
                   data-track="cta_click" data-label="contact-directions"
                   class="inline-flex items-center gap-2 mt-4 font-semibold text-maroon-800 hover:text-maroon-600 transition-colors">
                    Get directions
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>
        </div>

        <div class="reveal">
            @include('partials.lead-form')
        </div>
    </div>
</section>

@endsection
