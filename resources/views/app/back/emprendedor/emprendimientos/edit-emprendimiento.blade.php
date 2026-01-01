@extends('layouts.template-dash-empr')

@section('contenido-principal')
    <!-- Contenedor PRINCIPAL -->
    <div class="max-w-4xl mx-auto px-4 py-8">

        <!-- HEADER -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">
                    Editar Emprendimiento
                </h1>
                <p class="text-slate-500 mt-2 text-lg">
                    Actualiza la información de tu negocio.
                </p>
            </div>

            <!-- ACCIONES SUPERIORES -->
            <div class="flex items-center gap-3">
                <a href="{{ route('entrepreneur.emprendimientos.index') }}"
                    class="px-5 py-2.5 rounded-xl text-slate-600 font-bold hover:bg-slate-100 transition-all">
                    Cancelar
                </a>
                <button type="submit" form="editVentureForm"
                    class="px-8 py-2.5 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold shadow-lg shadow-blue-500/30 hover:shadow-blue-500/40 hover:-translate-y-0.5 transition-all flex items-center gap-2">
                    <span class="material-icons text-xl">save</span>
                    Guardar Cambios
                </button>
            </div>
        </div>

        <form id="editVentureForm" action="{{ route('entrepreneur.emprendimientos.update', $venture->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-3xl shadow-sm border border-slate-200/70 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                    <h2 class="font-bold text-slate-700 flex items-center gap-2">
                        <span class="material-icons text-blue-500">storefront</span>
                        Información del Negocio
                    </h2>
                </div>

                <div class="p-6 space-y-5">
                    <!-- Nombre -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nombre Comercial</label>
                        <input type="text" name="title" value="{{ old('title', str_replace('[RECHAZADO] ', '', $venture->title)) }}" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all outline-none"
                            placeholder="Ej: Tienda de Ropa Deportiva">
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Categoría -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Categoría</label>
                        <select name="category_id" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all outline-none">
                            <option value="">Selecciona una categoría</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $venture->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ubicación -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Ubicación</label>
                        <input type="text" name="location" value="{{ old('location', $venture->location) }}" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all outline-none"
                            placeholder="Ej: Centro Comercial Plaza Mayor, Local 23">
                        @error('location')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Descripción -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Descripción</label>
                        <textarea name="description" rows="4" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all outline-none resize-none"
                            placeholder="Describe tu emprendimiento...">{{ old('description', $venture->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Imagen -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Imagen de Portada</label>
                        
                        <!-- Preview de imagen -->
                        <div class="mb-3">
                            <p class="text-xs text-slate-500 mb-2">Vista previa:</p>
                            <div class="relative w-full h-48 rounded-xl overflow-hidden border-2 border-slate-200 bg-slate-100">
                                <!-- Imagen actual (siempre visible por defecto) -->
                                <img id="currentImage" 
                                     src="{{ asset('storage/' . $venture->image) }}" 
                                     class="w-full h-full object-cover" 
                                     alt="{{ $venture->title }}">
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
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-600 file:font-semibold hover:file:bg-blue-100">
                        <p class="text-xs text-slate-500 mt-1">Deja vacío si no deseas cambiar la imagen. Formatos: JPG, PNG, GIF (máx. 2MB)</p>
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
                    // Ocultar imagen actual
                    document.getElementById('currentImage').classList.add('hidden');
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
