@extends('admin.layout')
@section('title', 'Events')
@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="font-display text-2xl sm:text-3xl font-bold text-maroon-900">Events</h1>
        <p class="text-sm text-charcoal-600 mt-1">Each event is a full page with a photo gallery. Featured events also show on the home page.</p>
    </div>
    <a href="{{ route('events.index') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 text-sm font-semibold text-gold-700 hover:text-gold-800 px-4 py-2.5 rounded-sm border border-beige-200 self-start">View live events &rarr;</a>
</div>

@if ($errors->any())
<div class="mt-5 bg-red-50 border border-red-300 text-red-800 text-sm rounded-sm px-4 py-3">
    <ul class="list-disc ms-4 space-y-1">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif

{{-- Add new --}}
<form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data" class="mt-6 bg-white rounded-sm shadow-sm border border-gold-500/50 p-5">
    @csrf
    <h2 class="font-display text-lg font-bold text-maroon-900">Add a new event</h2>
    <div class="mt-3 grid sm:grid-cols-2 gap-4">
        <div><label class="block text-xs font-medium text-charcoal-600 mb-1">Title</label><input name="title" required value="{{ old('title') }}" class="w-full h-10 px-3 rounded-sm border border-beige-300 text-sm"></div>
        <div><label class="block text-xs font-medium text-charcoal-600 mb-1">Short description (shown on the card)</label><input name="excerpt" value="{{ old('excerpt') }}" class="w-full h-10 px-3 rounded-sm border border-beige-300 text-sm"></div>
    </div>
    <div class="mt-3"><label class="block text-xs font-medium text-charcoal-600 mb-1">Full text (the article — leave a blank line between paragraphs)</label><textarea name="body" rows="4" class="w-full px-3 py-2 rounded-sm border border-beige-300 text-sm">{{ old('body') }}</textarea></div>
    <div class="mt-3 grid sm:grid-cols-2 gap-4">
        <div><label class="block text-xs font-medium text-charcoal-600 mb-1">Main image</label><input type="file" name="image_file" accept="image/*" class="w-full text-xs"></div>
        <div><label class="block text-xs font-medium text-charcoal-600 mb-1">Gallery images (you can pick many)</label><input type="file" name="gallery_files[]" accept="image/*" multiple class="w-full text-xs"></div>
    </div>
    <div class="mt-3 flex flex-wrap items-center gap-4">
        <div><label class="block text-xs font-medium text-charcoal-600 mb-1">Order</label><input type="number" name="sort_order" value="0" min="0" class="w-24 h-10 px-3 rounded-sm border border-beige-300 text-sm"></div>
        <label class="flex items-center gap-2 text-sm mt-5"><input type="checkbox" name="is_active" value="1" checked> Active</label>
        <label class="flex items-center gap-2 text-sm mt-5"><input type="checkbox" name="is_featured" value="1" checked> Featured (home)</label>
        <button class="btn-gold !py-2.5 !px-5 !text-xs mt-5">Add Event</button>
    </div>
</form>

{{-- Existing events --}}
<div class="mt-8 space-y-5">
    @foreach ($events as $ev)
    <form method="POST" action="{{ route('admin.events.update', $ev) }}" enctype="multipart/form-data" class="bg-white rounded-sm shadow-sm border border-beige-200 p-5">
        @csrf @method('PATCH')
        <div class="grid lg:grid-cols-[12rem_1fr] gap-5">
            {{-- Main image --}}
            <div>
                <p class="text-xs font-medium text-charcoal-600 mb-1">Main image</p>
                <img src="{{ $ev->image }}" alt="" class="w-full aspect-[4/3] object-cover rounded-sm border border-beige-200">
                <input type="file" name="image_file" accept="image/*" class="mt-2 w-full text-[11px]">
            </div>
            {{-- Fields --}}
            <div class="space-y-3">
                <div class="grid sm:grid-cols-[1fr_5rem] gap-3">
                    <div><label class="block text-xs font-medium text-charcoal-600 mb-1">Title</label><input name="title" value="{{ $ev->title }}" class="w-full h-10 px-3 rounded-sm border border-beige-300 text-sm"></div>
                    <div><label class="block text-xs font-medium text-charcoal-600 mb-1">Order</label><input type="number" name="sort_order" value="{{ $ev->sort_order }}" min="0" class="w-full h-10 px-2 rounded-sm border border-beige-300 text-sm"></div>
                </div>
                <div><label class="block text-xs font-medium text-charcoal-600 mb-1">Short description</label><input name="excerpt" value="{{ $ev->excerpt }}" class="w-full h-10 px-3 rounded-sm border border-beige-300 text-sm"></div>
                <div><label class="block text-xs font-medium text-charcoal-600 mb-1">Full text</label><textarea name="body" rows="4" class="w-full px-3 py-2 rounded-sm border border-beige-300 text-sm">{{ $ev->body }}</textarea></div>

                {{-- Gallery --}}
                <div>
                    <p class="text-xs font-medium text-charcoal-600 mb-1.5">Gallery ({{ $ev->gallery ? count($ev->gallery) : 0 }} photos) — tick to remove</p>
                    @if ($ev->gallery && count($ev->gallery))
                    <div class="flex flex-wrap gap-2">
                        @foreach ($ev->gallery as $img)
                        <label class="relative block w-20 h-16 rounded-sm overflow-hidden border border-beige-200 cursor-pointer group">
                            <img src="{{ $img }}" alt="" class="w-full h-full object-cover">
                            <span class="absolute inset-0 bg-red-600/0 group-has-[:checked]:bg-red-600/60 transition-colors flex items-center justify-center">
                                <input type="checkbox" name="remove_gallery[]" value="{{ $img }}" class="absolute top-1 right-1 w-4 h-4">
                            </span>
                        </label>
                        @endforeach
                    </div>
                    @endif
                    <div class="mt-2"><label class="block text-xs font-medium text-charcoal-600 mb-1">Add gallery images</label><input type="file" name="gallery_files[]" accept="image/*" multiple class="w-full text-[11px]"></div>
                </div>

                <div class="flex flex-wrap items-center gap-4 pt-1">
                    <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" @checked($ev->is_active)> Active</label>
                    <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_featured" value="1" @checked($ev->is_featured)> Featured (home)</label>
                    <a href="{{ route('events.show', $ev->slug) }}" target="_blank" rel="noopener" class="text-xs font-semibold text-gold-700 hover:underline">Preview &rarr;</a>
                    <div class="ms-auto flex items-center gap-3">
                        <button class="btn-gold !py-2 !px-5 !text-xs">Save</button>
                        <button type="submit" form="ev-del-{{ $ev->id }}" class="text-xs text-maroon-600 hover:text-maroon-800 cursor-pointer" onclick="return confirm('Delete this event?')">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form id="ev-del-{{ $ev->id }}" method="POST" action="{{ route('admin.events.destroy', $ev) }}" class="hidden">@csrf @method('DELETE')</form>
    @endforeach
</div>
@endsection
