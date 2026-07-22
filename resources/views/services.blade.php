@extends('layouts.app')

@section('title', 'Parent Services — Knowledge Valley International School')
@section('meta_description', 'KVS is a fully cashless smart school: SPARE for payments, attendance and buses; Kashier for fees and uniforms; online canteen menus and more.')

@section('content')

@include('partials.page-hero', [
    'title' => 'Parent Services',
    'subtitle' => 'A fully digital, cashless school — manage everything from your phone, with complete peace of mind.',
    'crumbs' => [['School Life', '/school-life'], ['Parent Services', null]],
])

<section class="py-20 sm:py-24 bg-ivory">
    <div class="container-site">
        <div class="grid md:grid-cols-2 gap-8">
            @php
                $servicesFallback = [
                    ['title' => 'SPARE School System', 'desc' => 'One app for the essentials: fee payments, attendance tracking, school bus management, canteen menus, and direct communication with the school.',
                     'icon' => 'M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3'],
                    ['title' => 'Kashier Payments', 'desc' => 'Secure online payment for tuition fees and school uniforms — pay by card from anywhere, with instant confirmation.',
                     'icon' => 'M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z'],
                    ['title' => 'Online Uniform Store', 'desc' => 'Order official KVS uniforms online in the right sizes, and receive them at school — no queues, no guesswork.',
                     'icon' => 'M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z'],
                    ['title' => 'Healthy Canteen', 'desc' => 'Weekly canteen menus published in advance through SPARE — balanced options, cashless purchases, full parent visibility.',
                     'icon' => 'M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.87c1.355 0 2.697.055 4.024.165C17.155 8.51 18 9.473 18 10.608v2.513m-3-4.87v-1.5m-6 1.5v-1.5m12 9.75l-1.5.75a3.354 3.354 0 01-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 01-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 01-3 0L3 16.5m15-3.38a48.474 48.474 0 00-6-.37c-2.032 0-4.034.125-6 .37m12 0c.39.049.777.102 1.163.16 1.07.16 1.837 1.094 1.837 2.175v5.17c0 .62-.504 1.124-1.125 1.124H4.125A1.125 1.125 0 013 20.625v-5.17c0-1.08.768-2.014 1.837-2.174A47.78 47.78 0 016 13.12'],
                    ['title' => 'School Transport', 'desc' => 'Safe, supervised bus routes across Giza and surrounding areas — tracked and managed through the SPARE system.',
                     'icon' => 'M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12'],
                    ['title' => 'Parent Communication', 'desc' => 'Regular reports, newsletters and direct channels with teachers and administration — you are never out of the loop.',
                     'icon' => 'M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z'],
                ];
                $defaultIcon = 'M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z';
                $services = rescue(fn () => \App\Models\ContentItem::where('group', 'service')->where('is_active', true)->orderBy('sort_order')->orderBy('id')->get()
                    ->map(fn ($i) => ['title' => $i->title, 'desc' => $i->body, 'icon' => $i->icon ?: $defaultIcon])->all(), []);
                if (! count($services)) {
                    $services = $servicesFallback;
                }
            @endphp
            @foreach ($services as $service)
            <article class="reveal bg-white border border-beige-200 rounded-sm p-8 hover:shadow-lg transition-shadow duration-300 flex gap-6">
                <div class="shrink-0 w-14 h-14 rounded-sm bg-maroon-900 flex items-center justify-center">
                    <svg class="w-7 h-7 text-gold-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $service['icon'] }}"/></svg>
                </div>
                <div>
                    <h2 class="font-display text-xl font-semibold text-maroon-900">{{ $service['title'] }}</h2>
                    <p class="mt-3 text-sm text-charcoal-600 leading-relaxed">{{ $service['desc'] }}</p>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

@include('partials.cta-band')

@endsection
