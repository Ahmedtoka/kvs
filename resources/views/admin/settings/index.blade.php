@extends('admin.layout')
@section('title', 'Site Settings')
@section('content')
<h1 class="font-display text-2xl sm:text-3xl font-bold text-maroon-900">Site Settings</h1>
<p class="text-sm text-charcoal-600 mt-1">Contact details, social links and integrations — updates appear on the website instantly.</p>

<form method="POST" action="{{ route('admin.settings.update') }}" class="mt-6 space-y-6">
    @csrf @method('PATCH')
    @foreach ($settings as $group => $items)
    <div class="bg-white rounded-sm shadow-sm border border-beige-200 overflow-hidden">
        <div class="px-5 py-3 border-b border-beige-100 font-semibold text-maroon-900">{{ \App\Models\Setting::GROUPS[$group] ?? ucfirst($group) }}</div>
        <div class="p-5 grid sm:grid-cols-2 gap-4">
            @foreach ($items as $s)
            <div class="{{ $s->type === 'textarea' ? 'sm:col-span-2' : '' }}">
                <label class="block text-xs font-medium text-charcoal-600 mb-1" for="s-{{ $s->key }}">{{ \App\Models\Setting::LABELS[$s->key] ?? $s->key }}</label>
                @if ($s->type === 'textarea')
                <textarea id="s-{{ $s->key }}" name="settings[{{ $s->key }}]" rows="2" class="w-full px-3 py-2 rounded-sm border border-beige-300 bg-white text-sm">{{ $s->value }}</textarea>
                @else
                <input id="s-{{ $s->key }}" type="{{ in_array($s->type, ['email','url','tel']) ? $s->type : 'text' }}" name="settings[{{ $s->key }}]" value="{{ $s->value }}" class="w-full h-10 px-3 rounded-sm border border-beige-300 bg-white text-sm">
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
    <button class="btn-gold !py-3 !px-8">Save Settings</button>
</form>
@endsection
