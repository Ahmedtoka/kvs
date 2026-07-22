@extends('admin.layout')
@section('title', 'Sales Reports')
@section('content')
<div class="flex items-center justify-between gap-4">
    <div>
        <h1 class="font-display text-2xl sm:text-3xl font-bold text-maroon-900">Sales Reports</h1>
        <p class="text-sm text-charcoal-600 mt-1">Pipeline snapshot — {{ now()->format('D, d M Y H:i') }}.</p>
    </div>
    <button onclick="window.print()" class="btn-maroon !py-2.5 !px-5 !text-xs">Print / Share</button>
</div>

<div class="mt-6 grid grid-cols-2 lg:grid-cols-4 gap-4">
    @foreach ([['Total leads', $totals['total']], ['New', $totals['new']], ['Working', $totals['working']], ['Tour booked', $totals['tour_booked']], ['Toured', $totals['toured']], ['Enrolled', $totals['enrolled']], ['Lost', $totals['lost']], ['Conversion', $conv . '%']] as $c)
    <div class="bg-white rounded-sm shadow-sm border border-beige-200 p-5">
        <p class="text-3xl font-display font-bold text-maroon-900">{{ $c[1] }}</p>
        <p class="text-xs text-charcoal-600 mt-1">{{ $c[0] }}</p>
    </div>
    @endforeach
</div>
<p class="mt-3 text-xs text-charcoal-500">This week: {{ $totals['this_week'] }} new leads · Last 30 days: {{ $totals['this_month'] }}.</p>

<div class="mt-8 bg-white rounded-sm shadow-sm border border-beige-200 overflow-hidden">
    <div class="px-5 py-3 border-b border-beige-100 font-semibold text-maroon-900">Performance by Sales Agent</div>
    <div class="overflow-x-auto"><table class="w-full text-sm">
        <thead class="bg-beige-100 text-charcoal-700 text-xs uppercase"><tr>
            <th class="text-left px-5 py-2">Agent</th><th class="px-3 py-2">Total</th><th class="px-3 py-2">New</th><th class="px-3 py-2">Working</th><th class="px-3 py-2">Tour booked</th><th class="px-3 py-2">Toured</th><th class="px-3 py-2">Enrolled</th>
        </tr></thead>
        <tbody>
        @forelse ($agents as $a)
        <tr class="border-t border-beige-100">
            <td class="px-5 py-2.5 font-medium">{{ $a->name }} <span class="text-xs text-charcoal-500">({{ \App\Models\User::ROLES[$a->role] ?? $a->role }})</span></td>
            <td class="text-center">{{ $a->leads_count }}</td><td class="text-center">{{ $a->new_count }}</td><td class="text-center">{{ $a->working_count }}</td><td class="text-center">{{ $a->booked_count }}</td><td class="text-center">{{ $a->toured_count }}</td><td class="text-center font-semibold text-maroon-800">{{ $a->enrolled_count }}</td>
        </tr>
        @empty
        <tr><td colspan="7" class="px-5 py-6 text-center text-charcoal-600">No sales agents yet — add them in Users &amp; Roles.</td></tr>
        @endforelse
        </tbody>
    </table></div>
</div>

<div class="mt-8 grid lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-sm shadow-sm border border-beige-200 p-5">
        <p class="font-semibold text-maroon-900 mb-3">Leads by Source</p>
        @forelse ($bySource as $s)
        <div class="flex justify-between text-sm py-1.5 border-b border-beige-100 last:border-0"><span class="truncate pr-3">{{ $s->s }}</span><span class="font-semibold">{{ $s->c }}</span></div>
        @empty <p class="text-sm text-charcoal-600">No data yet.</p> @endforelse
    </div>
    <div class="bg-white rounded-sm shadow-sm border border-beige-200 p-5">
        <p class="font-semibold text-maroon-900 mb-3">Leads by Type</p>
        @foreach ($byType as $k => $c)
        <div class="flex justify-between text-sm py-1.5 border-b border-beige-100 last:border-0"><span>{{ \App\Models\Lead::TYPES[$k] ?? $k }}</span><span class="font-semibold">{{ $c }}</span></div>
        @endforeach
    </div>
</div>
@endsection
