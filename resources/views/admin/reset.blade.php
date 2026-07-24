@extends('admin.layout')

@section('title', 'Reset Data')

@section('content')
<div>
    <h1 class="font-display text-2xl sm:text-3xl font-bold text-maroon-900">Reset Data</h1>
    <p class="text-sm text-charcoal-600 mt-1">Clear test / collected data and start fresh. Pick exactly what to wipe — your accounts, settings and content always stay safe.</p>
</div>

@if ($errors->any())
<div class="mt-5 bg-red-50 border border-red-300 text-red-800 text-sm rounded-sm px-4 py-3">
    <ul class="list-disc ms-4 space-y-1">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif
@if (session('success'))
<div class="mt-5 bg-emerald-50 border border-emerald-300 text-emerald-800 text-sm rounded-sm px-4 py-3">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('admin.reset.perform') }}" class="mt-6"
      onsubmit="return confirm('This permanently deletes the selected data and cannot be undone. Continue?');">
    @csrf

    <div class="grid lg:grid-cols-2 gap-6">
        {{-- Choose what to clear --}}
        <div class="bg-white rounded-sm shadow-sm border-2 border-red-200 p-6">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                <h2 class="font-display text-lg font-bold text-red-700">Choose what to delete</h2>
            </div>
            <p class="text-xs text-charcoal-500 mt-1">Tick a box to include it. Everything is selected by default.</p>
            <div class="mt-4 space-y-3">
                @foreach ($groups as $key => $g)
                <label class="flex items-start gap-3 p-3 rounded-sm border border-beige-200 hover:border-red-300 cursor-pointer transition-colors">
                    <input type="checkbox" name="targets[]" value="{{ $key }}" checked class="mt-0.5 h-4 w-4 rounded border-beige-300 text-red-600 focus:ring-red-500">
                    <span class="grow">
                        <span class="flex items-center justify-between gap-3">
                            <span class="text-sm font-semibold text-charcoal-800">{{ $g['label'] }}</span>
                            <span class="text-xs font-semibold text-red-700 tabular-nums shrink-0">{{ number_format($g['rows']) }} rows</span>
                        </span>
                        <span class="block text-[11px] text-charcoal-500 mt-0.5">{{ $g['note'] }}</span>
                    </span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- What stays --}}
        <div class="bg-white rounded-sm shadow-sm border-2 border-green-200 p-6">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <h2 class="font-display text-lg font-bold text-green-700">Always stays safe</h2>
            </div>
            <p class="text-xs text-charcoal-500 mt-1">Never touched by a reset.</p>
            <div class="mt-4 space-y-2">
                @foreach ($keep as $k)
                <div class="flex items-center justify-between gap-3 py-2 border-b border-beige-100 last:border-0">
                    <span class="text-sm text-charcoal-800">{{ $k['label'] }}</span>
                    <span class="text-sm font-semibold text-green-700 tabular-nums shrink-0">{{ number_format($k['rows']) }} kept</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Confirm + action --}}
    <div class="mt-6 bg-maroon-950 text-ivory rounded-sm p-6 sm:p-8">
        <h2 class="font-display text-xl font-bold text-gold-400">Confirm reset</h2>
        <p class="mt-2 text-sm text-ivory/80 max-w-2xl">This cannot be undone. The usual moment to run this is once, right before you go live, so you begin collecting real visitor and lead data from a clean slate.</p>
        <div class="mt-5 flex flex-col sm:flex-row sm:items-end gap-4">
            <div class="grow max-w-xs">
                <label for="confirmation" class="block text-sm font-medium mb-1.5">Type <span class="font-bold text-gold-400">RESET</span> to confirm</label>
                <input type="text" id="confirmation" name="confirmation" autocomplete="off" placeholder="RESET"
                       class="w-full h-12 px-4 rounded-sm border border-maroon-700 bg-maroon-900 text-ivory placeholder:text-ivory/40 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none uppercase tracking-widest">
            </div>
            <button type="submit" class="inline-flex items-center justify-center gap-2 h-12 px-7 rounded-sm bg-red-600 hover:bg-red-700 text-white font-semibold transition-colors cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165"/></svg>
                Clear selected data
            </button>
        </div>
    </div>
</form>
@endsection
