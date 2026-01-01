<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Inquiry;
use App\Models\Entrepreneur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardEmprController extends Controller
{
    public function index()
    {
        $entrepreneur = Auth::user()->entrepreneur;

        if (!$entrepreneur) {
            return redirect()->route('entrepreneur.profile.create');
        }

        // Estadísticas básicas
        $venturesCount = $entrepreneur->ventures()->count();
        $pendingVenturesCount = $entrepreneur->ventures()->where('status', 'inactive')->count();
        
        $ventureIds = $entrepreneur->ventures->pluck('id');
        
        $inquiriesCount = Inquiry::whereIn('venture_id', $ventureIds)->count();
        $visitsCount = Visit::whereIn('venture_id', $ventureIds)->count();

        // Datos para Gráfica: Visitas por Emprendimiento
        $ventureVisits = $entrepreneur->ventures()
            ->withCount('visits')
            ->get()
            ->map(function($v) {
                return [
                    'label' => $v->title,
                    'count' => $v->visits_count
                ];
            });

        // Datos para Gráfica: Estado de Emprendimientos
        $states = [
            'Activos' => $entrepreneur->ventures()->where('status', 'active')->count(),
            'Pendientes' => $entrepreneur->ventures()->where('status', 'inactive')->count(),
            'Desactivados' => $entrepreneur->ventures()->where('status', 'disabled')->count(),
        ];

        return view('app.back.emprendedor.dashboard-empren', compact(
            'venturesCount', 
            'pendingVenturesCount', 
            'inquiriesCount', 
            'visitsCount',
            'ventureVisits',
            'states'
        ));
    }

    // Muestro el formulario de perfil si soy emprendedor
    public function create()
    {
        if (Auth::user()->entrepreneur) {
            return redirect()->route('entrepreneur.dashboard');
        }
        return view('app.back.perfil.perfil-completar', ['role' => 'entrepreneur']);
    }

    // Ver perfil (Read-only)
    public function show($id)
    {
        return view('app.back.perfil.perfil-ver', [
            'user' => Auth::user(),
            'role' => 'entrepreneur'
        ]);
    }

    // Guardo los datos del perfil y redirijo con éxito
    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'gender' => 'required|string|in:Masculino,Femenino',
            'description' => 'nullable|string|max:500',
        ]);

        Entrepreneur::create([
            'user_id' => Auth::id(),
            'phone' => $request->phone,
            'gender' => $request->gender,
            'description' => $request->description,
            'status' => 'inactive'
        ]);

        return redirect()->route('entrepreneur.dashboard')->with('swal_success', '¡Perfil creado exitosamente! Bienvenido.');
    }

    public function requestActivation()
    {
        $entrepreneur = Auth::user()->entrepreneur;
        
        if ($entrepreneur && $entrepreneur->status === 'inactive') {
            $entrepreneur->update([
                'activation_requested_at' => now()
            ]);
            
            return response()->json(['success' => true, 'message' => 'Solicitud enviada correctamente']);
        }

        return response()->json(['success' => false, 'message' => 'No se pudo enviar la solicitud'], 400);
    }

    // Editar perfil
    public function edit($id)
    {
        $entrepreneur = Auth::user()->entrepreneur;
        
        // Ensure user can only edit their own profile
        if (!$entrepreneur || $entrepreneur->id != $id) {
            abort(403);
        }

        return view('app.back.perfil.perfil-editar', compact('entrepreneur'));
    }

    // Actualizar perfil
    public function update(Request $request, $id)
    {
        $entrepreneur = Auth::user()->entrepreneur;
        $user = Auth::user();

        if (!$entrepreneur || $entrepreneur->id != $id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'gender' => 'required|string|in:Masculino,Femenino',
            'description' => 'nullable|string|max:500',
            'current_password' => 'nullable',
            'password' => 'nullable|confirmed|min:8',
        ]);

        // Update User model
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update Entrepreneur model
        $entrepreneur->update([
            'phone' => $request->phone,
            'gender' => $request->gender,
            'description' => $request->description,
        ]);

        // Update password if provided
        if ($request->filled('current_password') && $request->filled('password')) {
            if (!\Hash::check($request->current_password, $user->password)) {
                return back()->with('swal_error', 'La contraseña actual no es correcta.');
            }
            $user->update(['password' => \Hash::make($request->password)]);
        }

        return redirect()->route('entrepreneur.dashboard')->with('swal_success', '¡Perfil actualizado correctamente!');
    }
}
