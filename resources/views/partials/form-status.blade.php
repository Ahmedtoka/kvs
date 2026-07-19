{{-- Success / error feedback for public forms. Pass ['dark' => true] on maroon backgrounds. --}}
@php $isDark = $dark ?? false; @endphp

@if (function_exists('session') && session('lead_success'))
<div data-form-status class="mb-5 rounded-sm px-4 py-3.5 text-sm font-medium flex gap-3 {{ $isDark ? 'bg-gold-500/15 border border-gold-500/50 text-gold-200' : 'bg-gold-100 border border-gold-500/60 text-gold-900' }}" role="status">
    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    <span>{{ session('lead_success') }}</span>
</div>
<script>document.addEventListener('DOMContentLoaded', function () { var el = document.querySelector('[data-form-status]'); if (el) el.scrollIntoView({ block: 'center' }); });</script>
@endif

@if (isset($errors) && $errors->any())
<div data-form-status class="mb-5 rounded-sm px-4 py-3.5 text-sm {{ $isDark ? 'bg-maroon-900/80 border border-maroon-400/50 text-ivory' : 'bg-maroon-50 border border-maroon-300 text-maroon-800' }}" role="alert">
    <ul class="list-disc ms-4 space-y-1">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
<script>document.addEventListener('DOMContentLoaded', function () { var el = document.querySelector('[data-form-status]'); if (el) el.scrollIntoView({ block: 'center' }); });</script>
@endif
