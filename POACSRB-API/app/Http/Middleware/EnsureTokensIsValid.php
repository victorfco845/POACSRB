<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokensIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('API-TOKEN');
        if ($token !== env('API_TOKEN'))
        {
            return response()->json(['error' => 'No tienes Acceso'], 401);
        }
        
        return $next($request);
    }
}
