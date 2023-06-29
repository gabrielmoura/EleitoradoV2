<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\ValidateSignature as Middleware;
use Illuminate\Support\Carbon;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\Response;

class VerifyBanned extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  mixed  ...$args
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle($request, Closure $next, ...$args): Response
    {
        $banned_at = Carbon::parse(session()->get('user.banned_at'))->format('d/m/Y H:i:s');
        abort_if($this->hasBanned(), 403, 'Você foi banido em: '.$banned_at, [
            'banned' => session()->get('user.banned_at'),
        ]);

        return $next($request);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function hasBanned(): bool
    {
        return session()->get('company.banned') || session()->get('user.banned_at');
    }
}
