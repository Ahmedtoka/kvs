@extends('layouts.app')

@section('title', 'Contact & Location — Knowledge Valley International School')
@section('meta_description', 'Contact KVS: Sherif Ismail Axis, Ring Road, Saft Al Laban, Kerdasa, Giza. Admissions: 0127 777 1119 · info@kvs.edu.eg')

@section('content')

@include('partials.page-hero', [
    'title' => 'Contact & Location',
    'subtitle' => 'Call, message, email or visit — our team is happy to help, Sunday to Thursday.',
    'crumbs' => [['Contact', null]],
])

<section class="py-20 sm:py-24 bg-ivory">
    <div class="container-site grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1 space-y-6">
            @php
                $cards = [
                    ['title' => 'Admissions Hotline', 'lines' => ['<a href="tel:+201277771119" class="hover:text-maroon-700">0127 777 1119</a>', '<a href="https://wa.me/201277771119" class="hover:text-maroon-700">WhatsApp available</a>'],
                     'icon' => 'M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z'],
                    ['title' => 'School Lines', 'lines' => ['02 3722 1413 · 02 3722 1206', '02 3722 1476 · 0114 511 0101'],
                     'icon' => 'M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3'],
                    ['title' => 'Email', 'lines' => ['<a href="mailto:info@kvs.edu.eg" class="hover:text-maroon-700">info@kvs.edu.eg</a>', '<a href="mailto:admission@kvs.edu.eg" class="hover:text-maroon-700">admission@kvs.edu.eg</a>'],
                     'icon' => 'M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75'],
                    ['title' => 'Working Hours', 'lines' => ['Sunday – Thursday', '7:30 AM – 2:45 PM'],
                     'icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z'],
                ];
            @endphp
            @foreach ($cards as $card)
            <div class="reveal bg-white border border-beige-200 rounded-sm p-6 flex gap-5">
                <div class="shrink-0 w-12 h-12 rounded-sm bg-maroon-900 flex items-center justify-center">
                    <svg class="w-6 h-6 text-gold-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}"/></svg>
                </div>
                <div>
                    <h2 class="font-semibold text-maroon-900">{{ $card['title'] }}</h2>
                    @foreach ($card['lines'] as $line)
                    <p class="mt-1 text-sm text-charcoal-600">{!! $line !!}</p>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <div class="lg:col-span-2 reveal">
            <div class="bg-white border border-beige-200 rounded-sm overflow-hidden shadow-md h-full flex flex-col">
                <div class="grow min-h-[320px] bg-beige-100 flex items-center justify-center relative">
                    {{-- Replace with embedded Google Map iframe --}}
                    <div class="text-center px-6">
                        <svg class="w-12 h-12 mx-auto text-gold-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        <p class="mt-4 font-display text-xl font-semibold text-maroon-900">Knowledge Valley International School</p>
                        <p class="mt-2 text-sm text-charcoal-600 max-w-md">Sherif Ismail Axis, Ring Road, Saft Al Laban, Kerdasa — Giza Governorate, Egypt</p>
                        <a href="https://maps.app.goo.gl/YysgXu71fUMULnm1A" target="_blank" rel="noopener" class="btn-maroon mt-6 !py-3">
                            Open in Google Maps
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                        </a>
                    </div>
                </div>
                <div class="p-6 border-t border-beige-200 bg-ivory flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-sm text-charcoal-600">Coming for a visit? Book your tour first so we can prepare a proper welcome.</p>
                    <a href="/book-a-tour" class="btn-gold !py-3 shrink-0">Book a School Tour</a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
