<div class="w-full max-w-4xl relative z-10">
    <!-- CARD -->
    <div
        class="rounded-[2.5rem] overflow-hidden bg-white/90 backdrop-blur-xl border border-white/50 shadow-[0_25px_50px_-12px_rgba(0,0,0,0.15)]">
        <!-- Barra superior -->
        <div class="w-full h-2 md:h-2.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
        <!-- Contenido -->
        <div class="p-6 sm:p-8 md:p-12">
            <!-- Header -->
            <div class="text-center mb-10">
                <div
                    class="mx-auto mb-6 w-20 h-20 rounded-[2rem] bg-gradient-to-tr from-indigo-600 via-violet-600 to-fuchsia-500 text-white flex items-center justify-center shadow-2xl ring-4 ring-white/50">
                    <span class="material-icons-round text-4xl">person</span>
                </div>

                <h1 class="text-2xl sm:text-3xl font-black text-slate-800 mb-2">¡Bienvenido, {{ auth()->user()->name }}!
                </h1>
                <p class="text-slate-500 text-sm">Completa tu perfil para continuar</p>
            </div>

            <!-- FORM -->
            <form id="profileForm" class="space-y-8" method="POST"
                action="{{ $role === 'admin' ? route('admin.profile.store') : route('entrepreneur.profile.store') }}">
                @csrf
                <!-- FILA 1 -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- NOMBRE -->
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase ml-1">Nombre completo</label>
                        <div class="relative group">
                            <span
                                class="absolute inset-y-0 left-4 flex items-center pointer-events-none material-icons-round text-slate-400 group-focus-within:text-indigo-600 transition-colors">person</span>
                            <input type="text" value="{{ auth()->user()->name }}" readonly
                                class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-slate-100 text-slate-500 text-sm font-medium ring-1 ring-slate-200 outline-none cursor-not-allowed" />
                        </div>
                    </div>

                    <!-- EMAIL -->
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase ml-1">Correo electrónico</label>
                        <div class="relative group">
                            <span
                                class="absolute inset-y-0 left-4 flex items-center pointer-events-none material-icons-round text-slate-400 group-focus-within:text-purple-600 transition-colors">
                                alternate_email
                            </span>
                            <input type="email" value="{{ auth()->user()->email }}" readonly
                                class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-slate-100 text-slate-500 text-sm font-medium ring-1 ring-slate-200 outline-none cursor-not-allowed" />
                        </div>
                    </div>
                </div>

                <!-- FILA 2 -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- TELÉFONO -->
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase ml-1">Teléfono</label>
                        <div class="relative group">
                            <span
                                class="absolute inset-y-0 left-4 flex items-center pointer-events-none material-icons-round text-slate-400 group-focus-within:text-emerald-600 transition-colors">phone</span>
                            <input type="tel" name="phone" placeholder="0999999999"
                                class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-slate-50/60 hover:bg-slate-100/80 focus:bg-white text-slate-800 text-sm font-medium ring-1 ring-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none transition-all shadow-inner" />
                        </div>
                    </div>

                    <!-- GÉNERO (Solo para Emprendedor) -->
                    @if ($role === 'entrepreneur')
                        <div class="space-y-2" x-data="{ open: false, value: '', label: 'Seleccione una opción' }">
                            <label class="block text-xs font-bold text-slate-500 uppercase ml-1">Género</label>

                            <!-- Campo visual -->
                            <button type="button" @click="open = !open" @keydown.escape.window="open=false"
                                class="w-full text-left relative group rounded-2xl bg-slate-50/60 hover:bg-slate-100/80 focus:bg-white ring-1 ring-slate-200 focus:ring-2 focus:ring-pink-500 outline-none transition-all shadow-inner pl-11 pr-10 py-3.5 text-sm font-medium text-slate-800">
                                <!-- Icono -->
                                <span
                                    class="absolute inset-y-0 left-4 flex items-center pointer-events-none material-icons-round text-slate-400 group-focus-within:text-pink-600 transition-colors">wc</span>

                                <span x-text="label" class="block truncate text-slate-700"></span>

                                <!-- Flecha -->
                                <span
                                    class="absolute inset-y-0 right-4 flex items-center pointer-events-none material-icons-round text-slate-400 transition-transform"
                                    :class="open ? 'rotate-180' : ''">
                                    expand_more
                                </span>
                            </button>

                            <!-- Input real (para enviar en form) -->
                            <input type="hidden" name="gender" :value="value" />

                            <!-- Dropdown bonito -->
                            <div x-show="open" x-transition @click.outside="open=false"
                                class="mt-2 rounded-2xl overflow-hidden border border-slate-200 bg-white shadow-xl shadow-slate-900/10 ring-1 ring-white/50">
                                <button type="button" @click="value='Masculino'; label='Masculino'; open=false"
                                    class="w-full flex items-center gap-3 px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-pink-50 hover:text-pink-700 transition">
                                    <span class="w-2.5 h-2.5 rounded-full bg-pink-500"></span>
                                    Masculino
                                </button>

                                <button type="button" @click="value='Femenino'; label='Femenino'; open=false"
                                    class="w-full flex items-center gap-3 px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-pink-50 hover:text-pink-700 transition border-t border-slate-100">
                                    <span class="w-2.5 h-2.5 rounded-full bg-pink-500"></span>
                                    Femenino
                                </button>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- DESCRIPCIÓN -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase ml-1">Descripción</label>
                    <div class="relative group">
                        <span
                            class="absolute top-4 left-4 pointer-events-none material-icons-round text-slate-400 group-focus-within:text-blue-600 transition-colors">description</span>
                        <textarea name="description" rows="4" placeholder="Cuéntanos un poco sobre ti..."
                            class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-slate-50/60 hover:bg-slate-100/80 focus:bg-white text-slate-800 text-sm font-medium ring-1 ring-slate-200 focus:ring-2 focus:ring-blue-500 outline-none transition-all shadow-inner resize-none"></textarea>
                    </div>
                </div>

                <!-- BOTÓN (HOVER PRO COMO TU LOGIN) -->
                <div class="pt-4">
                    <button type="submit"
                        class="w-full relative overflow-hidden group/btn px-4 py-4 rounded-2xl bg-slate-900 text-white text-sm font-extrabold tracking-wide hover:shadow-2xl hover:shadow-indigo-500/40 hover:-translate-y-1 transition-all duration-300">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300">
                        </div>
                        <span class="relative flex items-center justify-center gap-2">
                            COMPLETAR PERFIL DE USUARIO
                            <span
                                class="material-icons-round text-lg group-hover/btn:translate-x-1 transition-transform">arrow_forward</span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
