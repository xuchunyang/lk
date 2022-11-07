<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Identicon\Identicon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function signup()
    {
        return view('user.signup');
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        $user
            ->addMediaFromBase64((new Identicon())->getImageDataUri($user->username, 180))
            ->usingFileName(Str::uuid() . '.png')
            ->toMediaCollection();

        return redirect(route('users.signin'))->with('success', '注册成功，请登录!');
    }

    public function signin()
    {
        return view('user.signin');
    }

    public function authenticate(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($validated)) {
            $request->session()->regenerate();

            return redirect()->intended();
        }

        return back()->withErrors([
            'username' => '登录信息不正确!',
        ])->onlyInput('username');
    }

    public function signout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user,
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        if ($validated['new-password']) {
            $validated['password'] = Hash::make($validated['new-password']);
        }
        unset($validated['new-password']);

        if ($validated['avatar'] ?? false) {
            $user->clearMediaCollection();
            $user
                ->addMedia($validated['avatar'])
                ->toMediaCollection();
            unset($validated['avatar']);
        }

        $user->update($validated);

        return back()->with('success', '成功更新用户信息!');
    }
}
