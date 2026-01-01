@extends('layouts.template-dash-empr')

@section('contenido-principal')
    <div class="max-w-7xl mx-auto px-4 py-8">
        
        <!-- HEADER -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">Mis Emprendimientos</h1>
                <p class="text-slate-500 mt-2 text-lg">Administra tus negocios y sus productos.</p>
            </div>
            
            <a href="{{ route('entrepreneur.emprendimientos.create') }}" 
               class="px-6 py-3 rounded-xl bg-gradient-to-r from-sky-500 to-indigo-600 text-white font-bold hover:opacity-90 shadow-lg shadow-sky-500/30 transition-all flex items-center gap-2 transform hover:-translate-y-0.5">
                <span class="material-icons">add_business</span>
                Nuevo Emprendimiento
            </a>
        </div>

        @if($ventures->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($ventures as $venture)
                    <div class="group relative bg-white rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 border border-slate-200 flex flex-col h-full">
                        
                        <!-- IMAGEN CON EFECTO -->
                        <div class="relative h-52 overflow-hidden bg-slate-900">
                            <img src="{{ asset('storage/' . $venture->image) }}" 
                                 class="w-full h-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700"
                                 alt="{{ $venture->title }}">
                            
                            <!-- Gradiente overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
                            
                            <!-- CATEGORÍA (top left) -->
                            <div class="absolute top-4 left-4">
                                <div class="flex items-center gap-2 px-3 py-2 rounded-xl bg-white/95 backdrop-blur-sm shadow-lg">
                                    <span class="material-icons text-violet-600 text-lg">category</span>
                                    <span class="text-sm font-bold text-slate-800">{{ $venture->category->name ?? 'Sin categoría' }}</span>
                                </div>
                            </div>

                            <!-- STATUS (top right) -->
                            <div class="absolute top-4 right-4">
                                @if($venture->status == 'active')
                                    <div class="flex items-center gap-1.5 px-3 py-2 rounded-xl bg-sky-600 shadow-lg shadow-sky-600/50">
                                        <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                                        <span class="text-xs font-bold text-white">Activo</span>
                                    </div>
                                @elseif($venture->status == 'disabled')
                                    <div class="flex items-center gap-1.5 px-3 py-2 rounded-xl bg-red-500 shadow-lg shadow-red-500/50">
                                        <span class="material-icons text-white text-xs">block</span>
                                        <span class="text-xs font-bold text-white">Desactivado por Admin</span>
                                    </div>
                                @elseif(Str::startsWith($venture->title, '[RECHAZADO] '))
                                    <div class="flex items-center gap-1.5 px-3 py-2 rounded-xl bg-red-500 shadow-lg shadow-red-500/50">
                                        <span class="material-icons text-white text-xs">error</span>
                                        <span class="text-xs font-bold text-white">Rechazado</span>
                                    </div>
                                @else
                                    <div class="flex items-center gap-1.5 px-3 py-2 rounded-xl bg-amber-400 shadow-lg shadow-amber-400/50">
                                        <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                                        <span class="text-xs font-bold text-white">En Revisión</span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- TÍTULO Y UBICACIÓN -->
                            <div class="absolute bottom-0 left-0 right-0 p-5 bg-gradient-to-t from-slate-900 to-transparent">
                                <h3 class="text-xl font-black text-white mb-2 leading-tight group-hover:text-sky-400 transition-colors">
                                    {{ str_replace('[RECHAZADO] ', '', $venture->title) }}
                                </h3>
                                <div class="flex items-center gap-1.5 text-white/80">
                                    <span class="material-icons text-sm">place</span>
                                    <span class="text-xs font-medium">{{ Str::limit($venture->location, 40) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- CONTENIDO MODERNO -->
                        <div class="p-6 bg-gradient-to-br from-slate-50 via-white to-slate-50 flex-1 flex flex-col">
                            
                            <!-- Descripción -->
                            <p class="text-slate-600 text-sm leading-relaxed mb-6 h-10 line-clamp-2">
                                {{ $venture->description }}
                            </p>

                            <!-- PRODUCTOS - Diseño moderno con card -->
                            <a href="{{ route('entrepreneur.emprendimientos.productos.index', $venture->id) }}" 
                               class="block mb-6 group/products"
                               title="Ver productos de este emprendimiento">
                                <div class="relative overflow-hidden p-4 rounded-2xl bg-gradient-to-br from-sky-500 to-indigo-600 shadow-lg hover:shadow-xl hover:shadow-sky-500/30 transition-all">
                                    <!-- Patrón decorativo -->
                                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-12 -mt-12"></div>
                                    <div class="absolute bottom-0 left-0 w-20 h-20 bg-black/10 rounded-full -ml-10 -mb-10"></div>
                                    
                                    <div class="relative flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                                <span class="material-icons text-white text-2xl">inventory_2</span>
                                            </div>
                                            <div>
                                                <p class="text-white/80 text-xs font-semibold uppercase tracking-wide">Productos</p>
                                                <p class="text-white text-2xl font-black">{{ $venture->products_count }}</p>
                                            </div>
                                        </div>
                                        <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center group-hover/products:bg-white group-hover/products:scale-110 transition-all">
                                            <span class="material-icons text-white group-hover/products:text-sky-600">arrow_forward</span>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <!-- BOTONES MODERNOS -->
                            <div class="grid grid-cols-2 gap-3">
                                <a href="{{ route('entrepreneur.emprendimientos.edit', $venture->id) }}"
                                   class="group/btn py-3 px-4 rounded-xl bg-gradient-to-r from-blue-50 to-indigo-50 hover:from-blue-500 hover:to-indigo-600 border border-blue-200 hover:border-blue-500 transition-all flex items-center justify-center gap-2">
                                    <span class="material-icons text-lg text-blue-600 group-hover/btn:text-white transition-colors">edit</span>
                                    <span class="text-sm font-bold text-blue-700 group-hover/btn:text-white transition-colors">
                                        {{ Str::startsWith($venture->title, '[RECHAZADO] ') ? 'Corregir' : 'Editar' }}
                                    </span>
                                </a>

                                <button onclick="deleteVenture({{ $venture->id }})" 
                                        class="group/btn py-3 px-4 rounded-xl bg-gradient-to-r from-red-50 to-rose-50 hover:from-red-500 hover:to-rose-600 border border-red-200 hover:border-red-500 transition-all flex items-center justify-center gap-2">
                                    <span class="material-icons text-lg text-red-600 group-hover/btn:text-white transition-colors">delete</span>
                                    <span class="text-sm font-bold text-red-700 group-hover/btn:text-white transition-colors">Eliminar</span>
                                </button>
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
                <div class="w-20 h-20 bg-sky-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-icons text-sky-300 text-5xl">storefront</span>
                </div>
                <h3 class="text-xl font-bold text-slate-800">Aún no tienes emprendimientos</h3>
                <p class="text-slate-500 mt-2 mb-8 max-w-md mx-auto">
                    Comienza registrando tu primer negocio para mostrar tus productos o servicios.
                </p>
                <a href="{{ route('entrepreneur.emprendimientos.create') }}" 
                   class="px-8 py-3 rounded-xl bg-gradient-to-r from-sky-500 to-indigo-600 text-white font-bold hover:opacity-90 shadow-lg shadow-sky-500/30 transition-all inline-flex items-center gap-2">
                    <span class="material-icons">add</span>
                    Crear mi primer negocio
                </a>
            </div>
        @endif
        
        <!-- Formulario oculto para eliminar -->
        <form id="deleteForm" method="POST" action="" class="hidden">
            @csrf
            @method('DELETE')
        </form>

    </div>

    <script>
        function deleteVenture(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se eliminará el emprendimiento y todos sus productos. No podrás revertir esto.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#cbd5e1',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('deleteForm');
                    // Construir la ruta dinámicamente. 
                    // Asumimos ruta standard resource destroy: /emprendedor/crear-emprendimiento/{id}
                    // Ojo: el nombre del recurso en web.php es 'crear-emprendimiento' pero names es 'emprendimientos'
                    // URL: emprendedor/crear-emprendimiento/{create_emprendimiento}
                    // Route name: entrepreneur.emprendimientos.destroy
                    
                    form.action = "{{ route('entrepreneur.emprendimientos.destroy', ':id') }}".replace(':id', id);
                    form.submit();
                }
            })
        }
    </script>
@endsection
