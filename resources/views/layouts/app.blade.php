<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Knowledge Valley International School')</title>
    <meta name="description" content="@yield('meta_description', 'KVS is a top-tier British curriculum international school in Giza, Egypt — accredited by Cambridge, Pearson Edexcel, Oxford AQA and the British Council.')">
    <link rel="icon" type="image/png" href="/images/logo-mark.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="pb-16 sm:pb-0">

<a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:z-[100] focus:bg-gold-500 focus:text-maroon-950 focus:px-4 focus:py-2">Skip to main content</a>

@include('partials.topbar')
@include('partials.header')

<main id="main">
    @yield('content')
</main>

@include('partials.footer')
@include('partials.floats')

</body>
</html>
