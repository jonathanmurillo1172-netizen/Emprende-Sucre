@extends('layouts.template-back')
{{-- Titulo de la pagina --}}
@section('titulo', 'Validar Emprendimientos')
{{-- enlaces css --}}
@section('enlaces_css')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/emprendimientos-apr.css') }}">
@endsection
{{-- contenido principal --}}
@section('contenido-principal')
    <div class="max-w-7xl mx-auto px-4 py-8">

        <!-- HEADER -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">

            <!-- TEXTO -->
            <div class="categories-header">
                <h1 class="categories-title">
                    Emprendimientos
                    <span class="typing-cat">Aprobados</span>
                </h1>

                <p class="categories-subtitle">
                    Gestiona el catálogo de emprendimientos activos en la plataforma.
                </p>
            </div>

            <!-- CONTADOR -->
            <div
                class="flex items-center gap-3 bg-white/80 backdrop-blur-xl px-4 py-2 rounded-2xl
               shadow-sm border border-slate-200">

                <span class="relative flex h-3 w-3">
                    <span
                        class="absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75 animate-ping"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                </span>

                <span class="text-sm font-bold text-slate-600">
                    {{ $ventures->total() }} Emprendimientos Aprobados
                </span>
            </div>

        </div>


        @if ($ventures->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($ventures as $venture)
                    <div
                        class="group relative bg-white rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 border border-slate-200 flex flex-col h-full">

                        <!-- IMAGEN CON EFECTO -->
                        <div class="relative h-52 overflow-hidden bg-slate-900 shrink-0">
                            <!-- Imagen -->
                            <img src="{{ asset('storage/' . $venture->image) }}"
                                class="w-full h-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700"
                                alt="{{ $venture->title }}">

                            <!-- Gradiente overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent">
                            </div>

                            <!-- CATEGORÍA (top left) -->
                            <div class="absolute top-4 left-4">
                                <div
                                    class="flex items-center gap-2 px-3 py-2 rounded-xl bg-white/95 backdrop-blur-sm shadow-lg">
                                    <span class="material-icons text-indigo-600 text-lg">category</span>
                                    <span
                                        class="text-sm font-bold text-slate-800">{{ $venture->category->name ?? 'Sin categoría' }}</span>
                                </div>
                            </div>

                            <!-- STATUS (top right) -->
                            <div class="absolute top-4 right-4">
                                @if ($venture->status == 'active')
                                    <div
                                        class="flex items-center gap-1.5 px-3 py-2 rounded-xl bg-emerald-500 shadow-lg shadow-emerald-500/50">
                                        <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                                        <span class="text-xs font-bold text-white">Activo</span>
                                    </div>
                                @elseif($venture->status == 'disabled')
                                    <div class="flex items-center gap-1.5 px-3 py-2 rounded-xl bg-amber-500 shadow-lg shadow-amber-500/30">
                                        <span class="material-icons text-white text-xs">visibility_off</span>
                                        <span class="text-xs font-bold text-white">Desactivado</span>
                                    </div>
                                @else
                                    <div class="px-3 py-2 rounded-xl bg-slate-700 shadow-lg">
                                        <span class="text-xs font-bold text-white uppercase">{{ $venture->status }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- TÍTULO Y UBICACIÓN -->
                            <div
                                class="absolute bottom-0 left-0 right-0 p-5 bg-gradient-to-t from-slate-900 to-transparent">
                                <h3
                                    class="text-xl font-black text-white mb-2 leading-tight group-hover:text-indigo-400 transition-colors">
                                    {{ $venture->title }}
                                </h3>
                                <div class="flex items-center gap-1.5 text-white/80">
                                    <span class="material-icons text-sm">place</span>
                                    <span class="text-xs font-medium">{{ Str::limit($venture->location, 40) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- CONTENIDO MODERNO -->
                        <div class="p-6 bg-gradient-to-br from-slate-50 via-white to-slate-50 flex flex-col flex-1">

                            <!-- INFO EXTRA EMPRENDEDOR -->
                            <div class="flex items-center gap-2 mb-4 text-xs font-semibold text-slate-500">
                                <div class="flex items-center gap-1 bg-slate-100 px-2 py-1 rounded-lg">
                                    <span class="material-icons text-sm text-indigo-400">person</span>
                                    <span class="truncate max-w-[80px]" title="{{ $venture->entrepreneur->user->name ?? 'Emprendedor' }}">
                                        {{ $venture->entrepreneur->user->name ?? 'Emprendedor' }}
                                    </span>
                                    <span class="px-1.5 py-0.5 rounded-md text-[9px] font-bold uppercase transition-colors {{ ($venture->entrepreneur->status ?? '') === 'active' ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }}">
                                        {{ ($venture->entrepreneur->status ?? '') === 'active' ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-1 bg-slate-100 px-2 py-1 rounded-lg">
                                    <span class="material-icons text-sm text-fuchsia-400">calendar_today</span>
                                    <span>{{ $venture->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>

                            <!-- Descripción -->
                            <p class="text-slate-600 text-sm leading-relaxed mb-6 line-clamp-2 h-10">
                                {{ $venture->description }}
                            </p>

                            <!-- INFO PRODUCTOS -->
                            <a href="{{ route('admin.emprendimientos.productos', $venture->id) }}"
                                class="block mb-6 group/products" title="Ver productos">
                                <div
                                    class="relative overflow-hidden p-4 rounded-2xl bg-gradient-to-br from-indigo-500 to-fuchsia-600 shadow-lg transition-all">
                                    <!-- Patrón decorativo -->
                                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-12 -mt-12">
                                    </div>
                                    <div class="absolute bottom-0 left-0 w-20 h-20 bg-black/10 rounded-full -ml-10 -mb-10">
                                    </div>

                                    <div class="relative flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                                <span class="material-icons text-white text-2xl">inventory_2</span>
                                            </div>
                                            <div>
                                                <p class="text-white/80 text-xs font-semibold uppercase tracking-wide">
                                                    Productos</p>
                                                <p class="text-white text-2xl font-black">{{ $venture->products_count }}
                                                </p>
                                            </div>
                                        </div>
                                        <div
                                            class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center group-hover/products:bg-white group-hover/products:scale-110 transition-all">
                                            <span
                                                class="material-icons text-white group-hover/products:text-indigo-600">arrow_forward</span>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <!-- BOTONES ACCIÓN ADMIN -->
                            <div class="flex flex-col gap-3 mt-auto">
                                <div class="grid grid-cols-1 gap-3">
                                    <!-- TOGGLE STATUS -->
                                    <button onclick="toggleVentureStatus('{{ $venture->id }}', '{{ $venture->status }}')"
                                        id="status-btn-{{ $venture->id }}"
                                        class="w-full py-3 px-4 rounded-xl transition-all flex items-center justify-center gap-2 group/btn
                                        {{ $venture->status === 'active' 
                                            ? 'bg-gradient-to-r from-amber-50 to-orange-50 hover:from-amber-500 hover:to-orange-600 border border-amber-200 hover:border-amber-500' 
                                            : 'bg-gradient-to-r from-emerald-50 to-green-50 hover:from-emerald-500 hover:to-green-600 border border-emerald-200 hover:border-emerald-500' }}">
                                        <span class="material-icons text-lg {{ $venture->status === 'active' ? 'text-amber-600' : 'text-emerald-600' }} group-hover/btn:text-white transition-colors">
                                            {{ $venture->status === 'active' ? 'pause_circle' : 'play_circle' }}
                                        </span>
                                        <span class="text-sm font-bold {{ $venture->status === 'active' ? 'text-amber-700' : 'text-emerald-700' }} group-hover/btn:text-white transition-colors">
                                            {{ $venture->status === 'active' ? 'Desactivar para público' : 'Activar para público' }}
                                        </span>
                                    </button>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <!-- Botón Ver -->
                                    <button
                                        onclick="openVentureModal('{{ $venture->id }}', '{{ $venture->title }}', '{{ asset('storage/' . $venture->image) }}', '{{ Str::limit($venture->description, 200) }}', '{{ $venture->category->name ?? 'Sin categoría' }}', '{{ $venture->location }}')"
                                        class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-blue-50 to-indigo-50 hover:from-blue-500 hover:to-indigo-600 border border-blue-200 hover:border-blue-500 transition-all flex items-center justify-center gap-2 group/btn">
                                        <span
                                            class="material-icons text-lg text-blue-600 group-hover/btn:text-white transition-colors">visibility</span>
                                        <span
                                            class="text-sm font-bold text-blue-700 group-hover/btn:text-white transition-colors">Ver</span>
                                    </button>

                                    <!-- ELIMINAR -->
                                    <button onclick="confirmDeleteVenture('{{ $venture->id }}')"
                                        class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-red-50 to-rose-50 hover:from-red-500 hover:to-rose-600 border border-red-200 hover:border-red-500 transition-all flex items-center justify-center gap-2 group/btn">
                                        <span
                                            class="material-icons text-lg text-red-600 group-hover/btn:text-white transition-colors">delete</span>
                                        <span
                                            class="text-sm font-bold text-red-700 group-hover/btn:text-white transition-colors">Eliminar</span>
                                    </button>

                                    <form id="delete-form-{{ $venture->id }}"
                                        action="{{ route('admin.emprendimientos.destroy', $venture->id) }}" method="POST"
                                        class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $ventures->links() }}
            </div>
        @else
            <!-- EMPTY STATE -->
            <div class="text-center py-20 bg-white rounded-3xl border border-slate-200 border-dashed">
                <div class="w-20 h-20 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-icons text-indigo-300 text-5xl">inventory_2</span>
                </div>
                <h3 class="text-xl font-bold text-slate-800">No hay emprendimientos aprobados</h3>
                <p class="text-slate-500 mt-2 mb-8 max-w-md mx-auto">
                    Actualmente no hay emprendimientos activos en el sistema.
                </p>
            </div>
        @endif

    </div>

    <!-- Script Modal -->
    <!-- Script Modal -->
    <script>
        function openVentureModal(id, title, image, description, category, location) {
            Swal.fire({
                title: `<span class="text-lg font-black text-slate-800">${title}</span>`,
                imageUrl: image,
                imageHeight: 160,
                imageAlt: title,
                width: '420px',
                padding: '1.25rem',
                customClass: {
                    image: 'object-cover rounded-xl shadow-sm mb-4',
                    popup: 'rounded-2xl'
                },
                html: `
                    <div class="text-left">
                        <div class="flex items-center justify-between mb-4 px-1">
                            <span class="px-3 py-1 rounded-full bg-violet-100 text-violet-700 text-xs font-bold uppercase tracking-wide">
                                ${category}
                            </span>
                            <div class="flex items-center gap-1 text-slate-400">
                                <span class="material-icons text-sm">place</span>
                                <span class="text-xs font-medium truncate max-w-[120px]" title="${location}">${location}</span>
                            </div>
                        </div>
                        
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <p class="text-slate-600 text-xs leading-relaxed text-justify max-h-40 overflow-y-auto pr-2">
                                ${description}
                            </p>
                        </div>
                    </div>
                `,
                showCloseButton: true,
                focusConfirm: false,
                confirmButtonText: 'Cerrar',
                confirmButtonColor: '#334155'
            });
        }

        function confirmDeleteVenture(id) {
            Swal.fire({
                title: '¿Eliminar Emprendimiento?',
                text: "Esta acción eliminará el emprendimiento y todos sus productos permanentemente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                customClass: {
                    popup: 'rounded-2xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
        function toggleVentureStatus(id, currentStatus) {
            const action = currentStatus === 'active' ? 'desactivar' : 'activar';
            const confirmColor = currentStatus === 'active' ? '#f59e0b' : '#10b981';

            Swal.fire({
                title: `¿${action.charAt(0).toUpperCase() + action.slice(1)} Emprendimiento?`,
                text: `El emprendimiento pasará a estar ${currentStatus === 'active' ? 'oculto' : 'visible'} en el catálogo público.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: confirmColor,
                cancelButtonColor: '#6b7280',
                confirmButtonText: `Sí, ${action}`,
                cancelButtonText: 'Cancelar',
                customClass: {
                    popup: 'rounded-2xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`{{ url('/admin/emprendimientos') }}/${id}/toggle-status`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: '¡Actualizado!',
                                text: data.message,
                                icon: 'success',
                                customClass: { popup: 'rounded-2xl' }
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'Hubo un problema al procesar la solicitud', 'error');
                    });
                }
            })
        }
    </script>
@endsection
