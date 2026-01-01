@extends('layouts.template-back')
@section('titulo', 'Editar Perfil')

@section('contenido-principal')
    <div class="w-full max-w-4xl relative z-10 space-y-8">
        <!-- CARD 1: EDITAR PERFIL -->
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
                    <p class="text-slate-500 text-sm">Actualiza tu información personal</p>
                </div>

                <!-- FORM UPDATE INFO -->
                @php
                    $profileId = $role === 'admin' 
                        ? (Auth::user()->admin->id ?? null) 
                        : (Auth::user()->entrepreneur->id ?? null);
                @endphp
                
                @if($profileId)
                <form id="profileForm" class="space-y-8" method="POST" 
                    action="{{ $role === 'admin' ? route('admin.profile.update', $profileId) : route('entrepreneur.profile.update', $profileId) }}">
                    @csrf
                    @method('PUT')
                @else
                    <div class="bg-red-50 border border-red-200 rounded-2xl p-6 text-center">
                        <span class="material-icons text-red-500 text-4xl mb-2">error_outline</span>
                        <p class="text-red-700 font-semibold">No tienes un perfil creado aún.</p>
                        <p class="text-red-600 text-sm mt-2">Por favor, completa tu perfil primero.</p>
                    </div>
                    <form id="profileForm" class="space-y-8" style="display:none;">
                @endif

                    <!-- FILA 1 -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- NOMBRE -->
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase ml-1">Nombre completo</label>
                            <div class="relative group">
                                <span
                                    class="absolute inset-y-0 left-4 flex items-center pointer-events-none material-icons text-slate-400 group-focus-within:text-indigo-600 transition-colors">person</span>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                    autofocus autocomplete="name"
                                    class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-slate-50/60 hover:bg-slate-100/80 focus:bg-white text-slate-800 text-sm font-medium ring-1 ring-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-inner" />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <!-- EMAIL -->
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase ml-1">Correo electrónico</label>
                            <div class="relative group">
                                <span
                                    class="absolute inset-y-0 left-4 flex items-center pointer-events-none material-icons text-slate-400 group-focus-within:text-purple-600 transition-colors">
                                    alternate_email
                                </span>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                    autocomplete="username"
                                    class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-slate-50/60 hover:bg-slate-100/80 focus:bg-white text-slate-800 text-sm font-medium ring-1 ring-slate-200 focus:ring-2 focus:ring-purple-500 outline-none transition-all shadow-inner" />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>
                    </div>

                    <!-- FILA 2 -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- TELÉFONO -->
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase ml-1">Teléfono</label>
                            <div class="relative group">
                                <span
                                    class="absolute inset-y-0 left-4 flex items-center pointer-events-none material-icons text-slate-400 group-focus-within:text-emerald-600 transition-colors">phone</span>
                                <input type="tel" name="phone" placeholder="0999999999"
                                    value="{{ old('phone', $role === 'admin' ? $user->admin->phone ?? '' : ($role === 'entrepreneur' ? $user->entrepreneur->phone ?? '' : '')) }}"
                                    class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-slate-50/60 hover:bg-slate-100/80 focus:bg-white text-slate-800 text-sm font-medium ring-1 ring-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none transition-all shadow-inner" />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                        </div>

                        <!-- GÉNERO (Solo para Emprendedor) -->
                        @if ($role === 'entrepreneur')
                            @php
                                $currentGender = old('gender', $user->entrepreneur->gender ?? '');
                            @endphp
                            <div class="space-y-2" x-data="{ open: false, value: '{{ $currentGender }}', label: '{{ $currentGender ?: 'Seleccione una opción' }}' }">
                                <label class="block text-xs font-bold text-slate-500 uppercase ml-1">Género</label>

                                <!-- Campo visual -->
                                <button type="button" @click="open = !open" @keydown.escape.window="open=false"
                                    class="w-full text-left relative group rounded-2xl bg-slate-50/60 hover:bg-slate-100/80 focus:bg-white ring-1 ring-slate-200 focus:ring-2 focus:ring-pink-500 outline-none transition-all shadow-inner pl-11 pr-10 py-3.5 text-sm font-medium text-slate-800">
                                    <!-- Icono -->
                                    <span
                                        class="absolute inset-y-0 left-4 flex items-center pointer-events-none material-icons text-slate-400 group-focus-within:text-pink-600 transition-colors">wc</span>

                                    <span x-text="label" class="block truncate text-slate-700"></span>

                                    <!-- Flecha -->
                                    <span
                                        class="absolute inset-y-0 right-4 flex items-center pointer-events-none material-icons text-slate-400 transition-transform"
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
                            <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                        @endif
                    </div>

                    <!-- DESCRIPCIÓN -->
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase ml-1">Descripción</label>
                        <div class="relative group">
                            <span
                                class="absolute top-4 left-4 pointer-events-none material-icons text-slate-400 group-focus-within:text-blue-600 transition-colors">description</span>
                            <textarea name="description" rows="4" placeholder="Cuéntanos un poco sobre ti..."
                                class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-slate-50/60 hover:bg-slate-100/80 focus:bg-white text-slate-800 text-sm font-medium ring-1 ring-slate-200 focus:ring-2 focus:ring-blue-500 outline-none transition-all shadow-inner resize-none">{{ old('description', $role === 'admin' ? $user->admin->description ?? '' : ($role === 'entrepreneur' ? $user->entrepreneur->description ?? '' : '')) }}</textarea>
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    <!-- SEPARADOR -->
                    <div class="my-10 border-t border-slate-200/60 relative">
                         <span class="absolute left-1/2 -translate-x-1/2 -top-3 bg-white px-4 text-slate-400 text-xs font-bold tracking-widest uppercase">
                             Seguridad
                         </span>
                    </div>

                    <!-- SECTION PASSWORD HEADER -->
                    <div class="text-center mb-8">
                        <div class="mx-auto mb-6 w-16 h-16 rounded-[1.5rem] bg-gradient-to-tr from-orange-500 to-amber-400 text-white flex items-center justify-center shadow-lg ring-4 ring-white/50">
                            <span class="material-icons text-3xl">lock</span>
                        </div>
                        <h2 class="text-xl sm:text-2xl font-black text-slate-800 mb-1">Cambiar Contraseña</h2>
                        <p class="text-slate-500 text-sm">Actualiza tu contraseña para mantener tu cuenta segura (opcional).</p>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        <!-- ACTUAL CONTRASEÑA -->
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase ml-1">{{ __('Current Password') }}</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-4 flex items-center pointer-events-none material-icons text-slate-400 group-focus-within:text-amber-500 transition-colors">vpn_key</span>
                                <input id="current_password" name="current_password" type="password"
                                       autocomplete="current-password"
                                       class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-slate-50/60 border border-slate-200 focus:bg-white text-slate-800 text-sm font-medium focus:ring-2 focus:ring-amber-500 outline-none transition-all" />
                            </div>
                            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                        </div>

                        <!-- NUEVA CONTRASEÑA -->
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase ml-1">{{ __('New Password') }}</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-4 flex items-center pointer-events-none material-icons text-slate-400 group-focus-within:text-amber-500 transition-colors">lock</span>
                                <input id="password" name="password" type="password"
                                       autocomplete="new-password"
                                       class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-slate-50/60 border border-slate-200 focus:bg-white text-slate-800 text-sm font-medium focus:ring-2 focus:ring-amber-500 outline-none transition-all" />
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- CONFIRMAR CONTRASEÑA -->
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase ml-1">{{ __('Confirm Password') }}</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-4 flex items-center pointer-events-none material-icons text-slate-400 group-focus-within:text-amber-500 transition-colors">lock_reset</span>
                                <input id="password_confirmation" name="password_confirmation"
                                       type="password" autocomplete="new-password"
                                       class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-slate-50/60 border border-slate-200 focus:bg-white text-slate-800 text-sm font-medium focus:ring-2 focus:ring-amber-500 outline-none transition-all" />
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>

                    <!-- BOTÓN ACTUALIZAR PERFIL -->
                    <div class="pt-4">
                        <button type="button" onclick="confirmProfileUpdate()"
                            class="w-full relative overflow-hidden group/btn px-4 py-4 rounded-2xl bg-slate-900 text-white text-sm font-extrabold tracking-wide hover:shadow-2xl hover:shadow-indigo-500/40 hover:-translate-y-1 transition-all duration-300">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300">
                            </div>
                            <span class="relative flex items-center justify-center gap-2">
                                ACTUALIZAR PERFIL
                                <span
                                    class="material-icons text-lg group-hover/btn:translate-x-1 transition-transform">save</span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
            <!-- Fin Contenido Merged -->
        </div>

        <!-- CARD 3: ELIMINAR CUENTA -->
        <div
            class="rounded-[2.5rem] overflow-hidden bg-white/90 backdrop-blur-xl border border-white/50 shadow-[0_25px_50px_-12px_rgba(0,0,0,0.15)]">
            <div class="w-full h-2 md:h-2.5 bg-gradient-to-r from-red-500 to-rose-600"></div>
            <div class="p-6 sm:p-8 md:p-12">
                <div class="flex items-start md:items-center justify-between gap-4 flex-col md:flex-row mb-6">
                    <div>
                        <h2 class="text-xl font-black text-slate-800 mb-1 flex items-center gap-2">
                            <span class="material-icons text-red-500">warning</span>
                            Eliminar Cuenta
                        </h2>
                        <p class="text-slate-500 text-sm">
                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
                        </p>
                    </div>

                    <button type="button" onclick="confirmAccountDeletion()"
                        class="px-5 py-3 rounded-2xl bg-red-50 text-red-600 font-bold text-sm border border-red-100 hover:bg-red-100 transition-colors">
                        {{ __('Delete Account') }}
                    </button>
                </div>

                <!-- Formulario oculto para eliminar cuenta -->
                <form id="deleteAccountForm" method="post" action="{{ route('profile.destroy') }}" style="display: none;">
                    @csrf
                    @method('delete')
                    <input type="hidden" id="deletePassword" name="password" />
                </form>
            </div>
        </div>
    </div>
