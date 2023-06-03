<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Middleware\ValidateSignature as Middleware;

class AjaxOnly extends Middleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @param ...$args
     * @return JsonResponse|Response
     */
    public function handle($request, Closure $next, ...$args): Response|JsonResponse
    {
        if ($request->ajax()) {
            return $next($request);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
