@extends('admin.layout')

@section('title', 'Leads')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="font-display text-2xl sm:text-3xl font-bold text-maroon-900">Leads</h1>
        <p class="text-sm text-charcoal-600 mt-1">{{ $leads->total() }} lead(s) found.</p>
    </div>
    <a href="{{ route('admin.leads.export') }}" class="btn-maroon !py-2.5 !px-5 !text-xs self-start sm:self-auto">Export CSV</a>
</div>

{{-- Filters --}}
<form method="GET" class="mt-6 bg-white rounded-sm shadow-sm border border-beige-200 p-4 flex flex-wrap items-end gap-3">
    <div>
        <label for="f-status" class="block text-xs font-medium text-charcoal-600 mb-1">Status</label>
        <select id="f-status" name="status" class="h-10 px-3 rounded-sm border border-beige-300 bg-white text-sm">
            <option value="">All</option>
            @foreach (\App\Models\Lead::STATUSES as $key => $label)
            <option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="f-type" class="block text-xs font-medium text-charcoal-600 mb-1">Type</label>
        <select id="f-type" name="type" class="h-10 px-3 rounded-sm border border-beige-300 bg-white text-sm">
            <option value="">All</option>
            @foreach (\App\Models\Lead::TYPES as $key => $label)
            <option value="{{ $key }}" @selected(request('type') === $key)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    @if (auth()->user()->role !== 'sales_agent')
    <div>
        <label for="f-agent" class="block text-xs font-medium text-charcoal-600 mb-1">Agent</label>
        <select id="f-agent" name="agent" class="h-10 px-3 rounded-sm border border-beige-300 bg-white text-sm">
            <option value="">All</option>
            <option value="unassigned" @selected(request('agent') === 'unassigned')>Unassigned</option>
            @foreach ($agents as $ag)
            <option value="{{ $ag->id }}" @selected((string) request('agent') === (string) $ag->id)>{{ $ag->name }}</option>
            @endforeach
        </select>
    </div>
    @endif
    <div>
        <label for="f-from" class="block text-xs font-medium text-charcoal-600 mb-1">From</label>
        <input id="f-from" type="date" name="from" value="{{ request('from') }}" class="h-10 px-3 rounded-sm border border-beige-300 bg-white text-sm">
    </div>
    <div>
        <label for="f-to" class="block text-xs font-medium text-charcoal-600 mb-1">To</label>
        <input id="f-to" type="date" name="to" value="{{ request('to') }}" class="h-10 px-3 rounded-sm border border-beige-300 bg-white text-sm">
    </div>
    <div class="grow min-w-40">
        <label for="f-q" class="block text-xs font-medium text-charcoal-600 mb-1">Search</label>
        <input id="f-q" type="text" name="q" value="{{ request('q') }}" placeholder="Name, phone or email…"
               class="w-full h-10 px-3 rounded-sm border border-beige-300 bg-white text-sm">
    </div>
    <button type="submit" class="btn-gold !py-2.5 !px-5 !text-xs">Filter</button>
    @if (request()->hasAny(['status', 'type', 'q', 'agent', 'from', 'to']))
    <a href="{{ route('admin.leads.index') }}" class="text-sm text-charcoal-600 hover:text-maroon-700 py-2.5">Reset</a>
    @endif
</form>

