<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Completar Perfil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine-->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Fuente -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />
</head>

<body
    class="bg-slate-50 font-['Outfit'] min-h-screen w-full overflow-y-auto overflow-x-hidden flex md:items-center md:justify-center py-8 px-4 relative">
    <!-- Fondo -->
    <div class="fixed inset-0 -z-10 overflow-hidden bg-[#f0fdf4]">
        <div
            class="absolute -top-[20%] -left-[20%] w-[600px] h-[600px] bg-gradient-to-r from-indigo-500 to-purple-500 blur-[90px] opacity-60">
        </div>
        <div
            class="absolute -bottom-[25%] -right-[20%] w-[500px] h-[500px] bg-gradient-to-r from-pink-500 to-rose-500 blur-[90px] opacity-60">
        </div>
    </div>

    <!-- CONTENEDOR -->
    @include('partials.completar-perfil')

</body>
@section('script')
    <script src="{{ asset('assets/admin/js/alerta-completar-perfil.js') }}"></script>
@endsection

</html>
