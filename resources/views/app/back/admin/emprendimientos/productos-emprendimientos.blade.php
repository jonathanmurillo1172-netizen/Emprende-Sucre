@extends('layouts.template-back')
@section('titulo', 'Validar Productos')
@section('contenido-principal')
    <div class="max-w-7xl mx-auto px-4 py-8">
        
        <!-- HEADER -->
        <div class="mb-8">
            <h1 class="text-3xl font-black text-slate-800 mb-2">
                Productos del <span class="text-violet-600">Emprendimiento</span>
            </h1>
            <p class="text-slate-600">Visualiza el catálogo de productos de esta solicitud.</p>
        </div>

        <!-- INFO DEL EMPRENDIMIENTO -->
        <div class="mb-6 p-4 bg-white rounded-xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $venture->image) }}" class="w-full h-full object-cover" alt="{{ $venture->title }}">
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">{{ $venture->title }}</h2>
                        <p class="text-sm text-slate-500">{{ $products->count() }} productos</p>
                    </div>
                </div>
                <!-- VOLVER A EMPRENDIMIENTOS APROBADOS -->
                <a href="{{ route('admin.emprendimientos.index') }}" 
                   class="px-4 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-sm transition-all flex items-center gap-2">
                    <span class="material-icons text-lg">arrow_back</span>
                    Volver
                </a>
            </div>
        </div>

        @if($products->count() > 0)
            <!-- GRID DE PRODUCTOS -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 border border-slate-200 flex flex-col">
                        
                        <!-- IMAGEN DEL PRODUCTO -->
                        <div class="relative h-48 overflow-hidden bg-gradient-to-br from-indigo-400 to-purple-500">
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                 alt="{{ $product->title }}">
                            
                            <!-- PRECIO -->
                            <div class="absolute top-3 right-3">
                                <div class="px-3 py-1.5 rounded-lg bg-white/95 backdrop-blur-sm shadow-lg">
                                    <span class="text-lg font-black text-slate-800">${{ number_format($product->price, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- CONTENIDO -->
                        <div class="p-4 flex flex-col flex-1">
                            <!-- TÍTULO -->
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-bold text-slate-800 line-clamp-1">
                                    {{ $product->title }}
                                </h3>
                                <!-- BADGE DE ESTADO -->
                                @if($product->status === 'active')
                                    <span class="flex h-2 w-2 rounded-full bg-emerald-500 shadow-sm" title="Activo"></span>
                                @else
                                    <span class="flex h-2 w-2 rounded-full bg-amber-500 shadow-sm" title="Desactivado"></span>
                                @endif
                            </div>

                            <!-- CATEGORÍA -->
                            <div class="flex items-center gap-1.5 mb-3">
                                <span class="material-icons text-sm text-slate-400">category</span>
                                <span class="text-xs text-slate-500 font-semibold">{{ $venture->category->name ?? 'Sin categoría' }}</span>
                            </div>

                            <!-- DESCRIPCIÓN - con altura fija -->
                            <p class="text-sm text-slate-600 leading-relaxed mb-4 line-clamp-2 h-10">
                                {{ $product->description }}
                            </p>

                            <!-- ACCIONES -->
                            <div class="mt-auto pt-4 border-t border-slate-100">
                                <button onclick="toggleProductStatus('{{ $product->id }}', '{{ $product->status }}')"
                                    class="w-full py-2.5 px-4 rounded-xl transition-all flex items-center justify-center gap-2 group/btn
                                    {{ $product->status === 'active' 
                                        ? 'bg-amber-50 hover:bg-amber-500 text-amber-700 hover:text-white border border-amber-200' 
                                        : 'bg-emerald-50 hover:bg-emerald-500 text-emerald-700 hover:text-white border border-emerald-200' }}">
                                    <span class="material-icons text-lg transition-colors">
                                        {{ $product->status === 'active' ? 'visibility_off' : 'visibility' }}
                                    </span>
                                    <span class="text-xs font-bold transition-colors">
                                        {{ $product->status === 'active' ? 'Desactivar Producto' : 'Activar Producto' }}
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- ESTADO VACÍO -->
            <div class="text-center py-16">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-slate-100 flex items-center justify-center">
                    <span class="material-icons text-6xl text-slate-400">inventory_2</span>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-2">No hay productos</h3>
                <p class="text-slate-600 mb-6">Este emprendimiento aún no tiene productos agregados.</p>
            </div>
        @endif

    </div>
@endsection

@section('scrip-final')
    <script>
        function toggleProductStatus(id, currentStatus) {
            const action = currentStatus === 'active' ? 'desactivar' : 'activar';
            const confirmColor = currentStatus === 'active' ? '#f59e0b' : '#10b981';

            Swal.fire({
                title: `¿${action.charAt(0).toUpperCase() + action.slice(1)} Producto?`,
                text: `El producto ${currentStatus === 'active' ? 'ya no será visible' : 'volverá a ser visible'} en el catálogo público.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: confirmColor,
                cancelButtonColor: '#6b7280',
                confirmButtonText: `Sí, ${action}`,
                cancelButtonText: 'Cancelar',
                customClass: { popup: 'rounded-2xl' }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`{{ url('/admin/productos') }}/${id}/toggle-status`, {
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
