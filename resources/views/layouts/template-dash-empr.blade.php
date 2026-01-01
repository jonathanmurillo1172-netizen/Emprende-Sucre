<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>@yield('nombre-pagina')</title>
    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- Material Icons -->
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Round" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('css')

</head>

<body class="bg-gray-100 min-h-screen flex" x-data="{ openSidebar: false }">

    <!--SIDEBAR RESPONSIVE-->
    @include('partials.menu-lateral')

    <!--CONTENEDOR PRINCIPAL -->
    <div class="flex-1 flex flex-col">
        <!--HEADER / NAVBAR SUPERIOR-->
        @include('partials.nav-superior')

        <!--CONTENIDO DEL DASHBOARD -->
        <main class="p-6">

            @yield('contenido-principal')

        </main>

    </div>

    <!--SCRIPTS DE GRÁFICAS -->
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
        });
    </script>

</body>
@yield('scrip-final')


</html>
