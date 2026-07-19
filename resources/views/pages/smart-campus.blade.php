@extends('layouts.site')

@section('title', 'Smart Cashless Campus — SPARE & Kashier | Knowledge Valley')
@section('description', 'A fully cashless smart campus: parents manage fees, canteen, uniforms and transport digitally through SPARE and Kashier — with full transparency.')

@section('content')

@include('partials.page-hero', [
    'eyebrow' => 'School Life',
    'title'   => 'A Smart, Cashless Campus',
    'lead'    => 'SPARE and Kashier let parents handle fees, uniforms, canteen and transport digitally — with full peace of mind, from their phones.',
    'crumbs'  => [['label' => 'School Life', 'url' => route('school-life')], ['label' => 'Smart Campus']],
])

<section class="py-16 sm:py-24 bg-ivory">
    <div class="container-site">
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
                $features = [
                    ['title' => 'Fees & Installments', 'desc' => 'Pay tuition digitally through Kashier — receipts, installments and history in one place.', 'icon' => 'M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z'],
                    ['title' => 'Cashless Canteen', 'desc' => 'Top up your child\'s SPARE balance and see what they buy — no cash on campus.', 'icon' => 'M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z'],
                    ['title' => 'Transport Management', 'desc' => 'Bus subscriptions and routes managed digitally, with clear communication.', 'icon' => 'M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12'],
                    ['title' => 'Uniforms & Supplies', 'desc' => 'Order uniforms and school essentials online — delivered to your child\'s class.', 'icon' => 'M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m-2.25 0h12a2.25 2.25 0 012.25 2.25v6.75a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25v-6.75a2.25 2.25 0 012.25-2.25z'],
                ];
            @endphp
            @foreach ($features as $f)
            <div class="reveal bg-white rounded-sm border border-beige-200 shadow-md p-7">
                <div class="w-12 h-12 rounded-sm bg-maroon-900 flex items-center justify-center">
                    <svg class="w-6 h-6 text-gold-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $f['icon'] }}"/></svg>
                </div>
                <h2 class="font-display text-xl font-semibold text-maroon-900 mt-5">{{ $f['title'] }}</h2>
                <p class="mt-3 text-sm text-charcoal-600 leading-relaxed">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="mt-14 reveal bg-maroon-950 text-ivory rounded-sm p-8 sm:p-10 flex flex-col lg:flex-row items-center justify-between gap-6">
            <div>
                <p class="eyebrow !text-gold-400">Full Transparency for Parents</p>
                <h2 class="font-display font-semibold text-2xl sm:text-3xl mt-2">Everything school-related, one tap away.</h2>
            </div>
            <a href="{{ route('book-tour') }}" data-track="cta_click" data-label="smart-campus-book-tour" class="btn-gold shrink-0">See It on a Tour</a>
        </div>
    </div>
</section>

@endsection
