<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function redirect(Request $request, $provider)
    {
        // \Illuminate\Support\Facades\URL::signedRoute('social.redirect', ['provider' => 'google']);
        if (! $request->hasValidSignature()) {
            return redirect()->back()->with('error', 'Invalid signature');
        }

        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $providerUser = Socialite::driver($provider)->user();
        if (Auth::check()) {
            $user = Auth::user();
            $user->social = collect($user->social)->put($provider, [
                'provider' => $provider,
                'provider_id' => $providerUser->id,
                'token' => $providerUser->token,
                'refresh_token' => $providerUser->refreshToken,
                'expires_in' => $providerUser->expiresIn,
                'avatar' => $providerUser->avatar,
            ]);
            $user->save();
        } else {
            $user = User::whereNotNull('social')->whereJsonContains('social->'.$provider.'->provider_id', $providerUser->id)->first();
            if (! $user) {
                return to_route('login')->with('error', 'User not found');
            }
            Auth::login($user);
        }

        return redirect()->route('dash.profile');
    }
}
