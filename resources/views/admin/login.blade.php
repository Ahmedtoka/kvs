<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login — Knowledge Valley International School</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="/favicon.ico" sizes="any">
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-maroon-950 flex items-center justify-center p-5">

<main class="w-full max-w-md">
    <div class="text-center mb-8">
        <img src="/images/logo-mark.png" alt="KVS" class="h-16 w-auto mx-auto">
        <h1 class="font-display font-bold text-2xl text-ivory mt-4">KVS Admin</h1>
        <p class="text-sm text-ivory/60 mt-1">Admissions leads dashboard</p>
    </div>

    <form method="POST" action="{{ route('login.attempt') }}" class="bg-ivory rounded-sm shadow-2xl p-8">
        @csrf

        <div class="space-y-5">
            <div>
                <label for="email" class="block text-sm font-medium text-charcoal-800 mb-1.5">Email</label>
                <input type="email" id="email" name="email" required autofocus autocomplete="username" value="{{ old('email') }}"
                       class="w-full h-12 px-4 rounded-sm border @error('email') border-red-500 @else border-beige-300 @enderror bg-white text-charcoal-800 focus:border-gold-600 focus:ring-2 focus:ring-gold-500/30 focus:outline-none transition-colors">
                @error('email')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-charcoal-800 mb-1.5">Password</label>
                <input type="password" id="password" name="password" required autocomplete="current-password"
                       class="w-full h-12 px-4 rounded-sm border border-beige-300 bg-white text-charcoal-800 focus:border-gold-600 focus:ring-2 focus:ring-gold-500/30 focus:outline-none transition-colors">
            </div>

            <label class="flex items-center gap-2.5 text-sm text-charcoal-700 cursor-pointer select-none">
                <input type="checkbox" name="remember" value="1" class="w-4 h-4 accent-maroon-800">
                Remember me
            </label>

            <button type="submit" class="btn-maroon w-full !py-4">Sign In</button>
        </div>
    </form>

    <p class="text-center mt-6">
        <a href="{{ route('home') }}" class="text-sm text-ivory/50 hover:text-gold-300 transition-colors">&larr; Back to website</a>
    </p>
</main>

</body>
</html>
