<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\Venture;
use App\Models\Category;
use App\Models\Entrepreneur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstadisticaController extends Controller
{
    
    
    public function index(){
        // Solicitudes Pendientes (Emprendedores)
        $pendingEntrepreneurs = Entrepreneur::with('user')
            ->whereNotNull('activation_requested_at')
            ->where('status', 'inactive')
            ->get();

        // Conteos Generales
        $totalUsers = User::count();
        $approvedVentures = Venture::where('status', 'active')->count();
        $pendingVentures = Venture::where('status', 'inactive')->count();
        $categoriesCount = Category::count();

        // Datos para Gráfico: Emprendimientos por Categoría
        $venturesByCategory = Category::withCount('ventures')
            ->get()
            ->map(function ($category) {
                return [
                    'name' => $category->name,
                    'count' => $category->ventures_count,
                    'color' => $this->getRandomColor() // Helper simple
                ];
            });

        // Datos para Gráfica: Estado (Aprobados vs Pendientes)
        // Ya tenemos las variables arriba, solo las pasamos para el JS

        return view('app.back.admin.Datos estadisticos.estadisticas', compact(
            'totalUsers', 
            'approvedVentures', 
            'pendingVentures', 
            'categoriesCount',
            'venturesByCategory',
            'pendingEntrepreneurs'
        ));
    }

    private function getRandomColor() {
        $colors = ['#6366F1', '#EC4899', '#F59E0B', '#10B981', '#3B82F6', '#8B5CF6', '#EF4444'];
        return $colors[array_rand($colors)];
    }
}
