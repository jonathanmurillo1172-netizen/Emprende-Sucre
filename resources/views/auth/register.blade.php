<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro - Emprendimientos Sucre</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Fuente moderna: Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Iconos Material Design -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
</head>

<body class="min-h-screen flex items-center justify-center p-4 py-12 relative bg-slate-50 font-['Outfit']">

    <!-- Fondo animado standard -->
    <div class="fixed inset-0 w-full h-full -z-10 overflow-hidden bg-[#f0fdf4]">
        <div class="absolute -top-[10%] -left-[10%] w-[600px] h-[600px] bg-gradient-to-r from-indigo-500 to-purple-500 mix-blend-multiply filter blur-[70px] opacity-70 animate-pulse"></div>
        <div class="absolute -bottom-[20%] -right-[10%] w-[500px] h-[500px] bg-gradient-to-r from-pink-500 to-rose-500 mix-blend-multiply filter blur-[70px] opacity-70 animate-pulse [animation-delay:2s]"></div>
        <div class="absolute bottom-[30%] left-[20%] w-[300px] h-[300px] bg-gradient-to-r from-blue-500 to-cyan-500 mix-blend-multiply filter blur-[70px] opacity-50 animate-pulse [animation-delay:4s]"></div>
    </div>

    <div class="w-full max-w-[500px] relative z-10">

        <!-- Card de Registro -->
        <div class="bg-white/85 backdrop-blur-xl border border-white/50 shadow-[0_25px_50px_-12px_rgba(0,0,0,0.1)] rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-8 md:p-10 relative overflow-hidden group">
            
            <!-- Efecto de brillo superior -->
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

            <!-- Encabezado -->
            <div class="text-center mb-6 sm:mb-8 relative">
                 <div class="inline-flex items-center justify-center w-14 h-14 sm:w-16 sm:h-16 rounded-[1.2rem] sm:rounded-[1.5rem] bg-gradient-to-tr from-slate-900 to-slate-700 text-white shadow-2xl shadow-slate-500/30 mb-3 sm:mb-4 transform group-hover:scale-110 group-hover:-rotate-3 transition-all duration-500 ring-4 ring-white/50">
                     <span class="material-icons-round text-2xl sm:text-3xl">rocket_launch</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight mb-2">Crear Cuenta</h1>
                <p class="text-slate-500 text-xs sm:text-sm font-medium px-4">Únete a nuestra comunidad de emprendedores.</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Nombre -->
                <div class="space-y-1">
                    <label for="name" class="block text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">
                        Nombre completo
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="material-icons-round text-slate-400 group-focus-within:text-pink-500 transition-colors duration-300">badge</span>
                        </div>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                            class="block w-full rounded-2xl border-none bg-slate-50/50 hover:bg-slate-100/80 focus:bg-white text-slate-800 pl-11 pr-4 py-3.5 text-sm ring-1 ring-slate-200 focus:ring-2 focus:ring-pink-500 transition-all outline-none font-medium placeholder-slate-400 shadow-inner"
                            placeholder="Juan Pérez">
                    </div>
                    @error('name')
                         <p class="text-xs text-red-500 font-bold ml-1 flex items-center gap-1 mt-1">
                            <span class="material-icons-round text-sm">error</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Correo -->
                <div class="space-y-1">
                    <label for="email" class="block text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">
                        Correo electrónico
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="material-icons-round text-slate-400 group-focus-within:text-purple-500 transition-colors duration-300">alternate_email</span>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                             class="block w-full rounded-2xl border-none bg-slate-50/50 hover:bg-slate-100/80 focus:bg-white text-slate-800 pl-11 pr-4 py-3.5 text-sm ring-1 ring-slate-200 focus:ring-2 focus:ring-purple-500 transition-all outline-none font-medium placeholder-slate-400 shadow-inner"
                            placeholder="nombre@correo.com">
                    </div>
                    @error('email')
                         <p class="text-xs text-red-500 font-bold ml-1 flex items-center gap-1 mt-1">
                            <span class="material-icons-round text-sm">error</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Contraseña -->
                <div class="space-y-1">
                    <label for="password" class="block text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">
                        Contraseña
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="material-icons-round text-slate-400 group-focus-within:text-indigo-500 transition-colors duration-300">lock</span>
                        </div>
                        <input type="password" id="password" name="password" required autocomplete="new-password"
                             class="block w-full rounded-2xl border-none bg-slate-50/50 hover:bg-slate-100/80 focus:bg-white text-slate-800 pl-11 pr-4 py-3.5 text-sm ring-1 ring-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all outline-none font-medium placeholder-slate-400 shadow-inner"
                            placeholder="••••••••••••">
                    </div>
                     @error('password')
                         <p class="text-xs text-red-500 font-bold ml-1 flex items-center gap-1 mt-1">
                            <span class="material-icons-round text-sm">error</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Confirmar Contraseña -->
                <div class="space-y-1">
                    <label for="password_confirmation" class="block text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">
                        Confirmar Contraseña
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="material-icons-round text-slate-400 group-focus-within:text-cyan-500 transition-colors duration-300">lock_reset</span>
                        </div>
                        <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                             class="block w-full rounded-2xl border-none bg-slate-50/50 hover:bg-slate-100/80 focus:bg-white text-slate-800 pl-11 pr-4 py-3.5 text-sm ring-1 ring-slate-200 focus:ring-2 focus:ring-cyan-500 transition-all outline-none font-medium placeholder-slate-400 shadow-inner"
                            placeholder="••••••••••••">
                    </div>
                </div>

                <!-- Botón -->
                <div class="pt-4">
                    <button type="submit"
                        class="w-full relative overflow-hidden group/btn px-4 py-4 rounded-2xl bg-slate-900 text-white text-sm font-extrabold tracking-wide hover:shadow-2xl hover:shadow-indigo-500/40 hover:-translate-y-1 transition-all duration-300">
                         <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-pink-600 via-purple-600 to-indigo-600 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></div>
                        <span class="relative flex items-center justify-center gap-2">
                           CREAR CUENTA
                           <span class="material-icons-round text-lg group-hover/btn:translate-x-1 transition-transform">person_add</span>
                        </span>
                    </button>
                </div>
            </form>

            <!-- Footer -->
             <div class="mt-8 text-center bg-slate-50/50 rounded-xl py-3 border border-slate-100/50">
                <p class="text-sm font-bold text-slate-500">
                    ¿Ya tienes una cuenta?
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:text-pink-600 hover:underline transition-colors ml-1">
                        Inicia sesión
                    </a>
                </p>
            </div>

        </div>
        
         <div class="text-center mt-8">
             <a href="/" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-indigo-700 hover:bg-indigo-100/50 px-5 py-2.5 rounded-full transition-all border border-transparent hover:border-indigo-200">
                <span class="material-icons-round text-lg">home</span>
                Volver al Inicio
            </a>
        </div>

    </div>

</body>
</html>
