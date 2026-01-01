<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{


    public function index(){
        return view('app.back.perfil.perfil-completar');
    }

    
    /**
     * Display the user's profile form.
     */
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $role = $request->user()->isAdmin() ? 'admin' : ($request->user()->isEntrepreneur() ? 'entrepreneur' : null);
        return view('app.back.perfil.perfil-editar', [
            'user' => $request->user(),
            'role' => $role
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // PRIMERO: Validar contraseña si se proporcionó (antes de guardar cualquier cosa)
        if ($request->filled('current_password')) {
            try {
                $request->validate([
                    'current_password' => ['required', 'current_password'],
                    'password' => ['required', 'confirmed', Password::defaults()],
                ]);
            } catch (ValidationException $e) {

                // Solo mostrar alerta SweetAlert si la contraseña actual es incorrecta
                if ($e->errors()['current_password'] ?? false) {
                    return back()->with('swal_error', 'La contraseña actual no es correcta.')->withInput();
                }
                throw $e;
            }
        }

        // SEGUNDO: Actualizar información básica del usuario
        $request->user()->fill($request->validated());
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // TERCERO: Actualizar datos adicionales según el rol
        if ($request->user()->isAdmin() && $request->user()->admin) {
            $request->validate([
                'phone' => 'nullable|string|max:20',
                'description' => 'nullable|string|max:500',
            ]);
            $request->user()->admin->update([
                'phone' => $request->phone,
                'description' => $request->description,
            ]);
        } elseif ($request->user()->isEntrepreneur() && $request->user()->entrepreneur) {
            $request->validate([
                'phone' => 'nullable|string|max:20',
                'description' => 'nullable|string|max:500',
                'gender' => 'nullable|string|max:20',
            ]);
            $request->user()->entrepreneur->update([
                'phone' => $request->phone,
                'description' => $request->description,
                'gender' => $request->gender,
            ]);
        }

        // CUARTO: Actualizar contraseña (ya validada arriba)
        if ($request->filled('current_password')) {
            $request->user()->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // Redirigir al dashboard específico según el rol
        if ($request->user()->isAdmin()) {
            return Redirect::route('admin.estadistica.index')->with('swal_success', '¡Perfil actualizado exitosamente!');
        } elseif ($request->user()->isEntrepreneur()) {
            return Redirect::route('entrepreneur.dashboard')->with('swal_success', '¡Perfil actualizado exitosamente!');
        }

        return Redirect::route('dashboard')->with('swal_success', '¡Perfil actualizado exitosamente!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse|JsonResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Cuenta eliminada correctamente']);
        }

        return Redirect::to('/')->with('swal_success', '¡Tu cuenta ha sido eliminada correctamente!');
    }
}
