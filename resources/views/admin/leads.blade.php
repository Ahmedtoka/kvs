<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admissions Leads — KVS Admin</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="/favicon.ico" sizes="any">
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-beige-100 text-charcoal-800">

{{-- ===== Header ===== --}}
<header class="bg-maroon-950 text-ivory">
    <div class="container-site flex items-center justify-between py-3.5">
        <div class="flex items-center gap-3">
            <img src="/images/logo-mark.png" alt="" class="h-10 w-auto">
            <span class="leading-tight">
                <span class="block font-display font-bold text-lg">KVS Admin</span>
                <span class="block text-[11px] tracking-[0.2em] uppercase text-gold-400">Admissions Leads</span>
            </span>
        </div>
        <nav class="flex items-center gap-5 text-sm">
            <a href="{{ route('admin.leads') }}" class="font-semibold text-gold-400">Leads</a>
            <a href="{{ route('admin.analytics') }}" class="text-ivory/70 hover:text-gold-300 transition-colors">Analytics</a>
            <a href="{{ route('home') }}" class="text-ivory/70 hover:text-gold-300 transition-colors">View website</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="font-semibold text-gold-400 hover:text-gold-300 transition-colors cursor-pointer">Log out</button>
            </form>
        </nav>
    </div>
</header>

<main class="container-site py-8 sm:py-10">

    @if (session('success'))
    <div class="mb-6 rounded-sm border border-gold-600/50 bg-gold-100 px-5 py-3 text-sm font-medium text-maroon-900" role="status">
        {{ session('success') }}
    </div>
    @endif

    {{-- ===== Stats / Filters ===== --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
        <a href="{{ route('admin.leads') }}"
           class="rounded-sm border p-4 text-center transition-colors {{ $active === null ? 'bg-maroon-900 border-maroon-900 text-ivory' : 'bg-white border-beige-200 hover:border-maroon-300' }}">
            <span class="block font-display text-2xl font-bold {{ $active === null ? 'text-gold-400' : 'text-maroon-900' }}">{{ $counts['total'] }}</span>
            <span class="block text-xs mt-1 uppercase tracking-wider {{ $active === null ? 'text-ivory/70' : 'text-charcoal-600' }}">All Leads</span>
        </a>
        @foreach ($statuses as $s)
        <a href="{{ route('admin.leads', ['status' => $s]) }}"
           class="rounded-sm border p-4 text-center transition-colors {{ $active === $s ? 'bg-maroon-900 border-maroon-900 text-ivory' : 'bg-white border-beige-200 hover:border-maroon-300' }}">
            <span class="block font-display text-2xl font-bold {{ $active === $s ? 'text-gold-400' : 'text-maroon-900' }}">{{ $counts[$s] }}</span>
            <span class="block text-xs mt-1 uppercase tracking-wider {{ $active === $s ? 'text-ivory/70' : 'text-charcoal-600' }}">{{ ucfirst($s) }}</span>
        </a>
        @endforeach
    </div>

    {{-- ===== Table ===== --}}
    <div class="mt-8 bg-white rounded-sm border border-beige-200 shadow-sm overflow-x-auto">
        <table class="w-full text-sm min-w-[860px]">
            <thead>
                <tr class="bg-beige-100/70 text-left text-xs uppercase tracking-wider text-charcoal-600 border-b border-beige-200">
                    <th class="px-5 py-3.5 font-semibold">#</th>
                    <th class="px-5 py-3.5 font-semibold">Parent</th>
                    <th class="px-5 py-3.5 font-semibold">Phone</th>
                    <th class="px-5 py-3.5 font-semibold">Child's Age</th>
                    <th class="px-5 py-3.5 font-semibold">Stage</th>
                    <th class="px-5 py-3.5 font-semibold">Received</th>
                    <th class="px-5 py-3.5 font-semibold">Status</th>
                    <th class="px-5 py-3.5 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($leads as $lead)
                <tr class="border-b border-beige-100 last:border-0 hover:bg-ivory/60 transition-colors">
                    <td class="px-5 py-4 text-charcoal-600">{{ $lead->id }}</td>
                    <td class="px-5 py-4 font-semibold text-maroon-900">{{ $lead->parent_name }}</td>
                    <td class="px-5 py-4">
                        <a href="tel:{{ $lead->phone }}" class="hover:text-maroon-700 font-medium">{{ $lead->phone }}</a>
                        <a href="https://wa.me/2{{ ltrim($lead->phone, '+2') }}" target="_blank" rel="noopener"
                           class="ml-2 inline-flex items-center text-[#1da851] hover:opacity-75 transition-opacity" title="WhatsApp">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                    </td>
                    <td class="px-5 py-4">{{ $lead->child_age }} yrs</td>
                    <td class="px-5 py-4">
                        @if ($lead->stage)
                        <span class="inline-block text-xs font-semibold bg-gold-100 text-gold-800 px-2.5 py-1 rounded-full">
                            {{ ['early-years' => 'Early Years', 'primary' => 'Primary', 'secondary' => 'Secondary'][$lead->stage] ?? $lead->stage }}
                        </span>
                        @else
                        <span class="text-charcoal-600/60">—</span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-charcoal-600 whitespace-nowrap" title="{{ $lead->created_at }}">{{ $lead->created_at->format('d M Y · H:i') }}</td>
                    <td class="px-5 py-4">
                        <form method="POST" action="{{ route('admin.leads.update', $lead) }}" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="h-9 px-2 rounded-sm border border-beige-300 bg-white text-xs font-semibold focus:border-gold-600 focus:outline-none cursor-pointer">
                                @foreach ($statuses as $s)
                                <option value="{{ $s }}" @selected($lead->status === $s)>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="h-9 px-3 rounded-sm bg-maroon-800 text-ivory text-xs font-semibold hover:bg-maroon-700 transition-colors cursor-pointer">Save</button>
                        </form>
                    </td>
                    <td class="px-5 py-4 text-right">
                        <form method="POST" action="{{ route('admin.leads.destroy', $lead) }}"
                              onsubmit="return confirm('Delete lead “{{ $lead->parent_name }}”? This cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-semibold text-red-600 hover:text-red-700 transition-colors cursor-pointer">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-5 py-16 text-center text-charcoal-600">
                        <p class="font-display text-lg text-maroon-900">No leads {{ $active ? 'with status "' . ucfirst($active) . '"' : 'yet' }}</p>
                        <p class="mt-1 text-sm">New requests from the website form will appear here.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($leads->hasPages())
    <div class="mt-6">
        {{ $leads->links() }}
    </div>
    @endif

</main>

</body>
</html>
