<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Verificar Correo - Emprendimientos Sucre</title>
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

    <div class="w-full max-w-[450px] relative z-10">

        <!-- Mensaje de estado: Link enviado -->
        @if (session('status') == 'verification-link-sent')
            <div class="mb-6">
                <div class="flex items-start justify-between gap-3 rounded-2xl border-l-4 border-l-green-500 bg-white/90 backdrop-blur-xl px-5 py-4 text-sm text-slate-700 shadow-lg">
                    <span class="font-bold text-green-600 flex items-center gap-2">
                         <span class="material-icons-round text-lg">mark_email_read</span>
                        {{ __('Se ha enviado un nuevo enlace de verificación al correo electrónico que proporcionaste durante el registro.') }}
                    </span>
                    <button type="button" class="text-slate-400 hover:text-slate-600 transition-colors" onclick="this.parentElement.parentElement.remove()">
                        <span class="material-icons-round text-lg">close</span>
                    </button>
                </div>
            </div>
        @endif

        <!-- Card de Verificación -->
        <div class="bg-white/85 backdrop-blur-xl border border-white/50 shadow-[0_25px_50px_-12px_rgba(0,0,0,0.1)] rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-8 md:p-10 relative overflow-hidden group">
            
            <!-- Efecto de brillo superior -->
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

            <!-- Encabezado -->
            <div class="text-center mb-8 relative">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-[1.5rem] bg-gradient-to-tr from-blue-600 to-cyan-500 text-white shadow-2xl shadow-blue-500/30 mb-6 transform group-hover:scale-110 transition-all duration-500 ring-4 ring-white/50">
                     <span class="material-icons-round text-3xl">email</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight mb-4">Verifica tu correo</h1>
                <p class="text-slate-600 text-sm font-medium leading-relaxed">
                    {{ __('¡Gracias por registrarte! Antes de comenzar, ¿podrías verificar tu dirección de correo electrónico haciendo clic en el enlace que te acabamos de enviar? Si no recibiste el correo, con gusto te enviaremos otro.') }}
                </p>
            </div>

            <div class="space-y-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                        class="w-full relative overflow-hidden group/btn px-4 py-4 rounded-2xl bg-slate-900 text-white text-sm font-extrabold tracking-wide hover:shadow-2xl hover:shadow-blue-500/40 hover:-translate-y-1 transition-all duration-300">
                        <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-blue-600 to-cyan-600 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></div>
                        <span class="relative flex items-center justify-center gap-2">
                            REENVIAR CORREO DE VERIFICACIÓN
                            <span class="material-icons-round text-lg group-hover/btn:translate-x-1 transition-transform">send</span>
                        </span>
                    </button>
                </form>

                <div class="flex items-center justify-center pt-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-rose-600 hover:bg-rose-50 px-6 py-2.5 rounded-xl transition-all border border-transparent hover:border-rose-100">
                            <span class="material-icons-round text-lg">logout</span>
                            {{ __('Cerrar sesión') }}
                        </button>
                    </form>
                </div>
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

