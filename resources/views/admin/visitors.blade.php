@extends('admin.layout')

@section('title', 'Visitors')

@section('content')
<div>
    <h1 class="font-display text-2xl sm:text-3xl font-bold text-maroon-900">Visitors</h1>
    <p class="text-sm text-charcoal-600 mt-1">Every visitor, one by one — device, activity and whether they converted.</p>
</div>

{{-- Device filter --}}
@php $tabs = [
    '' => ['All', $totals['all']],
    'mobile' => ['Mobile', $totals['mobile']],
    'desktop' => ['Desktop', $totals['desktop']],
    'tablet' => ['Tablet', $totals['tablet']],
]; @endphp
<div class="mt-6 flex flex-wrap gap-2">
    @foreach ($tabs as $key => $t)
    <a href="{{ route('admin.visitors', array_filter(['device' => $key])) }}"
       class="inline-flex items-center gap-2 px-4 py-2 rounded-sm text-sm font-medium border {{ (string) $device === (string) $key ? 'bg-maroon-900 text-ivory border-maroon-900' : 'bg-white text-charcoal-700 border-beige-200 hover:border-gold-500' }}">
        {{ $t[0] }} <span class="text-xs opacity-70 tabular-nums">{{ number_format($t[1]) }}</span>
    </a>
    @endforeach
</div>

<div class="mt-5 bg-white rounded-sm shadow-sm border border-beige-200 overflow-x-auto">
    <table class="w-full text-sm">
        <thead>
            <tr class="text-left text-xs uppercase tracking-wide text-charcoal-600 border-b border-beige-200">
                <th class="py-3 px-4 font-semibold">Visitor</th>
                <th class="py-3 px-4 font-semibold">Device</th>
                <th class="py-3 px-4 font-semibold text-right">Pages</th>
                <th class="py-3 px-4 font-semibold text-right">Conversions</th>
                <th class="py-3 px-4 font-semibold">Source</th>
                <th class="py-3 px-4 font-semibold">First seen</th>
                <th class="py-3 px-4 font-semibold">Last seen</th>
            </tr>
        </thead>
        <tbody>
            @php $devColors = ['mobile' => 'bg-maroon-100 text-maroon-800', 'desktop' => 'bg-gold-100 text-gold-800', 'tablet' => 'bg-beige-200 text-charcoal-700']; @endphp
            @forelse ($visitors as $v)
            <tr class="border-b border-beige-100 last:border-0">
                <td class="py-3 px-4 font-mono text-xs text-charcoal-600">{{ substr($v->visitor_id, 0, 8) }}</td>
                <td class="py-3 px-4"><span class="text-xs px-2 py-0.5 rounded-full {{ $devColors[$v->device] ?? 'bg-beige-100 text-charcoal-700' }}">{{ ucfirst($v->device ?? 'unknown') }}</span></td>
                <td class="py-3 px-4 text-right tabular-nums text-charcoal-700">{{ number_format($v->pageviews) }}</td>
                <td class="py-3 px-4 text-right tabular-nums font-semibold {{ $v->conversions > 0 ? 'text-gold-700' : 'text-charcoal-400' }}">{{ number_format($v->conversions) }}</td>
                <td class="py-3 px-4 text-charcoal-700 truncate max-w-40">{{ $v->utm_source ?: ($v->referrer ? 'Referral' : 'Direct') }}</td>
                <td class="py-3 px-4 text-charcoal-500 whitespace-nowrap text-xs">{{ \Illuminate\Support\Carbon::parse($v->first_seen)->format('d M Y, H:i') }}</td>
                <td class="py-3 px-4 text-charcoal-500 whitespace-nowrap text-xs">{{ \Illuminate\Support\Carbon::parse($v->last_seen)->format('d M Y, H:i') }}</td>
            </tr>
            @empty
            <tr><td colspan="7" class="py-10 text-center text-charcoal-600">No visitors recorded yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-5">{{ $visitors->links() }}</div>
@endsection
