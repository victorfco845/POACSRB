<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         // Asegurarse de que el usuario esté autenticado
         $user = Auth::user();

         if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado.'], 401);
        }
         // Verificar si el usuario tiene level 1 o 2
         if ($user && in_array($user->level, [1, 2])) {
             return $next($request);
         }
 
         // Si no tiene permiso, devolver un error de 403
         return response()->json(['error' => 'No tienes acceso a esta ruta.'], 403);
    }
}
