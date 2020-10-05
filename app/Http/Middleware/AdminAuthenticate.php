<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\TransformsRequest;
use Illuminate\Http\Request;

class AdminAuthenticate extends TransformsRequest
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string|null $guard
     * @return mixed|void
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (auth()->user()->isAdmin()) {
            return $next($request);
        }

        abort(403);
    }
}
