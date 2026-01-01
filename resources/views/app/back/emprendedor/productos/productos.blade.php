@extends('layouts.template-dash-empr')

@section('nombre-pagina', 'Mis Productos')

@section('contenido-principal')
    <div class="max-w-7xl mx-auto px-4 py-8">
        
        <!-- HEADER -->
        <div class="mb-8">
            <h1 class="text-3xl font-black text-slate-800 mb-2">
                Mis <span class="text-sky-600">Productos</span>
            </h1>
            <p class="text-slate-600">Gestiona el catálogo de productos de tus emprendimientos</p>
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
                <div class="flex items-center gap-3">
                    <a href="{{ route('entrepreneur.emprendimientos.productos.create', $venture->id) }}" 
                       class="px-4 py-2 rounded-lg bg-sky-600 hover:bg-sky-700 text-white font-semibold text-sm transition-all flex items-center gap-2">
                        <span class="material-icons text-lg">add_circle</span>
                        Agregar Producto
                    </a>
                    <a href="{{ route('entrepreneur.emprendimientos.index') }}" 
                       class="px-4 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-sm transition-all flex items-center gap-2">
                        <span class="material-icons text-lg">arrow_back</span>
                        Volver
                    </a>
                </div>
            </div>
        </div>

        @if($products->count() > 0)
            <!-- GRID DE PRODUCTOS -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 border border-slate-200 flex flex-col">
                        
                        <!-- IMAGEN DEL PRODUCTO -->
                        <div class="relative h-48 overflow-hidden bg-gradient-to-br from-sky-400 to-indigo-600">
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
                                @if($product->status === 'disabled')
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-600 uppercase" title="Desactivado por administración">
                                        Desactivado
                                    </span>
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

                            <!-- BOTONES - siempre al final -->
                            <div class="flex gap-2 mt-auto">
                                <a href="{{ route('entrepreneur.emprendimientos.productos.edit', [$venture->id, $product->id]) }}"
                                   class="flex-1 py-2 px-3 rounded-lg bg-blue-50 hover:bg-blue-500 text-blue-600 hover:text-white font-semibold text-sm transition-all flex items-center justify-center gap-1.5 group/btn">
                                    <span class="material-icons text-base">edit</span>
                                    <span>Editar</span>
                                </a>
                                
                                <form action="{{ route('entrepreneur.emprendimientos.productos.destroy', [$venture->id, $product->id]) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="py-2 px-3 rounded-lg bg-red-50 hover:bg-red-500 text-red-600 hover:text-white font-semibold text-sm transition-all flex items-center justify-center group/btn w-full">
                                        <span class="material-icons text-base">delete</span>
                                        <span>Eliminar</span>
                                    </button>
                                </form>
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
                <a href="{{ route('entrepreneur.emprendimientos.productos.create', $venture->id) }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-bold transition-all">
                    <span class="material-icons">add_circle</span>
                    Agregar Producto
                </a>
            </div>
        @endif

    </div>

@endsection

@section('scrip-final')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('.delete-form');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sí, eliminarlo',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
