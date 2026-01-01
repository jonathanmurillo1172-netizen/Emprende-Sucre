<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Defino los permisos para mis roles

        // Aqui defino que solo el administrador puede entrar
        Gate::define('access-admin', fn($user) => $user->isAdmin());

        // Aqui defino que solo el emprendedor puede entrar
        Gate::define('access-entrepreneur', fn($user) => $user->isEntrepreneur());

        // Compartir contador de notificaciones con la barra de navegación
        \Illuminate\Support\Facades\View::composer('partials.nav-superior', function ($view) {
            $pendingCount = 0;
            $entrepreneurNotifications = collect();
            $entrepreneurCount = 0;

            if (auth()->check()) {
                $user = auth()->user();

                // Lógica Administrador
                if ($user->isAdmin()) {
                    $pendingCount = \App\Models\Venture::where('status', 'inactive')
                        ->where('title', 'not like', '[RECHAZADO]%')
                        ->count();
                }

                // Lógica Emprendedor
                // (Notificaciones desactivadas por solicitud del usuario)
            }

            $view->with('pendingCount', $pendingCount)
                 ->with('entrepreneurNotifications', $entrepreneurNotifications)
                 ->with('entrepreneurCount', $entrepreneurCount);
        });
    }
}
