@extends('admin.layout')
@section('title', 'Events')
@section('content')
<h1 class="font-display text-2xl sm:text-3xl font-bold text-maroon-900">Events</h1>
<p class="text-sm text-charcoal-600 mt-1">Manage the events shown on the website. Featured events also appear on the home page.</p>

{{-- Add --}}
<form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data" class="mt-6 bg-white rounded-sm shadow-sm border border-beige-200 p-5 grid sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
    @csrf
    <div class="lg:col-span-1"><label class="block text-xs font-medium text-charcoal-600 mb-1">Title</label><input name="title" required value="{{ old('title') }}" class="w-full h-10 px-3 rounded-sm border border-beige-300 text-sm"></div>
    <div class="lg:col-span-2"><label class="block text-xs font-medium text-charcoal-600 mb-1">Short description</label><input name="excerpt" value="{{ old('excerpt') }}" class="w-full h-10 px-3 rounded-sm border border-beige-300 text-sm"></div>
    <div><label class="block text-xs font-medium text-charcoal-600 mb-1">Image</label><input type="file" name="image_file" accept="image/*" class="w-full text-xs"></div>
    <div><label class="block text-xs font-medium text-charcoal-600 mb-1">Order</label><input type="number" name="sort_order" value="0" min="0" class="w-24 h-10 px-3 rounded-sm border border-beige-300 text-sm"></div>
    <label class="flex items-center gap-2 text-sm h-10"><input type="checkbox" name="is_active" value="1" checked> Active</label>
    <label class="flex items-center gap-2 text-sm h-10"><input type="checkbox" name="is_featured" value="1" checked> Featured (home)</label>
    <button class="btn-gold !py-2.5 !px-5 !text-xs h-10">Add Event</button>
</form>
@foreach ($errors->all() as $e)<p class="mt-2 text-sm text-red-600">{{ $e }}</p>@endforeach

{{-- List --}}
<div class="mt-6 space-y-3">
    @foreach ($events as $ev)
    <form method="POST" action="{{ route('admin.events.update', $ev) }}" enctype="multipart/form-data" class="bg-white rounded-sm shadow-sm border border-beige-200 p-4 grid sm:grid-cols-2 lg:grid-cols-12 gap-3 items-center">
        @csrf @method('PATCH')
        <img src="{{ $ev->image }}" alt="" class="lg:col-span-1 w-full h-14 object-cover rounded-sm border border-beige-200">
        <div class="lg:col-span-3"><input name="title" value="{{ $ev->title }}" class="w-full h-10 px-3 rounded-sm border border-beige-300 text-sm"></div>
        <div class="lg:col-span-4"><input name="excerpt" value="{{ $ev->excerpt }}" class="w-full h-10 px-3 rounded-sm border border-beige-300 text-sm"></div>
        <div class="lg:col-span-1"><input type="number" name="sort_order" value="{{ $ev->sort_order }}" min="0" class="w-full h-10 px-2 rounded-sm border border-beige-300 text-sm"></div>
        <div class="lg:col-span-1 flex flex-col gap-1 text-xs">
            <label class="flex items-center gap-1"><input type="checkbox" name="is_active" value="1" @checked($ev->is_active)> Active</label>
            <label class="flex items-center gap-1"><input type="checkbox" name="is_featured" value="1" @checked($ev->is_featured)> Home</label>
        </div>
        <div class="lg:col-span-2 flex items-center gap-2">
            <input type="file" name="image_file" accept="image/*" class="text-[11px] w-28">
            <button class="btn-gold !py-2 !px-3 !text-xs">Save</button>
            <button type="submit" form="ev-del-{{ $ev->id }}" class="text-xs text-maroon-600 hover:text-maroon-800 cursor-pointer" onclick="return confirm('Delete this event?')">Del</button>
        </div>
    </form>
    <form id="ev-del-{{ $ev->id }}" method="POST" action="{{ route('admin.events.destroy', $ev) }}" class="hidden">@csrf @method('DELETE')</form>
    @endforeach
</div>
@endsection
