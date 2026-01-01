{{-- ================= FONDO ANIMADO PREMIUM ================= --}}
<div class="fixed inset-0 -z-10 overflow-hidden bg-gradient-to-br from-slate-500 via-indigo-50 to-fuchsia-50">

    <div
        class="absolute -top-40 -left-40 w-[700px] h-[700px] bg-indigo-300/40 rounded-full blur-[120px]
               animate-[float_18s_ease-in-out_infinite]">
    </div>

    <div
        class="absolute -bottom-40 -right-40 w-[650px] h-[650px] bg-pink-300/40 rounded-full blur-[120px]
               animate-[float_22s_ease-in-out_infinite]">
    </div>

    <div
        class="absolute top-1/3 left-1/2 -translate-x-1/2 w-[500px] h-[500px] bg-violet-300/40 rounded-full
               blur-[100px] animate-[float_26s_ease-in-out_infinite]">
    </div>

    <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-[0.04]"></div>
</div>

<style>
    @keyframes float {

        0%,
        100% {
            transform: translate(0, 0);
        }

        50% {
            transform: translate(40px, -60px);
        }
    }
</style>

{{--NAVBAR --}}
<nav
    class="fixed top-0 w-full z-50 bg-white/70 backdrop-blur-2xl border-b border-white/40
           shadow-[0_8px_30px_rgba(0,0,0,0.04)] transition-all duration-500">

    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        <!-- LOGO -->
        <a href="/" class="flex items-center gap-4 group">
            <div
                class="relative w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-600 via-violet-600 to-fuchsia-500
                       flex items-center justify-center text-white shadow-lg
                       group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">

                <span class="material-icons-round text-2xl">school</span>

                <div
                    class="absolute inset-0 rounded-2xl bg-indigo-500 blur-xl opacity-40
                           group-hover:opacity-70 transition">
                </div>
            </div>

            <div class="leading-tight">
                <h1
                    class="text-xl md:text-2xl font-extrabold text-slate-900 tracking-tight
                           group-hover:text-indigo-600 transition-colors">
                    Emprendimientos
                </h1>
                <span class="text-[11px] font-bold text-indigo-600 tracking-widest uppercase">
                    Instituto Sucre
                </span>
            </div>
        </a>

        <!-- ACCIONES -->
        <div class="flex items-center gap-3">

            <!-- LOGIN -->
            <a href="/login"
                class="group relative flex items-center gap-2 px-4 py-2.5 rounded-xl
                       text-sm font-semibold text-slate-600
                       hover:text-indigo-600 transition">

                <span class="material-icons-round text-lg">login</span>
                <span class="hidden md:inline">Iniciar sesión</span>

                <span
                    class="absolute left-1/2 -bottom-1 h-0.5 w-0 bg-indigo-600
                           group-hover:w-1/2 group-hover:left-1/4 transition-all duration-300">
                </span>
            </a>

            <!-- REGISTRO -->
            <a href="/register"
                class="relative overflow-hidden flex items-center gap-2 px-5 py-2.5 rounded-xl
                       bg-slate-900 text-white text-sm font-bold
                       hover:bg-indigo-600
                       shadow-md hover:shadow-indigo-500/40
                       transition-all duration-300 hover:-translate-y-0.5">

                <span class="material-icons-round text-lg">person_add</span>
                <span class="hidden md:inline">Registrarse</span>

                <span
                    class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent
                           translate-x-[-150%] hover:translate-x-[150%]
                           transition-transform duration-700">
                </span>
            </a>

        </div>

    </div>
</nav>
