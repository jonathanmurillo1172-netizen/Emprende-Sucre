<?php

namespace App\Http\Controllers;

use App\Models\Admin;

use App\Models\Entrepreneur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardAdminController extends Controller
{
    public function index(){
        if (!Auth::user()->admin) {
            return redirect()->route('admin.profile.create');
        }
        session()->reflash();
        return redirect()->route('admin.estadistica.index'); 
    }

    // Muestro el formulario de perfil si soy admin
    public function create()
    {
        if (Auth::user()->admin) {
            return redirect()->route('admin.dashboard');
        }
        return view('app.back.perfil.perfil-completar', ['role' => 'admin']);
    }

    // Ver perfil (Read-only)
    public function show($id)
    {
        // $id viene por la ruta resource, pero usaremos Auth::user() para seguridad
        // o validamos que $id sea el del usuario actual. 
        // Como es "Mi Perfil", ignoramos $id y mostramos el propio.
        
        return view('app.back.perfil.perfil-ver', [
            'user' => Auth::user(),
            'role' => 'admin'
        ]);
    }

    // Guardo los datos del admin y redirijo
    public function store(Request $request)
    {
        // Validación básica, ajusta según necesites
        $request->validate([
            'phone' => 'required|string|max:20',
            'description' => 'nullable|string|max:500',
            
        ]);

        Admin::create([
            'user_id' => Auth::id(),
            'phone' => $request->phone,
            'description' => $request->description,
            'status' => 'active'
        ]);

        return redirect()->route('admin.dashboard')->with('swal_success', '¡Perfil creado exitosamente! Bienvenido.');
    }

    public function approveActivation($id)
    {
        $entrepreneur = Entrepreneur::findOrFail($id);
        $entrepreneur->update([
            'status' => 'active',
            'activation_requested_at' => null
        ]);

        return response()->json(['success' => true, 'message' => 'Cuenta activada correctamente']);
    }

    public function rejectActivation($id)
    {
        $entrepreneur = Entrepreneur::findOrFail($id);
        $entrepreneur->update([
            'activation_requested_at' => null
        ]);

        return response()->json(['success' => true, 'message' => 'Solicitud rechazada']);
    }

    // Editar perfil
    public function edit($id)
    {
        $admin = Auth::user()->admin;
        
        // Ensure user can only edit their own profile
        if (!$admin || $admin->id != $id) {
            abort(403);
        }

        return view('app.back.perfil.perfil-editar', [
            'user' => Auth::user(),
            'role' => 'admin'
        ]);
    }

    // Actualizar perfil
    public function update(Request $request, $id)
    {
        $admin = Auth::user()->admin;
        $user = Auth::user();

        if (!$admin || $admin->id != $id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'description' => 'nullable|string|max:500',
            'current_password' => 'nullable',
            'password' => 'nullable|confirmed|min:8',
        ]);

        // Update User model
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update Admin model
        $admin->update([
            'phone' => $request->phone,
            'description' => $request->description,
        ]);

        // Update password if provided
        if ($request->filled('current_password') && $request->filled('password')) {
            if (!\Hash::check($request->current_password, $user->password)) {
                return back()->with('swal_error', 'La contraseña actual no es correcta.');
            }
            $user->update(['password' => \Hash::make($request->password)]);
        }

        return redirect()->route('admin.estadistica.index')->with('swal_success', '¡Perfil actualizado correctamente!');
    }
}
