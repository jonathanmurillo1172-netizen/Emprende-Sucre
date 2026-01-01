<?php

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VentureController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\EstadisticaController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\AdminVentureController;
use App\Http\Controllers\DashboardEmprController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\ReviewController;


//RUTA HOME PUBLICA

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/emprendimiento/{id}/productos', [HomeController::class, 'showProducts'])->name('public.venture.products')->middleware('record.visit');
Route::post('/solicitar-informacion', [HomeController::class, 'storeInquiry'])->name('public.inquiry.store');

// Ruta dashboard que redirige según el rol del usuario
Route::get('/dashboard', function () {

    if (Gate::allows('access-admin')) {
        return redirect()->route('admin.estadistica.index');
    }
    //ruta para el emprendedor si no tiene perfil
    if (Gate::allows('access-entrepreneur')) {
        return redirect()->route('entrepreneur.dashboard');
    }
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');


// DASHBOARD ADMIN RUTAS
Route::middleware(['auth', 'verified', 'can:access-admin'])->prefix('admin')->name('admin.')->group(function () {
    // DASHBOARD
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');
    // PERFIL: Uso resource para manejar todo limpio
    Route::resource('completar-perfil', DashboardAdminController::class)->names('profile')->parameters(['completar-perfil' => 'profile']);
    //RUTAS CATEGORIA
    Route::resource('categorias', CategoryController::class)->names('categoria');
    //RUTAS USUARIOS
    Route::resource('usuarios', UserController::class)->names('usuarios');
    //RUTAS DATOS ESTADISTICOS
    Route::get('/estadisticas', [EstadisticaController::class, 'index'])->name('estadistica.index');

    // RUTAS ACTIVACION EMPRENDEDORES
    Route::post('/entrepreneurs/{id}/approve', [DashboardAdminController::class, 'approveActivation'])->name('entrepreneurs.approve');
    Route::post('/entrepreneurs/{id}/reject', [DashboardAdminController::class, 'rejectActivation'])->name('entrepreneurs.reject');

    // RUTAS VALIDAR EMPRENDIMIENTOS
    Route::resource('validar-emprendimientos', SolicitudController::class)->only(['index'])->names('validar'); 
    // Rutas adicionales para acciones específicas (no cubiertas por resource estándar)
    Route::post('/validar-emprendimientos/{id}/aprobar', [SolicitudController::class, 'approve'])->name('validar.approve');
    Route::post('/validar-emprendimientos/{id}/rechazar', [SolicitudController::class, 'disapprove'])->name('validar.disapprove');
    Route::get('validar/productos/{id}', [SolicitudController::class, 'showProducts'])->name('validar.productos');
    
    // RUTAS EMPRENDIMIENTOS APROBADOS
    Route::resource('emprendimientos', AdminVentureController::class)->only(['index', 'destroy']);   
    Route::get('emprendimientos/{id}/productos', [AdminVentureController::class, 'showProducts'])->name('emprendimientos.productos');
    Route::post('emprendimientos/{id}/toggle-status', [AdminVentureController::class, 'toggleVentureStatus'])->name('emprendimientos.toggle-status');
    Route::post('productos/{id}/toggle-status', [AdminVentureController::class, 'toggleProductStatus'])->name('products.toggle-status');
});

// RUTA DE NOTIFICACIONES ELIMINADA (Revertido por usuario)


// DASHBOARD EMPRENDEDOR
Route::middleware(['auth', 'verified', 'can:access-entrepreneur'])->prefix('emprendedor')->name('entrepreneur.')->group(function () {
    // DASHBOARD
    Route::get('/dashboard', [DashboardEmprController::class, 'index'])->name('dashboard');
    Route::post('/request-activation', [DashboardEmprController::class, 'requestActivation'])->name('request.activation');

    // PERFIL: Igual aquí, uso resource simplificado
    Route::resource('completar-perfil', DashboardEmprController::class)->names('profile')->parameters(['completar-perfil' => 'profile']);
    //Rutas de crear Emprendimientos 
    Route::resource('crear-emprendimiento', VentureController::class)->names('emprendimientos');
    // Rutas de productos (anidadas en emprendimientos)
    Route::resource('emprendimientos.productos', ProductController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    
    // RUTAS DE CONSULTAS
    Route::resource('consultas', InquiryController::class)->only(['index', 'destroy']);
    Route::post('consultas/{id}/toggle-status', [InquiryController::class, 'toggleStatus'])->name('consultas.toggle-status');

    // RUTAS DE RESEÑAS (Dashboard)
    Route::get('/reseñas', [ReviewController::class, 'entrepreneurIndex'])->name('reviews.index');
    Route::delete('/reseñas/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});


// RUTAS PÚBLICAS DE RESEÑAS
Route::get('/products/{id}/reviews', [ReviewController::class, 'index'])->name('public.reviews.index');
Route::post('/products/{id}/reviews', [ReviewController::class, 'store'])->name('public.reviews.store');


















Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
