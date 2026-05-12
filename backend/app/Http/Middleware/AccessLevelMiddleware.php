<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccessLevelMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(
        Request $request,
        Closure $next,
        ...$levels
    ): Response {

        $user = $request->user();

        if (!$user) {

            return response()->json([
                'success' => false,
                'message' => 'Usuário não autenticado'
            ], 401);
        }

        if (!in_array($user->access_level, $levels)) {

            return response()->json([
                'success' => false,
                'message' => 'Acesso não autorizado'
            ], 403);
        }

        return $next($request);
    }
}