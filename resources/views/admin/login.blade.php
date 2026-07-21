<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login — KVS</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/png" href="/img/logo-mark.png">
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-dvh bg-maroon-950 flex items-center justify-center p-5 relative overflow-hidden">
    <div class="absolute -right-40 -bottom-48 w-[42rem] opacity-[0.05] pointer-events-none select-none" aria-hidden="true">
        <img src="/img/logo-mark.png" alt="">
    </div>

    <div class="relative w-full max-w-md">
        <div class="text-center mb-8">
            <img src="/img/logo-mark.png" alt="KVS" class="h-20 w-auto mx-auto">
            <h1 class="font-display text-2xl font-bold text-ivory mt-4">KVS Admin Panel</h1>
            <p class="text-sm text-ivory/60 mt-1">Knowledge Valley International School</p>
        </div>

        <form method="POST" action="{{ route('admin.login.attempt') }}" class="bg-ivory rounded-sm shadow-2xl p-8">
            @csrf
            @if ($errors->any())
            <div class="mb-5 bg-maroon-50 border border-maroon-300 text-maroon-800 text-sm rounded-sm px-4 py-3" role="alert">
                {{ $errors->first() }}
            </div>
            @endif

            <div class="space-y-5">
                <div>
                    <label for="email" class="block text-sm font-medium mb-1.5 text-charcoal-800">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                           class="w-full h-12 px-4 rounded-sm border border-beige-300 bg-white focus:border-gold-600 focus:ring-2 focus:ring-gold-500/30 focus:outline-none transition-colors">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium mb-1.5 text-charcoal-800">Password</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password"
                           class="w-full h-12 px-4 rounded-sm border border-beige-300 bg-white focus:border-gold-600 focus:ring-2 focus:ring-gold-500/30 focus:outline-none transition-colors">
                </div>
                <label class="flex items-center gap-2.5 text-sm text-charcoal-700 cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 accent-maroon-800"> Remember me
                </label>
                <button type="submit" class="btn-gold w-full !py-3.5">Sign In</button>
            </div>
        </form>

        <p class="text-center text-xs text-ivory/40 mt-6">Authorized staff only</p>
    </div>
</body>
</html>
