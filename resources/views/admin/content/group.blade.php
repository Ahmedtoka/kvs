@extends('admin.layout')

@section('title', $meta['title'])

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <a href="{{ route('admin.content.hub') }}" class="text-xs font-semibold text-charcoal-500 hover:text-maroon-700">&larr; Content</a>
        <h1 class="font-display text-2xl sm:text-3xl font-bold text-maroon-900 mt-1">{{ $meta['title'] }}</h1>
        <p class="text-sm text-charcoal-600 mt-1">Edit, reorder, add or remove items. Changes go live immediately.</p>
    </div>
    <a href="{{ $meta['live'] }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 text-sm font-semibold text-gold-700 hover:text-gold-800 px-4 py-2.5 rounded-sm border border-beige-200 self-start">
        View live page
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
    </a>
</div>

@if ($errors->any())
<div class="mt-5 bg-maroon-50 border border-maroon-300 text-maroon-800 text-sm rounded-sm px-4 py-3">
    <ul class="list-disc ms-4 space-y-1">
        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
    </ul>
</div>
@endif

{{-- Existing items --}}
<div class="mt-6 space-y-3">
    @forelse ($items as $item)
    <form method="POST" action="{{ route('admin.content.update', $item) }}" class="bg-white rounded-sm shadow-sm border border-beige-200 p-5">
        @csrf
        @method('PATCH')
        <div class="grid gap-3">
            <div class="flex items-center gap-3">
                <input type="number" name="sort_order" value="{{ $item->sort_order }}" title="Order" class="w-16 h-10 px-2 rounded-sm border border-beige-300 bg-white text-sm text-center">
                <input type="text" name="title" value="{{ $item->title }}" required placeholder="Title / question" class="grow h-10 px-3 rounded-sm border border-beige-300 bg-white text-sm font-medium">
                <label class="inline-flex items-center gap-2 text-xs text-charcoal-600 whitespace-nowrap">
                    <input type="checkbox" name="is_active" value="1" @checked($item->is_active) class="rounded border-beige-300"> Visible
                </label>
            </div>
            <textarea name="body" rows="3" placeholder="Answer / description" class="w-full px-3 py-2 rounded-sm border border-beige-300 bg-white text-sm">{{ $item->body }}</textarea>
            @if ($meta['has_icon'])
            <input type="text" name="icon" value="{{ $item->icon }}" placeholder="Icon SVG path (optional)" class="w-full h-10 px-3 rounded-sm border border-beige-300 bg-white text-xs font-mono text-charcoal-500">
            @endif
        </div>
        <div class="flex items-center gap-3 mt-3">
            <button type="submit" class="btn-gold !py-2 !px-4 !text-xs">Save</button>
            <button type="submit" form="del-{{ $item->id }}" onclick="return confirm('Remove this item?')" class="text-xs text-maroon-600 hover:text-maroon-800 cursor-pointer">Delete</button>
        </div>
    </form>
    <form id="del-{{ $item->id }}" method="POST" action="{{ route('admin.content.destroy', $item) }}" class="hidden">@csrf @method('DELETE')</form>
    @empty
    <p class="text-sm text-charcoal-500 bg-white rounded-sm border border-beige-200 px-4 py-6 text-center">No items yet — add the first one below.</p>
    @endforelse
</div>

{{-- Add new --}}
<div class="mt-8 bg-white rounded-sm shadow-sm border border-gold-500/50 p-5">
    <h2 class="font-display text-lg font-bold text-maroon-900">Add a new {{ strtolower($meta['singular']) }}</h2>
    <form method="POST" action="{{ route('admin.content.store', $group) }}" class="mt-3 grid gap-3">
        @csrf
        <input type="text" name="title" value="{{ old('title') }}" required placeholder="Title / question" class="w-full h-10 px-3 rounded-sm border border-beige-300 bg-white text-sm font-medium">
        <textarea name="body" rows="3" placeholder="Answer / description" class="w-full px-3 py-2 rounded-sm border border-beige-300 bg-white text-sm">{{ old('body') }}</textarea>
        @if ($meta['has_icon'])
        <input type="text" name="icon" value="{{ old('icon') }}" placeholder="Icon SVG path (optional — leave blank for a default icon)" class="w-full h-10 px-3 rounded-sm border border-beige-300 bg-white text-xs font-mono text-charcoal-500">
        @endif
        <input type="hidden" name="is_active" value="1">
        <div><button type="submit" class="btn-maroon !py-2.5 !px-5 !text-xs">Add {{ $meta['singular'] }}</button></div>
    </form>
</div>
@endsection
