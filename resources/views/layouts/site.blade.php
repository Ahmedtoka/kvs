<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Knowledge Valley International School — A British International School in Giza, Egypt')</title>
    <meta name="description" content="@yield('description', 'KVS is a top-tier British curriculum international school in Giza, Egypt — accredited by Cambridge, Pearson Edexcel, Oxford AQA and the British Council. Book your school tour today.')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" type="image/png" href="/img/logo-mark.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @if (config('services.ga4.measurement_id'))
    {{-- Google Analytics 4 --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.ga4.measurement_id') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ config('services.ga4.measurement_id') }}');
    </script>
    @endif
</head>
<body class="pb-16 sm:pb-0 bg-ivory">

<a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:z-[100] focus:bg-gold-500 focus:text-maroon-950 focus:px-4 focus:py-2">Skip to main content</a>

@include('partials.topbar')
@include('partials.header')

<main id="main">
    @yield('content')
</main>

@unless (View::hasSection('hide-cta-band'))
    @include('partials.cta-band')
@endunless

@include('partials.footer')
@include('partials.floats')

</body>
</html>
