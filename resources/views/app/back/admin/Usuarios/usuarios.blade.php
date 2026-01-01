@extends('layouts.template-back')

@section('titulo', 'Gestión de Usuarios')

@section('enlaces_css')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/usuarios.css') }}">
@endsection

@section('contenido-principal')
    <!-- Encabezado -->
    <div class="users-header">
        <h2 class="users-title">
            Gestión de <span class="typing">Usuarios</span>
        </h2>

        <p class="users-subtitle">
            Permite cambiar el estado de las cuentas de usuario y eliminar registros cuando sea necesario.
        </p>

        <div class="users-divider"></div>
    </div>

    {{-- Contenido Principal --}}
    <!-- CARD -->
    <div
        class="relative w-full bg-white rounded-3xl border border-slate-200
           shadow-md transition-all duration-300
           hover:shadow-[0_0_28px_rgba(139,92,246,0.45)]
           overflow-hidden">

        <!-- BARRA SUPERIOR -->
        <div class="w-full h-1.5 bg-gradient-to-r
                from-indigo-500 via-purple-500 to-pink-500">
        </div>

        <!-- CONTENIDO -->
        <div class="px-4 md:px-6 py-5">

            <!-- TABLA RESPONSIVE -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse has-glass-effect">
                    <!-- HEADER -->
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-wider">Usuario
                            </th>
                            <th
                                class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-wider hidden md:table-cell">
                                Email
                            </th>
                            <th class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-wider">Rol
                            </th>
                            <th class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-wider text-center">
                                Emprendimientos
                            </th>
                            <th class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-wider">Estado
                            </th>
                            <th
                                class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-wider text-center">
                                Acciones</th>
                        </tr>
                    </thead>

                    <!-- BODY -->
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($users as $user)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="relative">
                                            <div
                                                class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-lg shadow-sm
                                                {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-600' : 'bg-indigo-100 text-indigo-600' }}">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <!-- Indicator dot -->
                                            <div
                                                class="absolute -bottom-1 -right-1 w-3.5 h-3.5 border-2 border-white rounded-full {{ $user->status === 'active' || ($user->admin && $user->admin->status === 'active') || ($user->entrepreneur && $user->entrepreneur->status === 'active') ? 'bg-emerald-500' : 'bg-slate-300' }}">
                                            </div>
                                        </div>
                                        <div class="leading-tight">
                                            <p class="font-bold text-slate-800 text-sm">
                                                {{ $user->name }}
                                            </p>
                                            <p class="text-xs text-slate-400 font-medium">
                                                Registrado el
                                                {{ optional($user->created_at)->format('d/m/Y') ?? 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 hidden md:table-cell">
                                    <div class="text-slate-600 font-medium text-xs">
                                        {{ $user->email }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    @if ($user->role === 'admin')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-700">
                                            Administrador
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-700">
                                            Emprendedor
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @if($user->role === 'entrepreneur' && $user->entrepreneur)
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 text-slate-700 font-bold text-xs ring-2 ring-white shadow-sm">
                                            {{ $user->entrepreneur->ventures->count() }}
                                        </span>
                                    @else
                                        <span class="text-slate-300">-</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    @php
                                        $status = 'inactive'; // Default
                                        if ($user->role === 'admin' && $user->admin) {
                                            $status = $user->admin->status;
                                        } elseif ($user->role === 'entrepreneur' && $user->entrepreneur) {
                                            $status = $user->entrepreneur->status;
                                        }
                                    @endphp

                                    @if ($status === 'active')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                            Activo
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                            Inactivo
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button
                                            onclick="openEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $status }}')"
                                            class="text-indigo-600 hover:text-indigo-700 bg-slate-100 hover:bg-violet-100 p-2 rounded-lg transition"
                                            title="Cambiar Estado">
                                            <span class="material-icons text-base">sync</span>
                                        </button>

                                        <form id="delete-form-{{ $user->id }}"
                                            action="{{ route('admin.usuarios.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete({{ $user->id }})"
                                                class="text-red-600 hover:text-red-700 bg-slate-100 hover:bg-red-100 p-2 rounded-lg transition"
                                                title="Eliminar">
                                                <span class="material-icons text-base">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        {{-- Paginación --}}
        @if ($users->hasPages())
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                <div class="flex justify-center gap-2">

                    @if ($users->onFirstPage())
                        <span class="px-4 py-2 text-sm font-bold text-slate-400 bg-slate-100 rounded-lg cursor-not-allowed">
                            ← Anterior
                        </span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}"
                            class="px-4 py-2 text-sm font-bold text-violet-600 bg-white border border-violet-200 rounded-lg hover:bg-violet-50 transition">
                            ← Anterior
                        </a>
                    @endif

                    @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                        @if ($page == $users->currentPage())
                            <span class="px-4 py-2 text-sm font-extrabold text-white bg-violet-600 rounded-lg shadow">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                                class="px-4 py-2 text-sm font-bold text-violet-600 bg-white border border-violet-200 rounded-lg hover:bg-violet-50 transition">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    @if ($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}"
                            class="px-4 py-2 text-sm font-bold text-violet-600 bg-white border border-violet-200 rounded-lg hover:bg-violet-50 transition">
                            Siguiente →
                        </a>
                    @else
                        <span class="px-4 py-2 text-sm font-bold text-slate-400 bg-slate-100 rounded-lg cursor-not-allowed">
                            Siguiente →
                        </span>
                    @endif

                </div>
            </div>
        @endif
    </div>
    </div>


    {{-- Modal de Edición de Estado --}}
    <div id="editStatusModal"
        class="fixed inset-0 bg-slate-900/50 hidden items-center justify-center z-50 backdrop-blur-sm opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md mx-4 transform scale-95 transition-transform duration-300"
            id="editStatusModalContent">

            {{-- Header --}}
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-xl font-bold text-slate-800" id="modalTitle">Editar Estado</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition">
                    <span class="material-icons">close</span>
                </button>
            </div>

            {{-- Formulario --}}
            <form id="editStatusForm" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Estado del Usuario</label>
                    <div class="relative">
                        <!-- Hidden Input -->
                        <input type="hidden" name="status" id="statusInput">

                        <!-- Custom Trigger Button -->
                        <button type="button" id="statusDropdownBtn" onclick="toggleStatusDropdown()"
                            class="w-full flex items-center justify-between bg-slate-50 border-2 border-slate-200 text-slate-700 py-4 px-5 rounded-xl transition-all duration-300 hover:border-violet-300 hover:bg-white focus:ring-4 focus:ring-violet-500/10 focus:border-violet-500 group">
                            <span class="flex items-center gap-3">
                                <span id="statusIcon" class="w-3 h-3 rounded-full bg-slate-400 transition-colors"></span>
                                <span id="statusText" class="font-bold text-lg">Seleccionar Estado</span>
                            </span>
                            <span
                                class="material-icons text-slate-400 group-hover:text-violet-500 transition-colors">expand_circle_down</span>
                        </button>

                        <!-- Custom Options Menu -->
                        <div id="statusDropdownOptions"
                            class="relative mt-4 bg-white rounded-2xl shadow-xl border border-slate-100 hidden overflow-hidden transform transition-all duration-200 origin-top scale-95 opacity-0">

                            <div onclick="selectStatus('active')"
                                class="flex items-center gap-3 px-5 py-4 cursor-pointer hover:bg-violet-50 transition-colors group border-b border-slate-50 last:border-0">
                                <span
                                    class="w-3 h-3 rounded-full bg-emerald-500 shadow-sm group-hover:shadow-emerald-500/50"></span>
                                <div class="flex flex-col">
                                    <span
                                        class="font-bold text-slate-700 group-hover:text-violet-700 transition-colors">Activo</span>
                                    <span class="text-xs text-slate-400 font-medium">El usuario puede acceder al
                                        sistema</span>
                                </div>
                                <span
                                    class="material-icons text-violet-600 ml-auto opacity-0 group-hover:opacity-100 transition-opacity">check</span>
                            </div>

                            <div onclick="selectStatus('inactive')"
                                class="flex items-center gap-3 px-5 py-4 cursor-pointer hover:bg-violet-50 transition-colors group">
                                <span
                                    class="w-3 h-3 rounded-full bg-red-400 shadow-sm group-hover:shadow-red-400/50"></span>
                                <div class="flex flex-col">
                                    <span
                                        class="font-bold text-slate-700 group-hover:text-violet-700 transition-colors">Inactivo</span>
                                    <span class="text-xs text-slate-400 font-medium">El usuario no tendrá acceso</span>
                                </div>
                                <span
                                    class="material-icons text-violet-600 ml-auto opacity-0 group-hover:opacity-100 transition-opacity">check</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 justify-end pt-2">
                    <button type="button" onclick="closeModal()"
                        class="px-5 py-2.5 rounded-xl text-slate-600 font-bold hover:bg-slate-50 transition border border-transparent">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-violet-600 text-white font-bold hover:bg-violet-700 shadow-lg shadow-violet-500/30 transition transform hover:-translate-y-0.5">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Custom Dropdown Logic
        function toggleStatusDropdown() {
            const dropdown = document.getElementById('statusDropdownOptions');
            const btn = document.getElementById('statusDropdownBtn');

            if (dropdown.classList.contains('hidden')) {
                // Open
                dropdown.classList.remove('hidden');
                setTimeout(() => {
                    dropdown.classList.remove('scale-95', 'opacity-0');
                    dropdown.classList.add('scale-100', 'opacity-100');
                }, 10);
                btn.classList.add('border-violet-500', 'ring-4', 'ring-violet-500/10');
            } else {
                // Close
                dropdown.classList.remove('scale-100', 'opacity-100');
                dropdown.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    dropdown.classList.add('hidden');
                }, 200);
                btn.classList.remove('border-violet-500', 'ring-4', 'ring-violet-500/10');
            }
        }

        function selectStatus(status) {
            const input = document.getElementById('statusInput');
            const text = document.getElementById('statusText');
            const icon = document.getElementById('statusIcon');

            input.value = status;

            if (status === 'active') {
                text.textContent = 'Activo';
                icon.className = 'w-3 h-3 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/50';
            } else {
                text.textContent = 'Inactivo';
                icon.className = 'w-3 h-3 rounded-full bg-red-400 shadow-sm shadow-red-400/50';
            }

            toggleStatusDropdown();
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('statusDropdownOptions');
            const btn = document.getElementById('statusDropdownBtn');

            if (!btn.contains(e.target) && !dropdown.contains(e.target) && !dropdown.classList.contains('hidden')) {
                toggleStatusDropdown();
            }
        });

        function openEditModal(userId, userName, currentStatus) {
            const modal = document.getElementById('editStatusModal');
            const modalContent = document.getElementById('editStatusModalContent');
            const form = document.getElementById('editStatusForm');
            const title = document.getElementById('modalTitle');

            // Configurar acción del formulario
            form.action = `/admin/usuarios/${userId}`;

            // Configurar título
            title.textContent = `Editar Estado: ${userName}`;

            // Configurar estado en el custom dropdown
            selectStatus(currentStatus);

            // Mostrar modal con animación
            modal.classList.remove('hidden');
            modal.classList.add('flex'); // Add Flex here
            // Timeout para permitir que el navegador renderice el 'block' antes de añadir opacidad
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);
        }

        function closeModal() {
            const modal = document.getElementById('editStatusModal');
            const modalContent = document.getElementById('editStatusModalContent');

            modal.classList.add('opacity-0');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex'); // Remove flex here
            }, 300);
        }

        // Cerrar al hacer clic fuera
        document.getElementById('editStatusModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        function confirmDelete(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminarlo',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        @endif
    </script>
@endsection
