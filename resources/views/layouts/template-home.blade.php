<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <title>Emprendimientos | Instituto Sucre</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Fuente moderna: Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Iconos Material Design -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('css')
</head>

<body class="text-slate-800 relative overflow-x-hidden antialiased bg-slate-50 font-['Outfit']">

    @include('partials.home.nav-superior-home')

    {{-- Contenido principal --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer Simple -->
    <footer class="text-center py-8 text-slate-400 text-sm font-medium">
        &copy; {{ date('Y') }} Instituto Sucre. Todos los derechos reservados.
    </footer>

</body>

@yield('scripts')

</html>
