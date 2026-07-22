@extends('admin.layout')
@section('title', 'Users & Roles')
@section('content')
<h1 class="font-display text-2xl sm:text-3xl font-bold text-maroon-900">Users &amp; Roles</h1>
<p class="text-sm text-charcoal-600 mt-1">Create accounts for your sales team, media buyers and editors.</p>

<form method="POST" action="{{ route('admin.users.store') }}" class="mt-6 bg-white rounded-sm shadow-sm border border-beige-200 p-5 grid sm:grid-cols-2 lg:grid-cols-5 gap-3 items-end">
    @csrf
    <div><label class="block text-xs font-medium text-charcoal-600 mb-1">Name</label><input name="name" required value="{{ old('name') }}" class="w-full h-10 px-3 rounded-sm border border-beige-300 text-sm"></div>
    <div><label class="block text-xs font-medium text-charcoal-600 mb-1">Email</label><input type="email" name="email" required value="{{ old('email') }}" class="w-full h-10 px-3 rounded-sm border border-beige-300 text-sm"></div>
    <div><label class="block text-xs font-medium text-charcoal-600 mb-1">Role</label>
        <select name="role" class="w-full h-10 px-3 rounded-sm border border-beige-300 text-sm">
            @foreach (\App\Models\User::ROLES as $k => $l)<option value="{{ $k }}">{{ $l }}</option>@endforeach
        </select></div>
    <div><label class="block text-xs font-medium text-charcoal-600 mb-1">Password</label><input type="text" name="password" required minlength="8" placeholder="min 8 chars" class="w-full h-10 px-3 rounded-sm border border-beige-300 text-sm"></div>
    <button class="btn-gold !py-2.5 !px-5 !text-xs h-10">Add User</button>
</form>
@foreach ($errors->all() as $e)<p class="mt-2 text-sm text-red-600">{{ $e }}</p>@endforeach

<div class="mt-6 space-y-3">
    @foreach ($users as $u)
    <form method="POST" action="{{ route('admin.users.update', $u) }}" class="bg-white rounded-sm shadow-sm border border-beige-200 p-4 grid sm:grid-cols-2 lg:grid-cols-6 gap-3 items-end">
        @csrf @method('PATCH')
        <div><label class="block text-xs text-charcoal-600 mb-1">Name</label><input name="name" value="{{ $u->name }}" class="w-full h-10 px-3 rounded-sm border border-beige-300 text-sm"></div>
        <div><label class="block text-xs text-charcoal-600 mb-1">Email</label><input type="email" name="email" value="{{ $u->email }}" class="w-full h-10 px-3 rounded-sm border border-beige-300 text-sm"></div>
        <div><label class="block text-xs text-charcoal-600 mb-1">Role</label>
            <select name="role" class="w-full h-10 px-3 rounded-sm border border-beige-300 text-sm">
                @foreach (\App\Models\User::ROLES as $k => $l)<option value="{{ $k }}" @selected($u->role === $k)>{{ $l }}</option>@endforeach
            </select></div>
        <div><label class="block text-xs text-charcoal-600 mb-1">New password</label><input type="text" name="password" placeholder="leave blank" class="w-full h-10 px-3 rounded-sm border border-beige-300 text-sm"></div>
        <label class="flex items-center gap-2 text-sm h-10"><input type="checkbox" name="is_active" value="1" @checked($u->is_active)> Active <span class="text-xs text-charcoal-500">· {{ $u->leads_count }} leads</span></label>
        <div class="flex gap-3 items-center">
            <button class="btn-gold !py-2 !px-4 !text-xs">Save</button>
            @if ($u->id !== auth()->id())
            <button type="submit" form="del-{{ $u->id }}" class="text-xs text-maroon-600 hover:text-maroon-800 cursor-pointer" onclick="return confirm('Remove this user?')">Remove</button>
            @endif
        </div>
    </form>
    @if ($u->id !== auth()->id())
    <form id="del-{{ $u->id }}" method="POST" action="{{ route('admin.users.destroy', $u) }}" class="hidden">@csrf @method('DELETE')</form>
    @endif
    @endforeach
</div>
@endsection
