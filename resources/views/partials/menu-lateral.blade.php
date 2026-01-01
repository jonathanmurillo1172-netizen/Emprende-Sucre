    @if (auth()->user()->isAdmin())
        <!-- ASIDE ADMIN -->
        <aside
            class="w-64 bg-white/80 backdrop-blur-xl shadow-xl border-r border-white/40
                   fixed lg:static inset-y-0 left-0 z-50 overflow-y-auto
                   lg:translate-x-0 transition-transform duration-300 ease-in-out"
            :class="{ '-translate-x-full': !openSidebar, 'translate-x-0': openSidebar }">

            <!-- HEADER ADMIN -->
            <div class="p-6 flex justify-between items-center md:block">
                <a href="{{ route('admin.estadistica.index') }}"
                    class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                    <div
                        class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-indigo-600 to-fuchsia-500
                               flex items-center justify-center text-white shadow-lg">
                        <span class="material-icons text-xl">admin_panel_settings</span>
                    </div>
                    <div class="leading-tight">
                        <h1
                            class="text-lg font-extrabold bg-gradient-to-r from-indigo-600 to-fuchsia-500 bg-clip-text text-transparent">
                            Sucre Admin
                        </h1>
                        <span class="text-xs font-bold text-indigo-500 uppercase tracking-widest">
                            Panel de Control
                        </span>
                    </div>
                </a>

                <button class="lg:hidden material-icons text-slate-400 hover:text-slate-600"
                    @click="openSidebar = false">close</button>
            </div>

            <nav class="mt-6 px-3">
                <ul class="space-y-1 text-sm">

                    <h2 class="px-4 mt-6 text-xs font-bold text-slate-400 uppercase">Datos estadisticos</h2>

                    <li>
                        <a href="{{ route('admin.estadistica.index') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all
                           {{ request()->routeIs('admin.estadistica*')
                               ? 'bg-gradient-to-r from-indigo-500 to-fuchsia-500 text-white font-bold shadow'
                               : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}">
                            <span class="material-icons">analytics</span>
                            Estadísticas Globales
                        </a>
                    </li>

                    <h2 class="px-4 mt-6 text-xs font-bold text-slate-400 uppercase">Emprendimientos</h2>

                    <li>
                        <a href="{{ route('admin.validar.index') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all
                           {{ request()->routeIs('admin.validar*')
                               ? 'bg-gradient-to-r from-indigo-500 to-fuchsia-500 text-white font-bold shadow'
                               : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}">
                            <span class="material-icons">hourglass_bottom</span>
                            Validar Emprendimientos
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('admin.emprendimientos.index') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all
                           {{ request()->routeIs('admin.emprendimientos*')
                               ? 'bg-gradient-to-r from-indigo-500 to-fuchsia-500 text-white font-bold shadow'
                               : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}">
                            <span class="material-icons">task_alt</span>
                            Emprendimientos Aprobados
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.usuarios.index') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all
                           {{ request()->routeIs('admin.usuarios*')
                               ? 'bg-gradient-to-r from-indigo-500 to-fuchsia-500 text-white font-bold shadow'
                               : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}">
                            <span class="material-icons">group</span>
                            Usuarios
                        </a>
                    </li>

                    <h2 class="px-4 mt-6 text-xs font-bold text-slate-400 uppercase">Administración Catálogo</h2>

                    <li>
                        <a href="{{ route('admin.categoria.index') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all
                           {{ request()->routeIs('admin.categoria.index')
                               ? 'bg-gradient-to-r from-indigo-500 to-fuchsia-500 text-white font-bold shadow'
                               : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}">
                            <span class="material-icons">category</span>
                            Categorías
                        </a>
                    </li>

                    <h2 class="px-4 mt-6 text-xs font-bold text-slate-400 uppercase">Perfil</h2>

                    <li x-data="{ open: {{ request()->routeIs('profile.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-2xl transition-all
                                   {{ request()->routeIs('profile.*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
                            <div class="flex items-center gap-3">
                                <span class="material-icons">account_circle</span>
                                <span>Perfil</span>
                            </div>
                            <span class="material-icons transition-transform duration-300"
                                :class="open ? 'rotate-180' : ''">expand_more</span>
                        </button>

                        <ul x-show="open" x-collapse class="pl-4 mt-1 space-y-1">
                            <li>
                                <a href="{{ route('admin.profile.show', ['profile' => auth()->id()]) }}"
                                    class="flex items-center gap-3 px-4 py-2 rounded-xl text-sm transition-all
                                    {{ request()->routeIs('admin.profile.show') ? 'text-indigo-600 font-bold bg-indigo-50' : 'text-slate-500 hover:text-indigo-600 hover:bg-indigo-50' }}">
                                    <span class="material-icons text-base">visibility</span>
                                    Ver Perfil
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center gap-3 px-4 py-2 rounded-xl text-sm transition-all
                                           {{ request()->routeIs('profile.edit') ? 'text-indigo-600 font-bold bg-indigo-50' : 'text-slate-500 hover:text-indigo-600 hover:bg-indigo-50' }}">
                                    <span class="material-icons text-base">edit</span>
                                    Editar Perfil
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </aside>
    @else
        <!-- ASIDE EMPRENDEDOR -->
        <aside
            class="w-64 bg-white/80 backdrop-blur-xl shadow-xl border-r border-white/40
           fixed inset-y-0 left-0 z-50 overflow-y-auto
           lg:translate-x-0 transition-transform duration-300 ease-in-out lg:sticky lg:top-0 lg:h-screen"
            :class="{ '-translate-x-full': !openSidebar, 'translate-x-0': openSidebar }">

            <!-- HEADER EMPRENDEDOR -->
            <div class="p-6 flex justify-between items-center md:block">
                <a href="{{ route('entrepreneur.dashboard') }}"
                    class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                    <div
                        class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-sky-400 to-indigo-600
                       flex items-center justify-center text-white shadow-lg">
                        <span class="material-icons text-xl">storefront</span>
                    </div>
                    <div class="leading-tight">
                        <h1
                            class="text-lg font-extrabold bg-gradient-to-r from-sky-600 to-indigo-700 bg-clip-text text-transparent">
                            Sucre Emprende
                        </h1>
                        <span class="text-xs font-bold text-sky-500 uppercase tracking-widest">
                            Emprendedor
                        </span>
                    </div>
                </a>

                <button class="lg:hidden material-icons text-slate-400 hover:text-slate-600"
                    @click="openSidebar = false">close</button>
            </div>

            <nav class="mt-6 px-3">
                <ul class="space-y-1 text-sm">

                    <!-- DASHBOARD -->
                    <li>
                        <a href="{{ route('entrepreneur.dashboard') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all
                   {{ request()->routeIs('entrepreneur.dashboard')
                       ? 'bg-gradient-to-r from-sky-500 to-indigo-600 text-white font-bold shadow-lg shadow-sky-200'
                       : 'text-slate-600 hover:bg-sky-50 hover:text-sky-600' }}">
                            <span class="material-icons">dashboard</span>
                            Dashboard
                        </a>
                    </li>

                    <h2 class="px-4 mt-6 text-xs font-bold text-slate-400 uppercase">
                        Mi Negocio
                    </h2>

                    @if(Auth::user()->entrepreneur->status === 'active')
                    <!-- CREAR EMPRENDIMIENTO -->
                    <li>
                        <a href="{{ route('entrepreneur.emprendimientos.create') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all
                   {{ request()->routeIs('entrepreneur.emprendimientos.create')
                       ? 'bg-gradient-to-r from-sky-500 to-indigo-600 text-white font-bold shadow-lg shadow-sky-200'
                       : 'text-slate-600 hover:bg-sky-50 hover:text-sky-600' }}">
                            <span class="material-icons">store</span>
                            Crear Emprendimiento
                        </a>
                    </li>

                    <!-- EMPRENDIMIENTOS -->
                    <li>
                        <a href="{{ route('entrepreneur.emprendimientos.index') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all
                   {{ request()->routeIs('entrepreneur.emprendimientos.index', 'entrepreneur.emprendimientos.edit')
                       ? 'bg-gradient-to-r from-sky-500 to-indigo-600 text-white font-bold shadow-lg shadow-sky-200'
                       : 'text-slate-600 hover:bg-sky-50 hover:text-sky-600' }}">
                            <span class="material-icons">inventory_2</span>
                            Mis Emprendimientos
                        </a>
                    </li>

                    <!-- CONSULTAS -->
                    <li>
                        <a href="{{ route('entrepreneur.consultas.index') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all
                   {{ request()->routeIs('entrepreneur.consultas.*')
                       ? 'bg-gradient-to-r from-sky-500 to-indigo-600 text-white font-bold shadow-lg shadow-sky-200'
                       : 'text-slate-600 hover:bg-sky-50 hover:text-sky-600' }}">
                            <span class="material-icons">email</span>
                            Consultas Recibidas
                        </a>
                    </li>

                    <!-- RESEÑAS -->
                    <li>
                        <a href="{{ route('entrepreneur.reviews.index') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all
                    {{ request()->routeIs('entrepreneur.reviews.index')
                        ? 'bg-gradient-to-r from-sky-500 to-indigo-600 text-white font-bold shadow-lg shadow-sky-200'
                        : 'text-slate-600 hover:bg-sky-50 hover:text-sky-600' }}">
                            <span class="material-icons">rate_review</span>
                            Reseñas
                        </a>
                    </li>
                    @else
                        <!-- OPCIONES BLOQUEADAS -->
                        <li class="px-4 py-2 opacity-50 cursor-not-allowed">
                             <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl text-center">
                                <span class="material-icons text-slate-300 text-3xl mb-2">lock</span>
                                <p class="text-xs text-slate-400 font-medium">Funciones bloqueadas hasta activación</p>
                            </div>
                        </li>
                    @endif

                    <h2 class="px-4 mt-6 text-xs font-bold text-slate-400 uppercase">
                        Plataforma
                    </h2>

                    <!-- VER CATÁLOGO -->
                    <li>
                        <a href="{{ route('home') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all
                   {{ request()->routeIs('catalogo.*')
                       ? 'bg-gradient-to-r from-sky-500 to-indigo-600 text-white font-bold shadow-lg shadow-sky-200'
                       : 'text-slate-600 hover:bg-sky-50 hover:text-sky-600' }}">
                            <span class="material-icons">public</span>
                            Ver Catálogo
                        </a>
                    </li>


                    <li x-data="{ open: {{ request()->routeIs('profile.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-2xl transition-all
                                   {{ request()->routeIs('profile.*') ? 'text-sky-600 bg-sky-50' : 'text-slate-600 hover:bg-sky-50 hover:text-sky-600' }}">
                            <div class="flex items-center gap-3">
                                <span class="material-icons">account_circle</span>
                                <span>Perfil</span>
                            </div>
                            <span class="material-icons transition-transform duration-300"
                                :class="open ? 'rotate-180' : ''">expand_more</span>
                        </button>

                        <ul x-show="open" x-collapse class="pl-4 mt-1 space-y-1">
                            <li>
                                <a href="{{ route('entrepreneur.profile.show', ['profile' => auth()->id()]) }}"
                                    class="flex items-center gap-3 px-4 py-2 rounded-xl text-sm transition-all
                                    {{ request()->routeIs('entrepreneur.profile.show') ? 'text-sky-600 font-bold bg-sky-50' : 'text-slate-500 hover:text-sky-600 hover:bg-sky-50' }}">
                                    <span class="material-icons text-base">visibility</span>
                                    Ver Perfil
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center gap-3 px-4 py-2 rounded-xl text-sm transition-all
                                           {{ request()->routeIs('profile.edit') ? 'text-sky-600 font-bold bg-sky-50' : 'text-slate-500 hover:text-sky-600 hover:bg-sky-50' }}">
                                    <span class="material-icons text-base">edit</span>
                                    Editar Perfil
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </aside>
    @endif

    <!-- OVERLAY MÓVIL -->
    <div class="fixed inset-0 bg-black/30 backdrop-blur-sm z-40 lg:hidden" x-show="openSidebar"
        @click="openSidebar = false"></div>