{{-- Leads list --}}
<div class="mt-6 space-y-3">
    @forelse ($leads as $lead)
    <details class="bg-white rounded-sm shadow-sm border border-beige-200 group">
        <summary class="flex flex-wrap items-center gap-x-5 gap-y-2 px-5 py-4 cursor-pointer list-none [&::-webkit-details-marker]:hidden">
            <span class="inline-block w-2 h-2 rounded-full {{ $lead->status === 'new' ? 'bg-gold-500' : 'bg-beige-300' }}" title="{{ $lead->status }}"></span>
            <span class="font-semibold text-charcoal-800 min-w-36">{{ $lead->parent_name }}</span>
            <a href="tel:{{ $lead->phone }}" class="tabular-nums text-maroon-800 font-medium" onclick="event.stopPropagation()">{{ $lead->phone }}</a>
            <span class="text-xs px-2.5 py-1 rounded-full bg-beige-100 text-charcoal-700">{{ \App\Models\Lead::TYPES[$lead->type] ?? $lead->type }}</span>
            @if ($lead->stage || $lead->year_group)
            <span class="text-xs text-charcoal-600">{{ $lead->stage ?: '' }} {{ $lead->year_group ?: '' }}</span>
            @endif
            <span class="text-xs px-2.5 py-1 rounded-full font-semibold {{ $lead->status === 'new' ? 'bg-gold-100 text-gold-800' : ($lead->status === 'enrolled' ? 'bg-maroon-100 text-maroon-800' : 'bg-beige-100 text-charcoal-700') }}">
                {{ \App\Models\Lead::STATUSES[$lead->status] ?? $lead->status }}
            </span>
            @if ($lead->assignedAgent)<span class="text-xs px-2.5 py-1 rounded-full bg-maroon-50 text-maroon-800 font-medium">{{ $lead->assignedAgent->name }}</span>@else<span class="text-xs px-2.5 py-1 rounded-full bg-red-50 text-red-700">Unassigned</span>@endif
            <span class="ms-auto text-xs text-charcoal-600 whitespace-nowrap">{{ $lead->created_at->format('d M Y, H:i') }}</span>
            <svg class="w-4 h-4 text-charcoal-600 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
        </summary>

        <div class="px-5 pb-5 border-t border-beige-100 pt-4 grid lg:grid-cols-2 gap-6">
            <div class="text-sm space-y-2">
                @if ($lead->student_name)<p><span class="text-charcoal-600">Student:</span> <span class="font-medium">{{ $lead->student_name }}</span></p>@endif
                @if ($lead->child_age)<p><span class="text-charcoal-600">Child age:</span> {{ $lead->child_age }}</p>@endif
                @if ($lead->email)<p><span class="text-charcoal-600">Email:</span> <a href="mailto:{{ $lead->email }}" class="text-maroon-800">{{ $lead->email }}</a></p>@endif
                @if ($lead->preferred_date)<p><span class="text-charcoal-600">Preferred tour date:</span> <span class="font-medium">{{ $lead->preferred_date->format('D, d M Y') }}</span></p>@endif
                @if ($lead->message)<p><span class="text-charcoal-600">Message:</span> {{ $lead->message }}</p>@endif
                @if ($lead->source)<p class="text-xs text-charcoal-600">Source: {{ $lead->source }}</p>@endif
                <p class="pt-1">
                    <a href="https://wa.me/2{{ preg_replace('/\D/', '', $lead->phone) }}" target="_blank" class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#128C7E] hover:underline">
                        WhatsApp this parent →
                    </a>
                </p>
            </div>

            <form method="POST" action="{{ route('admin.leads.update', $lead) }}" class="space-y-3">
                @csrf
                @method('PATCH')
                @if (auth()->user()->role !== 'sales_agent')
                <div>
                    <label class="block text-xs font-medium text-charcoal-600 mb-1" for="assign-{{ $lead->id }}">Assigned to</label>
                    <select id="assign-{{ $lead->id }}" name="assigned_to" class="w-full h-10 px-3 rounded-sm border border-beige-300 bg-white text-sm">
                        <option value="">— Unassigned —</option>
                        @foreach ($agents as $ag)
                        <option value="{{ $ag->id }}" @selected((int) $lead->assigned_to === (int) $ag->id)>{{ $ag->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="flex gap-3">
                    <div class="grow">
                        <label class="block text-xs font-medium text-charcoal-600 mb-1" for="status-{{ $lead->id }}">Status</label>
                        <select id="status-{{ $lead->id }}" name="status" class="w-full h-10 px-3 rounded-sm border border-beige-300 bg-white text-sm">
                            @foreach (\App\Models\Lead::STATUSES as $key => $label)
                            <option value="{{ $key }}" @selected($lead->status === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-charcoal-600 mb-1" for="notes-{{ $lead->id }}">Internal notes</label>
                    <textarea id="notes-{{ $lead->id }}" name="notes" rows="2" class="w-full px-3 py-2 rounded-sm border border-beige-300 bg-white text-sm" placeholder="Call summary, follow-up date…">{{ $lead->notes }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-medium text-charcoal-600 mb-1" for="fb-{{ $lead->id }}">Add feedback / call log</label>
                    <textarea id="fb-{{ $lead->id }}" name="feedback" rows="2" class="w-full px-3 py-2 rounded-sm border border-beige-300 bg-white text-sm" placeholder="What happened on the call? Next step?"></textarea>
                </div>
                <div class="flex items-center gap-3">
                    <button type="submit" class="btn-gold !py-2 !px-4 !text-xs">Save</button>
                    <button type="submit" form="delete-{{ $lead->id }}" class="text-xs text-maroon-600 hover:text-maroon-800 cursor-pointer"
                            onclick="return confirm('Delete this lead permanently?')">Delete</button>
                </div>
            </form>
            <form id="delete-{{ $lead->id }}" method="POST" action="{{ route('admin.leads.destroy', $lead) }}" class="hidden">
                @csrf
                @method('DELETE')
            </form>
            <div class="lg:col-span-2 border-t border-beige-100 pt-4">
                <p class="text-xs font-semibold text-charcoal-600 mb-2 uppercase tracking-wide">Lead history</p>
                <ul class="space-y-2">
                    @foreach ($lead->activities as $act)
                    <li class="text-sm flex gap-3">
                        <span class="text-xs text-charcoal-500 whitespace-nowrap w-32 shrink-0">{{ $act->created_at->format('d M Y, H:i') }}</span>
                        <span class="text-charcoal-700"><span class="font-medium">{{ optional($act->user)->name ?? 'System' }}:</span> {{ $act->body }}</span>
                    </li>
                    @endforeach
                    <li class="text-sm flex gap-3">
                        <span class="text-xs text-charcoal-500 whitespace-nowrap w-32 shrink-0">{{ $lead->created_at->format('d M Y, H:i') }}</span>
                        <span class="text-charcoal-700"><span class="font-medium">Received:</span> New {{ \App\Models\Lead::TYPES[$lead->type] ?? $lead->type }} request{{ $lead->source ? ' · '.$lead->source : '' }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </details>
    @empty
    <div class="bg-white rounded-sm shadow-sm border border-beige-200 px-5 py-14 text-center text-charcoal-600">
        No leads match these filters.
    </div>
    @endforelse
</div>

<div class="mt-6">
    {{ $leads->links() }}
</div>
@endsection
