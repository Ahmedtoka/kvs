@extends('layouts.app')

@section('title', 'Book a School Tour — Knowledge Valley International School')
@section('meta_description', 'Book your personal tour of Knowledge Valley International School in Giza — meet our teachers, walk our campus, and get every question answered.')

@section('content')

@include('partials.page-hero', [
    'title' => 'Book a School Tour',
    'subtitle' => 'One visit answers more questions than a hundred web pages. Choose a day — we\'ll take care of the rest.',
    'crumbs' => [['Admissions', '/admissions'], ['Book a School Tour', null]],
])

<section class="py-20 sm:py-24 bg-ivory">
    <div class="container-site grid lg:grid-cols-5 gap-12 items-start">
        <div class="lg:col-span-2 reveal">
            <p class="eyebrow">What to Expect</p>
            <h2 class="heading-serif text-2xl sm:text-3xl mt-3 gold-rule-left">Your Visit, Step by Step</h2>
            <ul class="mt-8 space-y-5">
                @php $book_a_tour_list0 = [
                    'A personal welcome from our admissions team — no group rush.',
                    'A walk through classrooms, labs, library and play areas while school is in session.',
                    'Meet teachers and see how our students actually learn.',
                    'A sit-down to answer every question — curriculum, fees, buses, uniforms.',
                    'Around 45–60 minutes, any school day between 8:00 AM and 1:00 PM.',
                ]; @endphp
                @foreach ($book_a_tour_list0 as $item)
                <li class="flex gap-4">
                    <span class="shrink-0 w-9 h-9 rounded-full bg-maroon-900 text-gold-400 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    </span>
                    <p class="text-charcoal-600 leading-relaxed pt-1.5">{{ $item }}</p>
                </li>
                @endforeach
            </ul>
            <div class="mt-10 bg-beige-100 rounded-sm p-6">
                <p class="text-sm text-charcoal-600">Prefer to talk first?</p>
                <a href="tel:+201277771119" class="block font-display text-2xl font-bold text-maroon-900 mt-1 hover:text-maroon-700 transition-colors">0127 777 1119</a>
                <p class="text-xs text-charcoal-600 mt-1">Sunday – Thursday · 7:30 AM – 2:45 PM</p>
            </div>
        </div>

        <div class="lg:col-span-3 reveal">
            <form class="bg-white border border-beige-200 rounded-sm shadow-xl p-7 sm:p-10" method="POST" action="#">
                <h2 class="font-display text-2xl font-semibold text-maroon-900">Reserve Your Tour</h2>
                <p class="mt-1.5 text-sm text-charcoal-600">We confirm every tour by phone within 24 hours.</p>

                <div class="mt-8 grid sm:grid-cols-2 gap-5">
                    <div>
                        <label for="t_parent" class="block text-sm font-medium mb-1.5">Parent's Full Name <span class="text-maroon-600" aria-hidden="true">*</span></label>
                        <input type="text" id="t_parent" name="parent_name" required autocomplete="name" class="w-full h-12 px-4 rounded-sm border border-beige-300 bg-white focus:border-gold-600 focus:ring-2 focus:ring-gold-500/30 focus:outline-none transition-colors">
                    </div>
                    <div>
                        <label for="t_phone" class="block text-sm font-medium mb-1.5">Mobile Number <span class="text-maroon-600" aria-hidden="true">*</span></label>
                        <input type="tel" id="t_phone" name="phone" required autocomplete="tel" inputmode="tel" placeholder="01XXXXXXXXX" class="w-full h-12 px-4 rounded-sm border border-beige-300 bg-white focus:border-gold-600 focus:ring-2 focus:ring-gold-500/30 focus:outline-none transition-colors">
                    </div>
                    <div>
                        <label for="t_student" class="block text-sm font-medium mb-1.5">Student's Name <span class="text-maroon-600" aria-hidden="true">*</span></label>
                        <input type="text" id="t_student" name="student_name" required class="w-full h-12 px-4 rounded-sm border border-beige-300 bg-white focus:border-gold-600 focus:ring-2 focus:ring-gold-500/30 focus:outline-none transition-colors">
                    </div>
                    <div>
                        <label for="t_email" class="block text-sm font-medium mb-1.5">Email</label>
                        <input type="email" id="t_email" name="email" autocomplete="email" inputmode="email" class="w-full h-12 px-4 rounded-sm border border-beige-300 bg-white focus:border-gold-600 focus:ring-2 focus:ring-gold-500/30 focus:outline-none transition-colors">
                    </div>
                    <div>
                        <label for="t_year" class="block text-sm font-medium mb-1.5">Applying for Year Group <span class="text-maroon-600" aria-hidden="true">*</span></label>
                        <select id="t_year" name="year_group" required class="w-full h-12 px-3 rounded-sm border border-beige-300 bg-white focus:border-gold-600 focus:ring-2 focus:ring-gold-500/30 focus:outline-none transition-colors">
                            <option value="" selected disabled>Select year group</option>
                            @foreach (['FS1', 'FS2', 'Year 1', 'Year 2', 'Year 3', 'Year 4', 'Year 5', 'Year 6', 'Year 7', 'Year 8', 'Year 9', 'Year 10', 'Year 11'] as $yg)
                            <option value="{{ $yg }}">{{ $yg }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="t_date" class="block text-sm font-medium mb-1.5">Preferred Tour Date <span class="text-maroon-600" aria-hidden="true">*</span></label>
                        <input type="date" id="t_date" name="preferred_date" required class="w-full h-12 px-4 rounded-sm border border-beige-300 bg-white focus:border-gold-600 focus:ring-2 focus:ring-gold-500/30 focus:outline-none transition-colors">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="t_notes" class="block text-sm font-medium mb-1.5">Anything we should know? <span class="text-charcoal-600/60 font-normal">(optional)</span></label>
                        <textarea id="t_notes" name="notes" rows="3" class="w-full px-4 py-3 rounded-sm border border-beige-300 bg-white focus:border-gold-600 focus:ring-2 focus:ring-gold-500/30 focus:outline-none transition-colors"></textarea>
                    </div>
                </div>
                <button type="submit" class="btn-gold w-full !py-4 mt-7">
                    Book My Tour
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5M21 12H3"/></svg>
                </button>
                <p class="mt-4 text-xs text-charcoal-600/80 text-center">Your information is kept private and used only to arrange your visit.</p>
            </form>
        </div>
    </div>
</section>

@endsection
