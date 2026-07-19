@extends('layouts.site')

@section('title', 'Book a School Tour | Knowledge Valley International School')
@section('description', 'Book your personal KVS school tour — meet our teachers, walk the campus, and get every admissions question answered. We reply within 24 hours.')
@section('hide-cta-band', true)

@section('content')

<section class="py-16 sm:py-24 bg-maroon-950 text-ivory relative overflow-hidden min-h-[70vh]">
    <div class="absolute -right-32 -top-24 w-[34rem] opacity-[0.05] pointer-events-none select-none" aria-hidden="true">
        <img src="/images/logo-mark.png" alt="" class="w-full h-auto">
    </div>
    <div class="relative container-site grid lg:grid-cols-2 gap-14 items-center">
        <div class="reveal">
            <nav aria-label="Breadcrumb" class="mb-5">
                <ol class="flex items-center gap-2 text-xs text-ivory/60">
                    <li><a href="{{ route('home') }}" class="hover:text-gold-300 transition-colors">Home</a></li>
                    <li aria-hidden="true" class="text-gold-600">/</li>
                    <li><a href="{{ route('admissions') }}" class="hover:text-gold-300 transition-colors">Admissions</a></li>
                    <li aria-hidden="true" class="text-gold-600">/</li>
                    <li><span class="text-ivory/85" aria-current="page">Book a Tour</span></li>
                </ol>
            </nav>
            <p class="eyebrow !text-gold-400">Begin the Journey</p>
            <h1 class="font-display font-semibold text-3xl sm:text-4xl lg:text-[44px] mt-3 leading-tight">
                Give Your Child the Education They Deserve
            </h1>
            <p class="mt-6 text-ivory/75 leading-relaxed max-w-lg">
                Leave your details and our admissions team will contact you within 24 hours to answer your questions
                and arrange your personal school tour.
            </p>
            <div class="mt-10 space-y-4">
                <a href="tel:+201277771119" data-track="call_click" data-label="book-tour-page" class="flex items-center gap-4 group">
                    <span class="w-11 h-11 rounded-full bg-gold-500/15 border border-gold-600/40 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                    </span>
                    <span>
                        <span class="block text-xs text-ivory/60 uppercase tracking-wider">Admissions Hotline</span>
                        <span class="block font-semibold text-lg group-hover:text-gold-300 transition-colors">0127 777 1119</span>
                    </span>
                </a>
                <a href="https://wa.me/201277771119" data-track="whatsapp_click" data-label="book-tour-page" class="flex items-center gap-4 group">
                    <span class="w-11 h-11 rounded-full bg-gold-500/15 border border-gold-600/40 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-gold-400" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </span>
                    <span>
                        <span class="block text-xs text-ivory/60 uppercase tracking-wider">WhatsApp</span>
                        <span class="block font-semibold text-lg group-hover:text-gold-300 transition-colors">Message us directly</span>
                    </span>
                </a>
            </div>

            <ul class="mt-10 space-y-3 text-sm text-ivory/75">
                <li class="flex items-center gap-3">
                    <svg class="w-4 h-4 text-gold-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    A personal tour — not a group walk-through
                </li>
                <li class="flex items-center gap-3">
                    <svg class="w-4 h-4 text-gold-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Meet stage leaders and see real classrooms
                </li>
                <li class="flex items-center gap-3">
                    <svg class="w-4 h-4 text-gold-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    All admissions questions answered on the spot
                </li>
            </ul>
        </div>

        <div class="reveal">
            @include('partials.lead-form')
        </div>
    </div>
</section>

@endsection
