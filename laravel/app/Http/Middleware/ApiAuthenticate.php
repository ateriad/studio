<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\Token\Token;
use Auth;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiAuthenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param array $guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $t = $request->header('Authorization');

        if ($t && Str::startsWith($t, 'Bearer ')) {
            /** @var Token $token */
            $token = app(Token::class);

            if ($userId = $token->extract(substr($t, strlen('Bearer ')))) {
                if ($user = User::find($userId)) {
                    Auth::setUser($user);

                    return $next($request);
                }
            }
        }

        return new JsonResponse(['message' => 'Unauthorized.'], 401);
    }
}
