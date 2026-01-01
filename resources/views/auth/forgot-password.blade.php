<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña - Emprendimientos Sucre</title>
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

    <div class="w-full max-w-[420px] relative z-10">

        <!-- Mensaje de estado -->
        @if (session('status'))
            <div class="mb-6">
                <div class="flex items-start justify-between gap-3 rounded-2xl border-l-4 border-l-green-500 bg-white/90 backdrop-blur-xl px-5 py-4 text-sm text-slate-700 shadow-lg">
                    <span class="font-bold text-green-600 flex items-center gap-2">
                         <span class="material-icons-round text-lg">check_circle</span>
                        {{ session('status') }}
                    </span>
                    <button type="button" class="text-slate-400 hover:text-slate-600 transition-colors" onclick="this.parentElement.parentElement.remove()">
                        <span class="material-icons-round text-lg">close</span>
                    </button>
                </div>
            </div>
        @endif

        <!-- Card de Recuperación -->
        <div class="bg-white/85 backdrop-blur-xl border border-white/50 shadow-[0_25px_50px_-12px_rgba(0,0,0,0.1)] rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-8 md:p-12 relative overflow-hidden group">
            
            <!-- Efecto de brillo superior -->
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

            <!-- Encabezado -->
            <div class="text-center mb-8 relative">
                <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 rounded-[1.5rem] sm:rounded-[2rem] bg-gradient-to-tr from-indigo-600 via-violet-600 to-fuchsia-500 text-white shadow-2xl shadow-indigo-500/30 mb-4 sm:mb-6 transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 ring-4 ring-white/50">
                     <span class="material-icons-round text-3xl sm:text-4xl">key</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight mb-2">¿Olvidaste tu clave?</h1>
                <p class="text-slate-500 text-xs sm:text-sm font-medium px-4">No te preocupes. Danos tu correo y te enviaremos un enlace para restablecerla.</p>
            </div>

            <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Correo -->
                <div class="space-y-2">
                    <label for="email" class="block text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">
                        Correo electrónico
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="material-icons-round text-slate-400 group-focus-within:text-indigo-600 transition-colors duration-300">alternate_email</span>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            class="block w-full rounded-2xl border-none bg-slate-50/50 hover:bg-slate-100/80 focus:bg-white text-slate-800 pl-11 pr-4 py-3.5 text-sm ring-1 ring-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all outline-none font-medium placeholder-slate-400 shadow-inner"
                            placeholder="nombre@correo.com">
                    </div>
                     @error('email')
                        <p class="text-xs text-red-500 font-bold ml-1 flex items-center gap-1 mt-1">
                            <span class="material-icons-round text-sm">error</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Botón -->
                <div class="pt-4">
                    <button type="submit"
                        class="w-full relative overflow-hidden group/btn px-4 py-4 rounded-2xl bg-slate-900 text-white text-sm font-extrabold tracking-wide hover:shadow-2xl hover:shadow-indigo-500/40 hover:-translate-y-1 transition-all duration-300">
                        <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></div>
                        <span class="relative flex items-center justify-center gap-2">
                            ENVIAR ENLACE
                            <span class="material-icons-round text-lg group-hover/btn:translate-x-1 transition-transform">send</span>
                        </span>
                    </button>
                </div>
            </form>

            <!-- Footer -->
            <div class="mt-8 text-center border-top border-slate-100 pt-4">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm font-bold text-indigo-600 hover:text-indigo-800 transition-colors">
                    <span class="material-icons-round text-lg">arrow_back</span>
                    Volver al Inicio de Sesión
                </a>
            </div>

        </div>

    </div>

</body>
</html>

