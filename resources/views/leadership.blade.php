@extends('layouts.app')

@section('title', 'Leadership Messages — Knowledge Valley International School')
@section('meta_description', 'Messages from the Knowledge Valley International School board and leadership team.')

@section('content')
@php $leaderImgs = kvs_images('a ward from our leader'); @endphp

@include('partials.page-hero', [
    'title' => 'Leadership Messages',
    'subtitle' => 'The people behind the vision — a word from the KVS School Board.',
    'crumbs' => [['About KVS', '/about'], ['Leadership Messages', null]],
])

<section class="py-20 sm:py-24 bg-ivory">
    <div class="container-site space-y-16">
        @php
            /* Each member's photo file lives in public/images/a ward from our leader/.
               Set 'photo' to the exact filename; leave null to show the placeholder. */
            $leaders = [
                ['name' => 'Mr. Mohamed Farghaly', 'role' => 'School Board', 'photo' => 'IMG_0456.JPG.jpeg',
                 'message' => 'It is my pleasure to welcome you to Knowledge Valley International School. Since our founding, we have been committed to one promise: an education that nurtures academic excellence and builds strong character in equal measure. I invite you to visit our campus and see that promise in action. [نص الرسالة الفعلي يُستبدل هنا]'],
                ['name' => 'Dr. Heba Elshaer', 'role' => 'School Board', 'photo' => 'tttt1.jpg.jpeg',
                 'message' => 'At KVS, we believe every child carries unique potential. Our role is to provide the environment, the guidance and the opportunities for that potential to flourish — academically, socially and personally. [نص الرسالة الفعلي يُستبدل هنا]'],
                ['name' => 'Ms. Elham Mahmoud', 'role' => 'School Board', 'photo' => 'Ahlam.jpg',
                 'message' => 'Welcome to our KVS family. Every new chapter brings a little uncertainty and a great deal of energy, and it is an honour to join a community known for its warmth and care. We hold a strong focus on academic excellence within a safe and inspiring environment, while encouraging every student to grow through activities both inside and outside the classroom. I believe every child is capable of reaching their full potential, and we work hand in hand with parents to make that happen. Communication is the key to every strong partnership, so please always feel free to share your ideas with us. Our children are our priority, and together, in line with British academic standards, we will prepare them to live happily, independently, and ready for the world ahead.'],
            ];
        @endphp
        @foreach ($leaders as $i => $leader)
        <article class="reveal grid lg:grid-cols-5 gap-10 items-center {{ $i % 2 ? 'lg:[direction:rtl]' : '' }}">
            <div class="lg:col-span-2 [direction:ltr]">
                <div class="relative max-w-xs mx-auto">
                    <div class="absolute -top-3 {{ $i % 2 ? '-right-3' : '-left-3' }} w-full h-full border-2 border-gold-500/60 rounded-sm" aria-hidden="true"></div>
                    <img src="{{ (!empty($leader['photo']) ? kvs_file('a ward from our leader/'.$leader['photo']) : null) ?? '/images/placeholders/leadership.svg' }}" alt="{{ $leader['name'] }}" class="relative w-full aspect-[4/5] object-cover rounded-sm shadow-xl" width="800" height="1000" loading="lazy">
                </div>
            </div>
            <div class="lg:col-span-3 [direction:ltr]">
                <svg class="w-9 h-9 text-gold-300" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                <p class="mt-5 text-lg text-charcoal-700 leading-[1.8]">{{ $leader['message'] }}</p>
                <p class="mt-6 font-display text-xl font-semibold text-maroon-900">{{ $leader['name'] }}</p>
                <p class="text-sm tracking-wide uppercase text-gold-700 font-semibold mt-1">{{ $leader['role'] }}</p>
            </div>
        </article>
        @endforeach
    </div>
</section>

@include('partials.cta-band')

@endsection
