<!-- HEADER / NAVBAR SUPERIOR -->
<header
    class="bg-gradient-to-r from-white/90 via-indigo-50/50 to-white/90 backdrop-blur-xl border-b border-white/40
           px-6 py-4 flex justify-between items-center
           shadow-sm sticky top-0 z-40">

    <!-- Título + hamburguesa -->
    <div class="flex items-center gap-4">

        <!-- Botón hamburguesa -->
        <button
            class="lg:hidden material-icons text-slate-600 text-3xl
                   hover:text-indigo-600 transition"
            @click="openSidebar = true">
            menu
        </button>

        <h2 class="text-lg md:text-xl font-extrabold tracking-tight text-slate-700">
            @if (auth()->user()->isAdmin())
                Administrador
            @else
                Emprendedor
            @endif
        </h2>
    </div>

    <!-- Acciones -->
    <div class="flex items-center gap-5">

        <!-- Notificaciones -->
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.validar.index') }}" class="relative group">
                <span class="material-icons text-slate-500 hover:text-indigo-600 transition text-2xl">
                    notifications
                </span>
                @if(isset($pendingCount) && $pendingCount > 0)
                    <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white shadow-sm ring-2 ring-white animate-pulse">
                        {{ $pendingCount }}
                    </span>
                @endif
            </a>
        @endif


        <!-- Icono Usuario + Nombre -->
        @php
            $profileRoute = auth()->user()->isAdmin() ? 'admin.profile.show' : 'entrepreneur.profile.show';
        @endphp
        <a href="{{ route($profileRoute, ['profile' => auth()->id()]) }}" class="flex items-center gap-2 cursor-pointer group">
            <span class="hidden sm:block text-sm font-semibold text-slate-600 group-hover:text-indigo-600 transition">
                Bienvenido, {{ auth()->user()->name }}
            </span>
            <span class="material-icons text-slate-500 text-3xl
               group-hover:text-indigo-600 transition">
                account_circle
            </span>
        </a>


            <!-- Logout -->
            <form id="logout-form" method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="button" onclick="confirmLogout()"
                    class="flex items-center gap-2 px-4 py-2 rounded-xl
                       text-red-600 font-semibold
                       hover:bg-red-50 hover:text-red-700
                       transition">
                    <span class="material-icons text-base">logout</span>
                    <span class="hidden sm:inline">Salir</span>
                </button>
            </form>

    </div>
</header>
