<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OAuthWelcomeMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user exists by email only
            $user = User::where('email', $googleUser->getEmail())
                ->first();

            if ($user) {
                // User exists - only update name and avatar, do not store provider/provider_id
                $user->update([
                    'name' => $googleUser->getName(),
                    'avatar' => $googleUser->getAvatar(),
                ]);

                Auth::login($user);
                return redirect()->intended('/user/dashboard/index');
            }

            // User doesn't exist - create new user without provider/provider_id
            $randomPassword = Str::random(12);

            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => Hash::make($randomPassword),
                'avatar' => $googleUser->getAvatar(),
                'email_verified_at' => now(), // OAuth users are pre-verified
            ]);

            // Send welcome email with default password
            Mail::to($user->email)->send(new OAuthWelcomeMail($user, $randomPassword));

            Auth::login($user);
            return redirect()->intended('/user/dashboard/index');

        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Google authentication failed. Please try again.',
            ]);
        }
    }
}
