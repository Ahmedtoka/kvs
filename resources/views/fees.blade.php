@extends('layouts.app')

@section('title', 'Tuition & Fees — Knowledge Valley International School')
@section('meta_description', 'Request the current KVS tuition and fees structure for your child\'s stage — sent directly by our admissions team within 24 hours.')

@section('content')

@include('partials.page-hero', [
    'title' => 'Tuition & Fees',
    'subtitle' => 'Fees at KVS vary by stage. Tell us your child\'s stage and we\'ll send you the full, transparent fee structure — no surprises.',
    'crumbs' => [['Admissions', '/admissions'], ['Tuition & Fees', null]],
])

<section class="py-20 sm:py-24 bg-ivory">
    <div class="container-site grid lg:grid-cols-2 gap-12 items-start">
        <div class="reveal">
            <p class="eyebrow">What's Included</p>
            <h2 class="heading-serif text-2xl sm:text-3xl mt-3 gold-rule-left">Value You Can See</h2>
            <p class="mt-6 text-charcoal-600 leading-[1.75]">
                A KVS education includes the full British curriculum with internationally accredited examinations,
                certified German and French programmes, and a school life rich with events, competitions and clubs.
            </p>
            <ul class="mt-8 space-y-4">
                @php $fees_list0 = [
                    'British curriculum through to IGCSE — Cambridge, Edexcel & Oxford AQA',
                    'Certified language programmes with Goethe-Institut & Institut Français',
                    'Smart cashless campus — fees, canteen and uniforms managed digitally',
                    'Optional transport service covering Giza and surrounding areas',
                    'Sibling considerations — ask our admissions team',
                ]; @endphp
                @foreach ($fees_list0 as $item)
                <li class="flex gap-3">
                    <svg class="w-5 h-5 mt-0.5 shrink-0 text-gold-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-charcoal-700">{{ $item }}</span>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="reveal">
            <form class="bg-maroon-950 text-ivory rounded-sm shadow-xl p-7 sm:p-10" method="POST" action="{{ route('leads.store') }}">
                @csrf
                <input type="hidden" name="type" value="fees">
                <div class="hidden" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
                <h2 class="font-display text-2xl font-semibold text-gold-400">Get This Year's Fees</h2>
                <p class="mt-1.5 text-sm text-ivory/70">Sent to you by WhatsApp or a quick call — within 24 hours.</p>

                <div class="mt-5">@include('partials.form-status', ['dark' => true])</div>
                <div class="mt-8 space-y-5">
                    <div>
                        <label for="f_name" class="block text-sm font-medium mb-1.5">Parent's Full Name <span class="text-gold-400" aria-hidden="true">*</span></label>
                        <input type="text" id="f_name" name="parent_name" value="{{ old('parent_name') }}" required autocomplete="name" class="w-full h-12 px-4 rounded-sm border border-maroon-700 bg-maroon-900 text-ivory placeholder:text-ivory/40 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none transition-colors">
                    </div>
                    <div>
                        <label for="f_phone" class="block text-sm font-medium mb-1.5">Mobile Number <span class="text-gold-400" aria-hidden="true">*</span></label>
                        <input type="tel" id="f_phone" name="phone" value="{{ old('phone') }}" required autocomplete="tel" inputmode="tel" placeholder="01XXXXXXXXX" class="w-full h-12 px-4 rounded-sm border border-maroon-700 bg-maroon-900 text-ivory placeholder:text-ivory/40 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none transition-colors">
                    </div>
                    <div>
                        <label for="f_stage" class="block text-sm font-medium mb-1.5">Stage of Interest <span class="text-gold-400" aria-hidden="true">*</span></label>
                        <select id="f_stage" name="stage" required class="w-full h-12 px-3 rounded-sm border border-maroon-700 bg-maroon-900 text-ivory focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none transition-colors">
                            <option value="" selected disabled>Select stage</option>
                            <option value="early-years">Early Years (FS1–FS2)</option>
                            <option value="primary">Primary (Years 1–6)</option>
                            <option value="secondary">Secondary &amp; IGCSE</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-gold w-full !py-4">Send Me the Fees</button>
                    <p class="text-xs text-ivory/50 text-center">Your information is kept private and used only to contact you about admissions.</p>
                </div>
            </form>
        </div>
    </div>
</section>

@include('partials.cta-band')

@endsection
