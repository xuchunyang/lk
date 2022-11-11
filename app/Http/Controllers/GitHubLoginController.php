<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;

class GitHubLoginController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function callback()
    {
        $githubUser = Socialite::driver('github')->user();

        $user = User::where('github_id', $githubUser->getId())->first();

        if (!$user) {
            $username = $githubUser->getNickname();
            if (User::where('username', $username)->exists()) {
                $username .= '_github';
            }

            $user = User::create([
                'username' => $username,
                'github_id' => $githubUser->getId(),
                'github_username' => $githubUser->getNickname(),
                'email' => $githubUser->getEmail(),
                'password' => Hash::make(fake()->password()),
            ]);

            $user
                ->addMediaFromUrl($githubUser->getAvatar())
                ->usingFileName($githubUser->getId() . '.png')
                ->toMediaCollection();
        }

        Auth::login($user, true);

        return redirect()->intended('/');
    }
}
