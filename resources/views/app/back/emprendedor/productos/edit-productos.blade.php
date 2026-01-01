@extends('layouts.template-dash-empr')

@section('contenido-principal')
    <!-- Contenedor PRINCIPAL -->
    <div class="max-w-4xl mx-auto px-4 py-8">

        <!-- HEADER -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">
                    Editar Producto
                </h1>
                <p class="text-slate-500 mt-2 text-lg">
                    Actualiza la información de tu producto.
                </p>
            </div>

            <!-- ACCIONES SUPERIORES -->
            <div class="flex items-center gap-3">
                <a href="{{ route('entrepreneur.emprendimientos.productos.index', $venture->id) }}"
                    class="px-5 py-2.5 rounded-xl text-slate-600 font-bold hover:bg-slate-100 transition-all">
                    Cancelar
                </a>
                <button type="submit" form="editProductForm"
                    class="px-8 py-2.5 rounded-xl bg-gradient-to-r from-sky-500 to-indigo-600 text-white font-bold shadow-lg shadow-sky-500/30 hover:opacity-90 hover:-translate-y-0.5 transition-all flex items-center gap-2">
                    <span class="material-icons text-xl">save</span>
                    Guardar Cambios
                </button>
            </div>
        </div>

        <form id="editProductForm" action="{{ route('entrepreneur.emprendimientos.productos.update', [$venture->id, $product->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-3xl shadow-sm border border-slate-200/70 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                    <h2 class="font-bold text-slate-700 flex items-center gap-2">
                        <span class="material-icons text-sky-600">inventory_2</span>
                        Información del Producto
                    </h2>
                </div>

                <div class="p-6 space-y-5">
                    <!-- Nombre -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nombre del Producto</label>
                        <input type="text" name="title" value="{{ old('title', $product->title) }}" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 transition-all outline-none"
                            placeholder="Ej: Plato Especial">
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Precio -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Precio</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 font-bold">$</span>
                            </div>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required
                                class="w-full pl-8 pr-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 transition-all outline-none"
                                placeholder="0.00">
                        </div>
                        @error('price')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Descripción -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Descripción</label>
                        <textarea name="description" rows="4" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 transition-all outline-none resize-none"
                            placeholder="Describe tu producto...">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Imagen -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Imagen del Producto</label>
                        
                        <!-- Preview de imagen -->
                        <div class="mb-3">
                            <p class="text-xs text-slate-500 mb-2">Vista previa:</p>
                            <div class="relative w-full h-48 rounded-xl overflow-hidden border-2 border-slate-200 bg-slate-100 flex items-center justify-center">
                                <!-- Imagen actual (siempre visible por defecto si existe) -->
                                @if($product->image)
                                    <img id="currentImage" 
                                         src="{{ asset('storage/' . $product->image) }}" 
                                         class="w-full h-full object-cover" 
                                         alt="{{ $product->title }}">
                                @else
                                    <div id="noImagePlaceholder" class="flex flex-col items-center justify-center text-slate-400">
                                        <span class="material-icons text-4xl">image</span>
                                        <span class="text-xs">Sin imagen</span>
                                    </div>
                                @endif
                                
                                <!-- Nueva imagen (preview - oculta por defecto) -->
                                <img id="previewImage"
                                     src="" 
                                     class="w-full h-full object-cover hidden" 
                                     alt="Preview">
                            </div>
                        </div>

                        <input type="file" 
                               name="image" 
                               id="imageInput"
                               accept="image/*" 
                               onchange="previewNewImage(event)"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 transition-all outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-sky-50 file:text-sky-600 file:font-semibold hover:file:bg-sky-100">
                        <p class="text-xs text-slate-500 mt-1">Deja vacío si no deseas cambiar la imagen. Formatos: JPG, PNG, GIF (máx. 5MB)</p>
                        @error('image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection

@section('scripts')
    <script>
        function previewNewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Ocultar imagen actual o placeholder
                    const currentImg = document.getElementById('currentImage');
                    if (currentImg) currentImg.classList.add('hidden');
                    
                    const placeholder = document.getElementById('noImagePlaceholder');
                    if (placeholder) placeholder.classList.add('hidden');

                    // Mostrar y actualizar preview
                    const previewImg = document.getElementById('previewImage');
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
