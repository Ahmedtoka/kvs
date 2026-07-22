@extends('admin.layout')

@section('title', 'My Schedule')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
    <div>
        <h1 class="font-display text-2xl sm:text-3xl font-bold text-maroon-900">My Schedule</h1>
        <p class="text-sm text-charcoal-600 mt-1">Your call-backs and tour appointments, all in one place.</p>
    </div>
    @if (auth()->user()->role !== 'sales_agent')
    <form method="GET" class="flex items-end gap-3 bg-white rounded-sm shadow-sm border border-beige-200 p-3">
        <div>
            <label for="agent" class="block text-xs font-medium text-charcoal-600 mb-1">Agent</label>
            <select id="agent" name="agent" onchange="this.form.submit()" class="h-10 px-3 rounded-sm border border-beige-300 bg-white text-sm">
                <option value="">All agents</option>
                <option value="unassigned" @selected(request('agent') === 'unassigned')>Unassigned</option>
                @foreach ($agents as $ag)
                <option value="{{ $ag->id }}" @selected((string) request('agent') === (string) $ag->id)>{{ $ag->name }}</option>
                @endforeach
            </select>
        </div>
    </form>
    @endif
</div>

{{-- Count tiles --}}
<div class="mt-6 grid grid-cols-2 lg:grid-cols-4 gap-4">
    @php $tiles = [
        ['Overdue calls', $overdue->count(), 'text-red-700'],
        ['Today\'s calls', $todayCalls->count(), 'text-gold-700'],
        ['Upcoming calls', $upcoming->count(), 'text-maroon-900'],
        ['Tour appointments', $tours->count(), 'text-maroon-900'],
    ]; @endphp
    @foreach ($tiles as [$label, $value, $color])
    <div class="bg-white rounded-sm shadow-sm border border-beige-200 p-5">
        <p class="text-xs font-medium text-charcoal-600 uppercase tracking-wide">{{ $label }}</p>
        <p class="mt-2 font-display text-3xl font-bold {{ $color }} tabular-nums">{{ $value }}</p>
    </div>
    @endforeach
</div>

{{-- Call-back groups --}}
@php $callGroups = [
    ['title' => 'Overdue', 'sub' => 'Past due — reach out first', 'items' => $overdue, 'dot' => 'bg-red-500', 'time' => 'text-red-700'],
    ['title' => 'Today', 'sub' => 'Scheduled for today', 'items' => $todayCalls, 'dot' => 'bg-gold-500', 'time' => 'text-gold-700'],
    ['title' => 'Upcoming', 'sub' => 'Later on', 'items' => $upcoming, 'dot' => 'bg-charcoal-400', 'time' => 'text-charcoal-700'],
]; @endphp

