<?php

namespace Infrastructure\Http\Middleware\Token;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;

use Domain\TokenValidator;


class TokenIsValid
{
    /**
     * @var TokenValidator
     */
    private $validator;

    public function __construct(TokenValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @throws AuthenticationException
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        if (!$this->validator::isValidToken($token)) {
            throw new AuthenticationException("Invalid auth token ({$token})");
        }
        return $next($request);
    }
}
