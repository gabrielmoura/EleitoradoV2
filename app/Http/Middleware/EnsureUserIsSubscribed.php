<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EnsureUserIsSubscribed
 *
 * @description Redireciona os usuários para a página de cobrança se eles não estiverem inscritos
 */
class EnsureUserIsSubscribed
{
    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && ! session('subscribed')) {
            // This user is not a paying customer...
            return redirect('billing');
        }

        return $next($request);
    }
}
