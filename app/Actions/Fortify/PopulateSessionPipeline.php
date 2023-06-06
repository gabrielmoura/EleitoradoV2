<?php

namespace App\Actions\Fortify;

use Illuminate\Http\Request;
use Laravel\Fortify\LoginRateLimiter;

class PopulateSessionPipeline
{
    /**
     * Create a new class instance.
     *
     * @return void
     */
    public function __construct(protected LoginRateLimiter $limiter)
    {

    }

    /**
     * Populate the session with the rate limiter data.
     */
    public function handle(Request $request, callable $next): mixed
    {
        $user = $request->user();
        $company = $user->company;
        $request->session()->put('tenant_id', $company->tenant_id);
        $request->session()->put('company', [
            'name' => $company->name,
            'id' => $company->id,
            'banned' => $company->banned,
        ]);
        $request->session()->put('user', [
            'profile_photo_url' => $user->profile_photo_url,
            'name' => $user->name,
            'email' => $user->email,
        ]);
        //        $request->session()->put('two_factor', [
        //            'enabled' => ! is_null($user->two_factor_secret),
        //        ]);
        $request->session()->put('ip', $request->ip());

        $this->limiter->clear($request);

        return $next($request);
    }
}
