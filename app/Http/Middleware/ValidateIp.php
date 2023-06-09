<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Middleware\ValidateSignature as Middleware;
use Symfony\Component\HttpFoundation\Response;

class ValidateIp extends Middleware
{
    public function handle($request, Closure $next, ...$args): Response
    {
        if (auth()->check() && $request->ip() !== session('ip')) {
            session()->flush();
            abort(Response::HTTP_FORBIDDEN, 'You have been disconnected because your IP address has changed.');
        }

        return $next($request);
    }
}
