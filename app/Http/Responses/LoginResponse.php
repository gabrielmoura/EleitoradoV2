<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();
        $isAdmin = $user->hasRole('admin');
        if (! $isAdmin) {
            $company = $user->company;
            $request->session()->put('tenant_id', $company->tenant_id);
            $request->session()->put('company', [
                'name' => $company->name,
                'id' => $company->id,
                'banned' => $company->banned,
                'hand_signing' => $company->hand_signing,
            ]);
            if ($company->subscribed('default')) {
                $request->session()->put('subscribed', $company->subscription('default')->items->first()->toArray());
            }

            //        $request->session()->put('two_factor', [
            //            'enabled' => ! is_null($user->two_factor_secret),
            //        ]);
        }
        $request->session()->put('user', [
            'profile_photo_url' => $user->profile_photo_url,
            'name' => $user->name,
            'email' => $user->email,
            'banned_at' => $user->banned_at,
        ]);

        $request->session()->put('ip', $request->ip());

        $home = $isAdmin ? '/admin' : '/dashboard';

        return redirect()->intended($home);
    }
}
