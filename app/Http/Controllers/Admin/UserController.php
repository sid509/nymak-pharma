<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Users/Index', [
            'users' => User::orderBy('name')->get(['id', 'name', 'email', 'created_at']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Users/Form');
    }

    public function store(UserRequest $request): RedirectResponse
    {
        // 'hashed' cast on User hashes the password automatically.
        User::create($request->only('name', 'email', 'password'));

        return redirect()->route('admin.users.index')->with('success', 'Admin user created.');
    }

    public function edit(User $user): Response
    {
        return Inertia::render('Admin/Users/Form', [
            'user' => $user->only('id', 'name', 'email'),
        ]);
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            ...($request->filled('password') ? ['password' => $request->password] : []),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated.');
    }

    public function destroy(User $user): RedirectResponse
    {
        abort_if($user->id === request()->user()->id, 422, 'You cannot delete your own account.');

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }
}
