@extends('layouts.template-back')
@section('titulo', 'Editar Categoria')
@section('contenido-principal')
    <div class="max-w-5xl mx-auto px-4 py-8">

        <!-- TÍTULO -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-800">
                Gestión de Categorías
            </h1>
            <p class="text-sm text-slate-500">
                Edita la información de una categoría existente
            </p>
        </div>

        <!-- CARD -->
        <div
            class="max-w-md bg-white rounded-2xl p-6
               border border-slate-100 border-t-4 border-t-violet-500
               shadow-lg
               transition-shadow duration-300
               hover:shadow-[0_20px_40px_-10px_rgba(124,58,237,0.45)]">

            <!-- CABECERA -->
            <div class="flex items-center gap-3 mb-6">
                <div class="bg-violet-100 text-violet-600 p-2 rounded-xl">
                    <span class="material-icons">edit</span>
                </div>
                <h2 class="text-lg font-semibold text-slate-800">
                    Editar Categoría
                </h2>
            </div>

            <!-- FORMULARIO -->
            <form action="{{ route('admin.categoria.update', $category) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- NOMBRE -->
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">
                        Nombre de la categoría
                    </label>

                    <input type="text" name="name" value="{{ old('name', $category->name) }}"
                        placeholder="Ej: Gastronomía"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 text-lg py-3 px-4
                           transition placeholder:text-slate-400 outline-none
                           focus:bg-white focus:border-violet-500 focus:ring-2 focus:ring-violet-500/30">

                    @error('name')
                        <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                            <span class="material-icons text-base">error_outline</span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- DESCRIPCIÓN -->
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">
                        Descripción
                    </label>

                    <textarea name="description" rows="3" placeholder="Describe brevemente esta categoría..."
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 text-lg py-3 px-4
                           transition placeholder:text-slate-400 outline-none resize-none
                           focus:bg-white focus:border-violet-500 focus:ring-2 focus:ring-violet-500/30">{{ old('description', $category->description) }}</textarea>

                    @error('description')
                        <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                            <span class="material-icons text-base">error_outline</span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- BOTONES -->
                <div class="flex items-center justify-between pt-4 gap-4">
                    <a href="{{ route('admin.categoria.index') }}"
                        class="text-slate-600 bg-slate-100 hover:bg-slate-200
                           font-semibold px-6 py-2 rounded-xl transition">
                        Cancelar
                    </a>

                    <button type="submit"
                        class="bg-violet-600 hover:bg-violet-700
                           text-white font-semibold px-6 py-2 rounded-xl transition">
                        Guardar Cambios
                    </button>
                </div>
            </form>

        </div>
    </div>

@endsection
@section('scrip-final')
@endsection