@foreach ($callGroups as $g)
<div class="mt-8">
    <div class="flex items-center gap-2.5 mb-3">
        <span class="w-2.5 h-2.5 rounded-full {{ $g['dot'] }}"></span>
        <h2 class="font-display text-lg font-bold text-maroon-900">{{ $g['title'] }} call-backs</h2>
        <span class="text-sm text-charcoal-500">— {{ $g['sub'] }}</span>
    </div>
    <div class="space-y-3">
        @forelse ($g['items'] as $lead)
        @php $lastNote = $lead->activities->firstWhere('type', 'note'); @endphp
        <div class="bg-white rounded-sm shadow-sm border border-beige-200 p-4 flex flex-col sm:flex-row sm:items-center gap-4">
            <div class="sm:w-40 shrink-0">
                <p class="font-display text-lg font-bold {{ $g['time'] }} tabular-nums leading-none">{{ $lead->follow_up_at->format('H:i') }}</p>
                <p class="text-xs text-charcoal-500 mt-0.5">{{ $lead->follow_up_at->format('D, d M Y') }}</p>
            </div>
            <div class="grow min-w-0">
                <div class="flex flex-wrap items-center gap-x-3 gap-y-1">
                    <span class="font-semibold text-charcoal-800">{{ $lead->parent_name }}</span>
                    <span class="text-xs px-2 py-0.5 rounded-full bg-beige-100 text-charcoal-700">{{ \App\Models\Lead::TYPES[$lead->type] ?? $lead->type }}</span>
                    <span class="text-xs px-2 py-0.5 rounded-full bg-beige-100 text-charcoal-700">{{ \App\Models\Lead::STATUSES[$lead->status] ?? $lead->status }}</span>
                    @if (auth()->user()->role !== 'sales_agent' && $lead->assignedAgent)
                    <span class="text-xs px-2 py-0.5 rounded-full bg-maroon-50 text-maroon-800">{{ $lead->assignedAgent->name }}</span>
                    @endif
                </div>
                @if ($lastNote)
                <p class="text-sm text-charcoal-600 mt-1 truncate">&ldquo;{{ $lastNote->body }}&rdquo;</p>
                @endif
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <a href="tel:{{ $lead->phone }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-maroon-800 hover:text-maroon-600 px-3 py-2 rounded-sm border border-beige-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                    Call
                </a>
                <a href="https://wa.me/2{{ preg_replace('/\D/', '', $lead->phone) }}" target="_blank" class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#128C7E] hover:underline px-3 py-2 rounded-sm border border-beige-200">WhatsApp</a>
                <a href="{{ route('admin.leads.index', ['q' => $lead->phone]) }}" class="text-sm font-semibold text-charcoal-600 hover:text-maroon-700 px-3 py-2">Open &rarr;</a>
            </div>
        </div>
        @empty
        <p class="text-sm text-charcoal-500 bg-white rounded-sm border border-beige-200 px-4 py-6 text-center">Nothing here.</p>
        @endforelse
    </div>
</div>
@endforeach

{{-- Tour appointments --}}
<div class="mt-10">
    <div class="flex items-center gap-2.5 mb-3">
        <span class="w-2.5 h-2.5 rounded-full bg-maroon-700"></span>
        <h2 class="font-display text-lg font-bold text-maroon-900">Tour appointments</h2>
        <span class="text-sm text-charcoal-500">— confirmed visits, upcoming</span>
    </div>
    <div class="space-y-3">
        @forelse ($tours as $lead)
        <div class="bg-white rounded-sm shadow-sm border border-beige-200 p-4 flex flex-col sm:flex-row sm:items-center gap-4 border-l-4 border-l-maroon-700">
            <div class="sm:w-40 shrink-0">
                <p class="font-display text-lg font-bold text-maroon-800 tabular-nums leading-none">{{ $lead->tour_at->format('H:i') }}</p>
                <p class="text-xs text-charcoal-500 mt-0.5">{{ $lead->tour_at->format('D, d M Y') }}</p>
            </div>
            <div class="grow min-w-0">
                <div class="flex flex-wrap items-center gap-x-3 gap-y-1">
                    <span class="font-semibold text-charcoal-800">{{ $lead->parent_name }}</span>
                    @if ($lead->student_name)<span class="text-sm text-charcoal-600">for {{ $lead->student_name }}</span>@endif
                    @if ($lead->year_group)<span class="text-xs px-2 py-0.5 rounded-full bg-beige-100 text-charcoal-700">{{ $lead->year_group }}</span>@endif
                    @if (auth()->user()->role !== 'sales_agent' && $lead->assignedAgent)
                    <span class="text-xs px-2 py-0.5 rounded-full bg-maroon-50 text-maroon-800">{{ $lead->assignedAgent->name }}</span>
                    @endif
                </div>
                <p class="text-xs text-charcoal-500 mt-1">Status: {{ \App\Models\Lead::STATUSES[$lead->status] ?? $lead->status }}</p>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <a href="tel:{{ $lead->phone }}" class="text-sm font-semibold text-maroon-800 hover:text-maroon-600 px-3 py-2 rounded-sm border border-beige-200">Call</a>
                <a href="{{ route('admin.leads.index', ['q' => $lead->phone]) }}" class="text-sm font-semibold text-charcoal-600 hover:text-maroon-700 px-3 py-2">Open &rarr;</a>
            </div>
        </div>
        @empty
        <p class="text-sm text-charcoal-500 bg-white rounded-sm border border-beige-200 px-4 py-6 text-center">No upcoming tours scheduled.</p>
        @endforelse
    </div>
</div>
@endsection
