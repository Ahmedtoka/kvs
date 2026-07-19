<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — KVS Admin</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/png" href="/images/logo-mark.png">
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-dvh bg-beige-100 lg:flex">

    {{-- Sidebar --}}
    <aside class="lg:w-64 shrink-0 bg-maroon-950 text-ivory lg:min-h-dvh">
        <div class="flex items-center justify-between lg:justify-start gap-3 px-5 py-4 border-b border-gold-700/20">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <img src="/images/logo-mark.png" alt="" class="h-9 w-auto">
                <span class="font-display font-bold">KVS Admin</span>
            </a>
            <button id="admin-menu-btn" class="lg:hidden p-2 -mr-2 cursor-pointer" aria-expanded="false" aria-controls="admin-nav" aria-label="Menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5"/></svg>
            </button>
        </div>

        @php
            $nav = [
                ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'match' => 'admin.dashboard',
                 'icon' => 'M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z'],
                ['route' => 'admin.leads.index', 'label' => 'Leads', 'match' => 'admin.leads.*',
                 'icon' => 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z'],
                ['route' => 'admin.careers.index', 'label' => 'Career Applications', 'match' => 'admin.careers.*',
                 'icon' => 'M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m16.5 0V8.706m-16.5 5.444a2.18 2.18 0 01-.75-1.661V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.883m7.5 0a48.667 48.667 0 00-7.5 0'],
                ['route' => 'admin.password.edit', 'label' => 'Change Password', 'match' => 'admin.password.*',
                 'icon' => 'M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z'],
            ];
        @endphp

        <nav id="admin-nav" class="hidden lg:block px-3 py-4 space-y-1">
            @foreach ($nav as $item)
            <a href="{{ route($item['route']) }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-sm text-sm font-medium transition-colors {{ request()->routeIs($item['match']) ? 'bg-gold-500 text-maroon-950' : 'text-ivory/80 hover:bg-maroon-900 hover:text-ivory' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/></svg>
                {{ $item['label'] }}
            </a>
            @endforeach

            <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-3.5 py-2.5 rounded-sm text-sm font-medium text-ivory/80 hover:bg-maroon-900 hover:text-ivory transition-colors">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                View Website
            </a>

            <form method="POST" action="{{ route('admin.logout') }}" class="pt-3 mt-3 border-t border-gold-700/20">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-sm text-sm font-medium text-ivory/80 hover:bg-maroon-900 hover:text-ivory transition-colors cursor-pointer">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                    Sign Out
                </button>
            </form>
        </nav>
    </aside>

    {{-- Main --}}
    <main class="grow p-5 sm:p-8 max-w-full overflow-x-auto">
        @if (session('success'))
        <div class="mb-6 bg-white border-l-4 border-gold-500 text-charcoal-800 text-sm rounded-sm px-4 py-3 shadow-sm" role="status">
            {{ session('success') }}
        </div>
        @endif

        @yield('content')
    </main>

    <script>
        const b = document.getElementById('admin-menu-btn'), n = document.getElementById('admin-nav');
        if (b && n) b.addEventListener('click', () => {
            const open = n.classList.toggle('hidden') === false;
            b.setAttribute('aria-expanded', String(open));
        });
    </script>
</body>
</html>
