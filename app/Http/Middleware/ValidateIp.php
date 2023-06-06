<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Middleware\ValidateSignature as Middleware;
use Symfony\Component\HttpFoundation\Response;

class ValidateIp extends Middleware
{
    public function handle($request, Closure $next, ...$args): Response
    {
        if ($request->ip() !== session('ip')) {
            session()->flush();
        }

        return $next($request);
    }
}
