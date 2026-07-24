@extends('admin.layout')
@section('title', 'Site Settings')
@section('content')
<h1 class="font-display text-2xl sm:text-3xl font-bold text-maroon-900">Site Settings</h1>
<p class="text-sm text-charcoal-600 mt-1">Contact details, social links and tracking IDs — updates appear on the website instantly.</p>

@if (session('success'))
<div class="mt-5 bg-emerald-50 border border-emerald-300 text-emerald-800 text-sm rounded-sm px-4 py-3">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('admin.settings.update') }}" class="mt-6 space-y-6">
    @csrf @method('PATCH')
    @foreach ($settings as $group => $items)
    <div class="bg-white rounded-sm shadow-sm border border-beige-200 overflow-hidden">
        <div class="px-5 py-3.5 border-b border-beige-100">
            <h2 class="font-semibold text-maroon-900">{{ \App\Models\Setting::GROUPS[$group] ?? ucfirst($group) }}</h2>
            @if (! empty(\App\Models\Setting::GROUP_HELP[$group]))
            <p class="text-xs text-charcoal-500 mt-0.5">{{ \App\Models\Setting::GROUP_HELP[$group] }}</p>
            @endif
        </div>
        <div class="p-5 grid sm:grid-cols-2 gap-x-4 gap-y-5">
            @foreach ($items as $s)
            @php $help = \App\Models\Setting::HELP[$s->key] ?? null; @endphp
            <div class="{{ $s->type === 'textarea' ? 'sm:col-span-2' : '' }}">
                <label class="flex items-center gap-2 text-xs font-medium text-charcoal-600 mb-1" for="s-{{ $s->key }}">
                    {{ \App\Models\Setting::LABELS[$s->key] ?? $s->key }}
                    @if ($group === 'integrations')
                    <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded-full {{ filled($s->value) ? 'bg-emerald-50 text-emerald-700' : 'bg-beige-100 text-charcoal-500' }}">
                        {{ filled($s->value) ? 'Active' : 'Off' }}
                    </span>
                    @endif
                </label>
                @if ($s->type === 'textarea')
                <textarea id="s-{{ $s->key }}" name="settings[{{ $s->key }}]" rows="2" class="w-full px-3 py-2 rounded-sm border border-beige-300 bg-white text-sm focus:border-gold-600 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">{{ $s->value }}</textarea>
                @else
                <input id="s-{{ $s->key }}" type="{{ in_array($s->type, ['email','url','tel']) ? $s->type : 'text' }}" name="settings[{{ $s->key }}]" value="{{ $s->value }}"
                       class="w-full h-10 px-3 rounded-sm border border-beige-300 bg-white text-sm focus:border-gold-600 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                @endif
                @if ($help)
                <p class="text-[11px] text-charcoal-400 mt-1">{{ $help }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
    <div class="flex items-center gap-3">
        <button class="btn-gold !py-3 !px-8">Save Settings</button>
        <span class="text-xs text-charcoal-500">Changes go live on the website immediately.</span>
    </div>
</form>
@endsection
