<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authHeader = $request->header('x-api-key');
        $apiKey     = env('API_KEY');

        if ( (empty($authHeader)) || ($authHeader <> $apiKey) ) {
            return response(['message' => 'Chave de API inválida ou não informada']);
        }

        return $next($request);
    }
}