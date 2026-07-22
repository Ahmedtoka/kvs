<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserAdminController extends Controller
{
    public function index()
    {
        $users = User::withCount('leads')->orderBy('name')->get();

        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:120'],
            'email'    => ['required', 'email', 'max:190', 'unique:users,email'],
            'role'     => ['required', Rule::in(array_keys(User::ROLES))],
            'password' => ['required', 'string', 'min:8'],
        ]);

        User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'role'      => $data['role'],
            'password'  => $data['password'],
            'is_active' => true,
        ]);

        return back()->with('success', 'User created.');
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:120'],
            'email'    => ['required', 'email', 'max:190', Rule::unique('users', 'email')->ignore($user->id)],
            'role'     => ['required', Rule::in(array_keys(User::ROLES))],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $user->name  = $data['name'];
        $user->email = $data['email'];
        $user->role  = $data['role'];
        $user->is_active = $request->boolean('is_active');
        if (! empty($data['password'])) {
            $user->password = $data['password'];
        }
        $user->save();

        return back()->with('success', 'User updated.');
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return back()->with('success', 'You cannot remove your own account.');
        }
        $user->delete();

        return back()->with('success', 'User removed.');
    }
}
