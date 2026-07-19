@extends('admin.layout')

@section('title', 'Career Applications')

@section('content')
<h1 class="font-display text-2xl sm:text-3xl font-bold text-maroon-900">Career Applications</h1>
<p class="text-sm text-charcoal-600 mt-1">{{ $applications->total() }} application(s).</p>

<form method="GET" class="mt-6 bg-white rounded-sm shadow-sm border border-beige-200 p-4 flex flex-wrap items-end gap-3">
    <div>
        <label for="f-status" class="block text-xs font-medium text-charcoal-600 mb-1">Status</label>
        <select id="f-status" name="status" class="h-10 px-3 rounded-sm border border-beige-300 bg-white text-sm">
            <option value="">All</option>
            @foreach (\App\Models\CareerApplication::STATUSES as $key => $label)
            <option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn-gold !py-2.5 !px-5 !text-xs">Filter</button>
</form>

<div class="mt-6 bg-white rounded-sm shadow-sm border border-beige-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-beige-100 text-left text-xs uppercase tracking-wide text-charcoal-600">
                    <th class="px-5 py-3 font-semibold">Date</th>
                    <th class="px-5 py-3 font-semibold">Name</th>
                    <th class="px-5 py-3 font-semibold">Position</th>
                    <th class="px-5 py-3 font-semibold">Contact</th>
                    <th class="px-5 py-3 font-semibold">CV</th>
                    <th class="px-5 py-3 font-semibold">Status</th>
                    <th class="px-5 py-3 font-semibold"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-beige-100">
                @forelse ($applications as $app)
                <tr class="hover:bg-beige-100/40 align-top">
                    <td class="px-5 py-3 whitespace-nowrap text-charcoal-600">{{ $app->created_at->format('d M Y') }}</td>
                    <td class="px-5 py-3 font-medium text-charcoal-800">{{ $app->name }}</td>
                    <td class="px-5 py-3">{{ $app->position }}</td>
                    <td class="px-5 py-3">
                        <a href="tel:{{ $app->phone }}" class="tabular-nums text-maroon-800 block">{{ $app->phone }}</a>
                        <a href="mailto:{{ $app->email }}" class="text-xs text-charcoal-600">{{ $app->email }}</a>
                    </td>
                    <td class="px-5 py-3">
                        @if ($app->cv_path)
                        <a href="{{ route('admin.careers.download', $app) }}" class="text-sm font-semibold text-maroon-800 hover:text-maroon-600">Download</a>
                        @else — @endif
                    </td>
                    <td class="px-5 py-3">
                        <form method="POST" action="{{ route('admin.careers.update', $app) }}" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="h-9 px-2 rounded-sm border border-beige-300 bg-white text-xs">
                                @foreach (\App\Models\CareerApplication::STATUSES as $key => $label)
                                <option value="{{ $key }}" @selected($app->status === $key)>{{ $label }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn-gold !py-1.5 !px-3 !text-[11px]">Save</button>
                        </form>
                    </td>
                    <td class="px-5 py-3">
                        <form method="POST" action="{{ route('admin.careers.destroy', $app) }}" onsubmit="return confirm('Delete this application and its CV?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-maroon-600 hover:text-maroon-800 cursor-pointer">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-5 py-10 text-center text-charcoal-600">No applications yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $applications->links() }}
</div>
@endsection
