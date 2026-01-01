@extends('layouts.template-back')
@section('titulo', 'Categorias')

{{-- enlaces de css --}}
@section('enlaces_css')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/categorias.css') }}">
@endsection

{{-- Contenido Principal --}}
@section('contenido-principal')
    <div class="container mx-auto px-4 pb-12">

        {{-- Encabezado --}}
        <div class="flex justify-between items-center mb-10">
            <div class="categories-header">
                <h2 class="categories-title">
                    Gestión de <span class="typing-cat">Categorías</span>
                </h2>

                <p class="categories-subtitle">
                    Administra las clasificaciones para los emprendimientos.
                </p>
            </div>
        </div>


        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            <!-- Formulario Crear Categoría -->
            <div class="lg:col-span-1 transition-shadow duration-300 hover:shadow-[0_20px_40px_-10px_rgba(124,58,237,0.45)]">
                <div
                    class="h-fit bg-white rounded-2xl border-l-4 border-violet-500 p-6
                           shadow-[10px_10px_22px_-8px_rgba(124,58,237,0.35)]
                           sticky top-24">

                    <h3 class="text-lg font-extrabold text-slate-800 mb-6 flex items-center gap-3">
                        <span class="material-icons text-violet-600 bg-violet-100 p-2 rounded-xl">add_circle</span>
                        Nueva Categoría
                    </h3>

                    {{-- Formulario para crear nueva categoría --}}
                    <form id="createCategoryForm" method="POST" action="{{ route('admin.categoria.store') }}"
                        class="space-y-5">
                        @csrf

                        <div>
                            <label class="block text-xs font-extrabold text-slate-500 uppercase mb-2">Nombre de la
                                categoria</label>

                            <input type="text" id="catName" placeholder="Ej: Gastronomía" name="name"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 text-sm py-3 px-4
                                       transition placeholder:text-slate-400 outline-none
                                       focus:bg-white focus:border-violet-500 focus:ring-2 focus:ring-violet-500/30">

                            {{-- Muestra mensaje de error si la validación del campo nombre me falla --}}
                            @error('name')
                                <div
                                    class="mt-2 flex items-start gap-2 text-red-700 bg-red-50 border border-red-200 p-3 rounded-xl">
                                    <span class="material-icons text-red-600 text-base">error</span>
                                    <p class="text-sm leading-tight">
                                        {{ $message }}
                                    </p>
                                </div>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-extrabold text-slate-500 uppercase mb-2">Descripción</label>

                            <textarea id="catDesc" rows="5"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 text-sm py-3 px-4
                                       transition placeholder:text-slate-400 outline-none resize-none
                                       focus:bg-white focus:border-violet-500 focus:ring-2 focus:ring-violet-500/30"
                                placeholder="Describe brevemente esta categoría..." name="description"></textarea>
                        </div>

                        <button type="submit"
                            class="w-full bg-violet-600 text-white font-extrabold py-3 rounded-xl
                                   shadow hover:bg-violet-700 transition flex items-center justify-center gap-2">
                            Crear Categoría
                            <span class="material-icons text-base">arrow_forward</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Tabla de Categorías -->
            <div
                class="lg:col-span-2 transition-shadow duration-300 hover:shadow-[0_20px_40px_-10px_rgba(124,58,237,0.45)]">
                <div
                    class="bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100 border-t-4 border-t-violet-500">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead class="bg-slate-50">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">
                                    N.º
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-extrabold text-slate-500 uppercase tracking-wider">
                                    Información
                                </th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-extrabold text-slate-500 uppercase tracking-wider">
                                    Emprendimientos
                                </th>
                                <th
                                    class="px-6 py-4 text-right text-xs font-extrabold text-slate-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-slate-100">
                            @forelse($categories as $key => $category)
                                <tr class="hover:bg-slate-50 transition">
                                    {{-- Número de fila --}}
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg
                                                   bg-slate-100 text-xs font-bold text-slate-600">
                                            {{ $categories->firstItem() + $key }}
                                        </span>
                                    </td>

                                    {{-- Nombre y descripción de la categoría --}}
                                    <td class="px-6 py-4">
                                        <span
                                            class="text-sm font-extrabold text-slate-800 block">{{ $category->name }}</span>
                                        <span class="text-xs text-slate-500">{{ $category->description }}</span>
                                    </td>

                                    {{-- Contador de emprendimientos asociados --}}
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="inline-flex items-center justify-center min-w-[34px] h-8 px-3
                                                   text-xs font-extrabold rounded-full bg-violet-100 text-violet-700">
                                            {{ $category->ventures_count }}
                                        </span>
                                    </td>

                                    {{-- Botones de acción: editar y eliminar --}}
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <div class="flex justify-end items-center gap-2">
                                            <a href="{{ route('admin.categoria.edit', $category) }}"
                                                class="text-black-600 hover:text-violet-700 bg-slate-100 hover:bg-violet-100
                                                       p-2 rounded-lg transition"
                                                title="Editar categoría">
                                                <span class="material-icons text-base align-middle">edit</span>
                                            </a>

                                            {{-- Boton para eliminar  el id es para enviar a la alerta el id de la categoria que voy a eliminar --}}
                                            <form id="delete-form-{{ $category->id }}"
                                                action="{{ route('admin.categoria.destroy', $category) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    onclick="confirmDelete({{ $category->id }}, '{{ $category->name }}', {{ $category->ventures_count }})"
                                                    class="text-red-600 hover:text-red-700 bg-slate-100 hover:bg-red-100
                                                           p-2 rounded-lg transition"
                                                    title="Eliminar categoría">
                                                    <span class="material-icons text-base align-middle">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                        <span class="material-icons text-5xl text-slate-200 block mb-2">category</span>
                                        No hay categorías registradas aún.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Cpaginacion --}}
                    @if ($categories->hasPages())
                        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                            <div class="flex justify-center gap-2">

                                @if ($categories->onFirstPage())
                                    <span
                                        class="px-4 py-2 text-sm font-bold text-slate-400 bg-slate-100 rounded-lg cursor-not-allowed">
                                        ← Anterior
                                    </span>
                                @else
                                    <a href="{{ $categories->previousPageUrl() }}"
                                        class="px-4 py-2 text-sm font-bold text-violet-600 bg-white border border-violet-200 rounded-lg hover:bg-violet-50 transition">
                                        ← Anterior
                                    </a>
                                @endif

                                @foreach ($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                                    @if ($page == $categories->currentPage())
                                        <span
                                            class="px-4 py-2 text-sm font-extrabold text-white bg-violet-600 rounded-lg shadow">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $url }}"
                                            class="px-4 py-2 text-sm font-bold text-violet-600 bg-white border border-violet-200 rounded-lg hover:bg-violet-50 transition">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach

                                @if ($categories->hasMorePages())
                                    <a href="{{ $categories->nextPageUrl() }}"
                                        class="px-4 py-2 text-sm font-bold text-violet-600 bg-white border border-violet-200 rounded-lg hover:bg-violet-50 transition">
                                        Siguiente →
                                    </a>
                                @else
                                    <span
                                        class="px-4 py-2 text-sm font-bold text-slate-400 bg-slate-100 rounded-lg cursor-not-allowed">
                                        Siguiente →
                                    </span>
                                @endif

                            </div>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
@endsection



{{-- Script de validación del lado del cliente --}}
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Alertas de categorias si hay campos vacios --}}
    <script src="{{ asset('assets/admin/js/alertas-categorias.js') }}"></script>
    <script>
        // Notificacion de crear categoria
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        @endif
    </script>
@endsection