@endsection

<script>
    // Confirmación antes de actualizar perfil
    function confirmProfileUpdate() {
        Swal.fire({
            title: '¿Seguro que quieres actualizar?',
            text: "Se actualizará tu información de perfil y contraseña (si la proporcionaste)",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('profileForm').submit();
            }
        });
    }

    // Confirmación antes de eliminar cuenta
    function confirmAccountDeletion() {
        @if($role === 'entrepreneur')
            // Mensaje específico para emprendedores
            Swal.fire({
                title: '¿Eliminar tu cuenta?',
                text: 'Perderás todos tus emprendimientos',
                icon: 'warning',
                input: 'password',
                inputPlaceholder: 'Ingresa tu contraseña para confirmar',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminar cuenta',
                cancelButtonText: 'Cancelar',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Debes ingresar tu contraseña';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Enviar el formulario y mostrar alerta de éxito
                    submitDeleteForm(result.value);
                }
            });
        @else
            // Mensaje estándar para admin u otros roles
            Swal.fire({
                title: '¿Seguro que quieres eliminar tu cuenta?',
                html: `
                    <p class="text-slate-600 mb-4">Esta acción es permanente y no se puede deshacer.</p>
                    <input type="password" id="swal-password-input" class="swal2-input" placeholder="Ingresa tu contraseña">
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminar cuenta',
                cancelButtonText: 'Cancelar',
                preConfirm: () => {
                    const password = document.getElementById('swal-password-input').value;
                    if (!password) {
                        Swal.showValidationMessage('Debes ingresar tu contraseña');
                        return false;
                    }
                    return password;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    submitDeleteForm(result.value);
                }
            });
        @endif
    }

    // Función para enviar el formulario de eliminación
    function submitDeleteForm(password) {
        // Preparar el formulario
        const form = document.getElementById('deleteAccountForm');
        document.getElementById('deletePassword').value = password;
        
        // Crear FormData para enviar por AJAX
        const formData = new FormData(form);
        
        // Enviar por AJAX
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                // Mostrar alerta de éxito
                Swal.fire({
                    icon: 'success',
                    title: '¡Cuenta eliminada!',
                    text: 'Tu cuenta ha sido eliminada correctamente.',
                    confirmButtonColor: '#4f46e5',
                    timer: 3000,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(() => {
                    // Redirigir al inicio después de mostrar la alerta
                    window.location.href = '/';
                });
            } else {
                // Error en la eliminación
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al eliminar la cuenta. Verifica tu contraseña.',
                    confirmButtonColor: '#dc2626'
                });
            }
        })
        .catch(error => {
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema de conexión. Inténtalo de nuevo.',
                confirmButtonColor: '#dc2626'
            });
        });
    }
</script>