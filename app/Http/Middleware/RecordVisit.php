<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecordVisit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Si la ruta tiene un ID (venture_id) y es una respuesta exitosa
        if ($request->route('id') && $response->getStatusCode() === 200) {
            $ventureId = $request->route('id');
            $sessionKey = 'visited_venture_' . $ventureId;

            // Evitamos contar duplicados en la misma sesión durante 30 minutos
            if (!$request->session()->has($sessionKey)) {
                \App\Models\Visit::create([
                    'venture_id' => $ventureId,
                    'ip_address' => $request->ip(),
                ]);
                $request->session()->put($sessionKey, now()->addMinutes(30));
            }
        }

        return $response;
    }
}
