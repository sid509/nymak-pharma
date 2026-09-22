<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PasswordRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function edit(): Response
    {
        return Inertia::render('Admin/Profile');
    }

    public function update(PasswordRequest $request): RedirectResponse
    {
        $request->user()->update(['password' => $request->password]);

        return back()->with('success', 'Password updated.');
    }
}
