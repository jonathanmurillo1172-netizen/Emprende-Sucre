<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>@yield('titulo')</title>

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('assets/admin/css/main-admin.css') }}">
    @yield('enlaces_css')

</head>

<body class="h-screen overflow-hidden flex bg-slate-50 font-sans text-gray-900" x-data="{ openSidebar: false }">

    <!-- SIDEBAR -->
    @include('partials.menu-lateral')

    <!-- CONTENEDOR PRINCIPAL -->
    <div class="flex-1 flex flex-col min-h-screen w-full transition-all duration-300">

        <!-- NAVBAR SUPERIOR -->
        @include('partials.nav-superior')

        <!-- CONTENIDO -->
        <main
            class="flex-1 p-6 lg:p-10 overflow-y-auto relative
           bg-[radial-gradient(circle_at_20%_20%,rgba(139,92,246,0.25),transparent_40%),radial-gradient(circle_at_80%_80%,rgba(99,102,241,0.25),transparent_40%),linear-gradient(135deg,rgba(255,255,255,0.85),rgba(245,243,255,0.9))]
           backdrop-blur-xl
           animate-bg-flow">



            <div class="max-w-7xl mx-auto animate-fade-in-up">
                @yield('contenido-principal')
            </div>

        </main>

    </div>

    <!-- SCRIPTS PARA GRÁFICAS -->
    <script>
        @yield('scripts')
    </script>

    <!-- SCRIPT PARA LOGOUT -->
    <script>
        function confirmLogout() {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas cerrar sesión?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, salir',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>

    <!-- SCRIPT GLOBAL SWEET ALERT -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('swal_success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: '{{ session('swal_success') }}',
                    confirmButtonColor: '#4f46e5',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

            @if (session('swal_error'))
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: '{{ session('swal_error') }}',
                    confirmButtonColor: '#dc2626',
                    confirmButtonText: 'Entendido'
                });
            @endif

            @if (session('swal_login'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Bienvenido!',
                    text: "{{ session('swal_login') }}",
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#4f46e5'
                });
            @endif
        });
    </script>
</body>

@yield('scrip-final')

</html>
