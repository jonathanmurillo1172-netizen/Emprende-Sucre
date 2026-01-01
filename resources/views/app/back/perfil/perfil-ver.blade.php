@extends('layouts.template-back')
@section('titulo', 'Ver Perfil')

@section('contenido-principal')
    <div class="w-full max-w-4xl relative z-10 space-y-8">
        <!-- CARD 1: VER PERFIL -->
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
                        <span class="material-icons text-4xl">person</span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-black text-slate-800 mb-2">Mi Perfil</h1>
                    <p class="text-slate-500 text-sm">Información personal registrada</p>
                </div>

                <!-- INFO DISPLAY -->
                <div class="space-y-8">

                    <!-- FILA 1 -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- NOMBRE -->
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase ml-1">Nombre completo</label>
                            <div class="relative group">
                                <span
                                    class="absolute inset-y-0 left-4 flex items-center pointer-events-none material-icons text-slate-400">person</span>
                                <div
                                    class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-slate-50/40 text-slate-700 text-sm font-medium ring-1 ring-slate-200 shadow-inner">
                                    {{ $user->name }}
                                </div>
                            </div>
                        </div>

                        <!-- EMAIL -->
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase ml-1">Correo electrónico</label>
                            <div class="relative group">
                                <span
                                    class="absolute inset-y-0 left-4 flex items-center pointer-events-none material-icons text-slate-400">
                                    alternate_email
                                </span>
                                <div
                                    class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-slate-50/40 text-slate-700 text-sm font-medium ring-1 ring-slate-200 shadow-inner">
                                    {{ $user->email }}
                                </div>
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
                                    class="absolute inset-y-0 left-4 flex items-center pointer-events-none material-icons text-slate-400">phone</span>
                                <div
                                    class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-slate-50/40 text-slate-700 text-sm font-medium ring-1 ring-slate-200 shadow-inner">
                                    {{ $role === 'admin' ? $user->admin->phone ?? 'No registrado' : ($role === 'entrepreneur' ? $user->entrepreneur->phone ?? 'No registrado' : 'No registrado') }}
                                </div>
                            </div>
                        </div>

                        <!-- GÉNERO (Solo para Emprendedor) -->
                        @if ($role === 'entrepreneur')
                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase ml-1">Género</label>
                                <div class="relative group">
                                    <span
                                        class="absolute inset-y-0 left-4 flex items-center pointer-events-none material-icons text-slate-400">wc</span>
                                    <div
                                        class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-slate-50/40 text-slate-700 text-sm font-medium ring-1 ring-slate-200 shadow-inner">
                                        {{ $user->entrepreneur->gender ?? 'No especificado' }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- DESCRIPCIÓN -->
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase ml-1">Descripción</label>
                        <div class="relative group">
                            <span
                                class="absolute top-4 left-4 pointer-events-none material-icons text-slate-400">description</span>
                            <div
                                class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-slate-50/40 text-slate-700 text-sm font-medium ring-1 ring-slate-200 shadow-inner min-h-[120px] whitespace-pre-wrap">{{ $role === 'admin' ? $user->admin->description ?? 'Sin descripción' : ($role === 'entrepreneur' ? $user->entrepreneur->description ?? 'Sin descripción' : 'Sin descripción') }}</div>
                        </div>
                    </div>

                    <!-- BOTÓN EDITAR PERFIL -->
                    <div class="pt-4 flex justify-end">
                        <a href="{{ route('profile.edit') }}"
                            class="relative overflow-hidden group/btn px-6 py-3 rounded-2xl bg-indigo-600 text-white text-sm font-bold tracking-wide hover:shadow-xl hover:shadow-indigo-500/30 hover:-translate-y-0.5 transition-all duration-300 inline-flex items-center gap-2">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300">
                            </div>
                            <span class="relative flex items-center gap-2">
                                Editar Perfil
                                <span class="material-icons text-lg">edit</span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection