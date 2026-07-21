@extends('layouts.app')

@section('title', 'Leadership Messages — Knowledge Valley International School')
@section('meta_description', 'Messages from the Knowledge Valley International School board and leadership team.')

@section('content')

@include('partials.page-hero', [
    'title' => 'Leadership Messages',
    'subtitle' => 'The people behind the vision — a word from the KVS School Board.',
    'crumbs' => [['About KVS', '/about'], ['Leadership Messages', null]],
])

<section class="py-20 sm:py-24 bg-ivory">
    <div class="container-site space-y-16">
        @php
            $leaders = [
                ['name' => 'Mr. Mohamed Farghaly', 'role' => 'School Board', 'photo' => '/img/leader-mohamed-farghaly.jpg',
                 'message' => "At our educational institute, our primary mission is to invest in the future generations, recognizing this endeavor as our most challenging yet pivotal pursuit. We are dedicated to molding the lives and destinies of our students, with the ultimate aim of ensuring their prosperous futures. We firmly believe that nurturing our youth is the cornerstone of a nation's revival and renaissance. KVS is unwavering in its commitment to fostering a secure, nurturing, and innovative learning environment. Our foremost objective is to guarantee that every child who crosses our threshold not only receives a world-class education but also undergoes profound personal development, cultivates strong character, and fosters a deep sense of community. As we stand now, we take immense pride in witnessing KVS graduates emerge as exemplars of excellence in all facets of life."],
                ['name' => 'Dr. Heba Elshaer', 'role' => 'School Board', 'photo' => '/img/leader-heba-elshaer.jpg',
                 'message' => "KVS has always been more than just a place of learning; it is a place where young minds are nurtured, where dreams are fostered, and where futures are shaped. It is a place where we, as parents and educators, work hand in hand to provide our children with the best possible education and prepare them for the challenges and opportunities of the future. I also have to express the profound sense of privilege and nostalgia that comes with returning to KVS in this new capacity. This school holds a special place in my heart, as my three children, like many of yours, graduated from here. Their journey through KVS — marked by academic excellence, personal growth, and a deep sense of community — has inspired me to contribute to the school's vision that I wholeheartedly believe in. Let us embark on this new academic year with enthusiasm, determination, and a shared commitment to the success and well-being of our students."],
                ['name' => 'Ms. Elham Mahmoud', 'role' => 'School Board', 'photo' => '/img/leader-elham-mahmoud.jpg',
                 'message' => "Welcome to our school community — together, we will make it a better place for every student and family. Transitions are never easy, and it is natural to feel some anxiety about who will step in to lead. I extend to you and your family my warmth as we embark on this new journey. It is an honour to join KVS, a school known for its welcoming environment. We are a family, and we work as a team — all for one and one for all. We hold a strong focus on academic excellence within a safe and inspiring environment, and we encourage every student to take part in activities inside and outside the classroom. We believe every child is capable of reaching their potential, and we will do our best to support them to live happily, independently, and well-prepared for the world ahead. Our kids are our priority, and together we will keep our promise to provide a healthy learning environment in parallel with British academic standards."],
            ];
        @endphp
        @foreach ($leaders as $i => $leader)
        <article class="reveal grid lg:grid-cols-5 gap-10 items-center {{ $i % 2 ? 'lg:[direction:rtl]' : '' }}">
            <div class="lg:col-span-2 [direction:ltr]">
                <div class="relative max-w-xs mx-auto">
                    <div class="absolute -top-3 {{ $i % 2 ? '-right-3' : '-left-3' }} w-full h-full border-2 border-gold-500/60 rounded-sm" aria-hidden="true"></div>
                    <img src="{{ $leader['photo'] }}" alt="{{ $leader['name'] }}" class="relative w-full aspect-[4/5] object-cover rounded-sm shadow-xl" width="800" height="1000" loading="lazy">
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
