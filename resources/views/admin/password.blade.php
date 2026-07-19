@extends('admin.layout')

@section('title', 'Change Password')

@section('content')
<h1 class="font-display text-2xl sm:text-3xl font-bold text-maroon-900">Change Password</h1>

<form method="POST" action="{{ route('admin.password.update') }}" class="mt-7 bg-white rounded-sm shadow-sm border border-beige-200 p-7 max-w-lg space-y-5">
    @csrf
    @method('PATCH')

    @if ($errors->any())
    <div class="bg-maroon-50 border border-maroon-300 text-maroon-800 text-sm rounded-sm px-4 py-3" role="alert">
        {{ $errors->first() }}
    </div>
    @endif

    <div>
        <label for="current_password" class="block text-sm font-medium mb-1.5">Current Password</label>
        <input type="password" id="current_password" name="current_password" required autocomplete="current-password"
               class="w-full h-12 px-4 rounded-sm border border-beige-300 bg-white focus:border-gold-600 focus:ring-2 focus:ring-gold-500/30 focus:outline-none transition-colors">
    </div>
    <div>
        <label for="password" class="block text-sm font-medium mb-1.5">New Password <span class="text-charcoal-600 font-normal">(min. 8 characters)</span></label>
        <input type="password" id="password" name="password" required autocomplete="new-password"
               class="w-full h-12 px-4 rounded-sm border border-beige-300 bg-white focus:border-gold-600 focus:ring-2 focus:ring-gold-500/30 focus:outline-none transition-colors">
    </div>
    <div>
        <label for="password_confirmation" class="block text-sm font-medium mb-1.5">Confirm New Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
               class="w-full h-12 px-4 rounded-sm border border-beige-300 bg-white focus:border-gold-600 focus:ring-2 focus:ring-gold-500/30 focus:outline-none transition-colors">
    </div>
    <button type="submit" class="btn-gold !py-3">Update Password</button>
</form>
@endsection
