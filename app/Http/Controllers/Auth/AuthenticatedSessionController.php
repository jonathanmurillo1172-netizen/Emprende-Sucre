<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Redirigir según el rol del usuario
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return redirect()->intended(route('admin.dashboard'))->with('swal_login', '¡Bienvenido, ' . $user->name . '!');
        } elseif ($user->isEntrepreneur()) {
            return redirect()->intended(route('entrepreneur.dashboard'))->with('swal_login', '¡Bienvenido, ' . $user->name . '!');
        }

        // Fallback por si el usuario no tiene un rol definido
        return redirect()->intended(route('admin.dashboard'))->with('swal_login', '¡Bienvenido, ' . $user->name . '!');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login')->with('swal_logout', '¡Hasta luego! Has cerrado sesión correctamente.');
    }
}
