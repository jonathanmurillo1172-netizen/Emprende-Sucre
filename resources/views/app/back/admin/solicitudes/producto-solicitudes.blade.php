@extends('layouts.template-back')
{{-- Titulo de la pagina --}}
@section('titulo', 'Validar Productos')
{{-- links del css --}}
@section('enlaces_css')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/ver-prodc-admin.css') }}">
@endsection
{{-- contenido principal --}}
@section('contenido-principal')
    <div class="max-w-7xl mx-auto px-4 py-8">

        <!-- HEADER -->
        <div class="mb-10 categories-header">

            <h1 class="categories-title">
                Productos del
                <span class="typing-cat">Emprendimiento</span>
            </h1>

            <p class="categories-subtitle">
                Visualiza el catálogo de productos de esta solicitud.
            </p>

        </div>

        <!-- INFO DEL EMPRENDIMIENTO -->
        <div class="mb-6 p-4 bg-white rounded-xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $venture->image) }}" class="w-full h-full object-cover"
                            alt="{{ $venture->title }}">
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">{{ $venture->title }}</h2>
                        <p class="text-sm text-slate-500">{{ $products->count() }} productos</p>
                    </div>
                </div>
                <!-- VOLVER A VALIDAR EMPRENDIMIENTOS -->
                <a href="{{ route('admin.validar.index') }}"
                    class="px-4 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-sm transition-all flex items-center gap-2">
                    <span class="material-icons text-lg">arrow_back</span>
                    Volver
                </a>
            </div>
        </div>

        @if ($products->count() > 0)
            <!-- GRID DE PRODUCTOS -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <div
                        class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 border border-slate-200 flex flex-col">

                        <!-- IMAGEN DEL PRODUCTO -->
                        <div class="relative h-48 overflow-hidden bg-gradient-to-br from-indigo-400 to-purple-500">
                            <img src="{{ asset('storage/' . $product->image) }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                alt="{{ $product->title }}">

                            <!-- PRECIO -->
                            <div class="absolute top-3 right-3">
                                <div class="px-3 py-1.5 rounded-lg bg-white/95 backdrop-blur-sm shadow-lg">
                                    <span
                                        class="text-lg font-black text-slate-800">${{ number_format($product->price, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- CONTENIDO -->
                        <div class="p-4 flex flex-col flex-1">
                            <!-- TÍTULO -->
                            <h3 class="text-lg font-bold text-slate-800 mb-2 line-clamp-1">
                                {{ $product->title }}
                            </h3>

                            <!-- CATEGORÍA -->
                            <div class="flex items-center gap-1.5 mb-3">
                                <span class="material-icons text-sm text-slate-400">category</span>
                                <span
                                    class="text-xs text-slate-500 font-semibold">{{ $venture->category->name ?? 'Sin categoría' }}</span>
                            </div>

                            <!-- DESCRIPCIÓN - con altura fija -->
                            <p class="text-sm text-slate-600 leading-relaxed mb-4 line-clamp-2 h-10">
                                {{ $product->description }}
                            </p>
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
    <!-- No scripts needed for read-only View -->
@endsection
