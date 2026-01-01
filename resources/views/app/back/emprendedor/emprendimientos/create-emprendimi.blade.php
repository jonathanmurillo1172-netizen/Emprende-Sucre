@extends('layouts.template-dash-empr')

@section('contenido-principal')
    <!-- Contenedor PRINCIPAL Alpine -->
    <div class="max-w-7xl mx-auto px-4 py-8" x-data="ventureForm()">

        <!-- HEADER -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">
                    Crear Nuevo Emprendimiento
                </h1>
                <p class="text-slate-500 mt-2 text-lg">
                    Configura tu negocio y añade tus productos o servicios iniciales.
                </p>
            </div>

            <!-- ACCIONES SUPERIORES -->
            <div class="flex items-center gap-3">
                <a href="{{ route('entrepreneur.emprendimientos.index') }}"
                    class="px-5 py-2.5 rounded-xl text-slate-600 font-bold hover:bg-slate-100 transition-all">
                    Cancelar
                </a>
                <button @click="submitForm"
                    class="px-8 py-2.5 rounded-xl bg-gradient-to-r from-sky-500 to-indigo-600 text-white font-bold shadow-lg shadow-sky-500/30 hover:opacity-90 hover:-translate-y-0.5 transition-all flex items-center gap-2">
                    <span class="material-icons text-xl">store</span>
                    Crear Emprendimiento
                </button>
            </div>
        </div>

        <form id="createVentureForm" action="{{ route('entrepreneur.emprendimientos.store') }}" method="POST"
            enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            @csrf

            <!-- COLUMNA IZQUIERDA: DATOS DEL EMPRENDIMIENTO (5 COLUMNAS) -->
            <div class="lg:col-span-5 space-y-6">

                <div class="bg-white rounded-3xl shadow-sm border border-slate-200/70 overflow-hidden sticky top-6">
                    <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                        <h2 class="font-bold text-slate-700 flex items-center gap-2">
                            <span class="material-icons text-sky-600">storefront</span>
                            Información del Negocio
                        </h2>
                    </div>

                    <div class="p-6 space-y-5">
                        <!-- Nombre -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nombre Comercial</label>
                            <input type="text" name="title" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all font-medium placeholder:text-slate-400"
                                placeholder="Ej. Café Aroma">
                        </div>

                        <!-- Categoría -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Categoría</label>
                            <select name="category_id" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all font-medium text-slate-600">
                                <option value="">Selecciona una categoría</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Ubicación -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Ubicación</label>
                            <div class="relative">
                                <span
                                    class="absolute left-4 top-1/2 -translate-y-1/2 material-icons text-slate-400 text-[20px]">place</span>
                                <input type="text" name="location" required
                                    class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all font-medium placeholder:text-slate-400"
                                    placeholder="Dirección exacta">
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Descripción General</label>
                            <textarea name="description" required rows="4"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all font-medium placeholder:text-slate-400 resize-none"
                                placeholder="Cuenta la historia de tu negocio..."></textarea>
                        </div>

                        <!-- Imagen Portada -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Imagen de Portada</label>
                            <div class="relative group cursor-pointer">
                                <div
                                    class="w-full h-48 border-2 border-dashed border-slate-300 rounded-2xl flex flex-col items-center justify-center bg-slate-50 overflow-hidden transition-all group-hover:border-emerald-400 group-hover:bg-emerald-50/10">

                                    <!-- Previsualización -->
                                    <template x-if="coverPreview">
                                        <img :src="coverPreview" class="w-full h-full object-cover">
                                    </template>

                                    <!-- Placeholder -->
                                    <div x-show="!coverPreview" class="flex flex-col items-center text-center p-4">
                                        <div
                                            class="w-12 h-12 bg-white rounded-full shadow-sm flex items-center justify-center mb-3">
                                            <span class="material-icons text-sky-600">add_a_photo</span>
                                        </div>
                                        <p class="text-sm font-semibold text-slate-600">Subir Portada</p>
                                        <p class="text-xs text-slate-400 mt-1">PNG, JPG (Máx 5MB)</p>
                                    </div>
                                </div>
                                <input type="file" name="image" accept="image/*" @change="handleCoverChange"
                                    class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- COLUMNA DERECHA: PRODUCTOS (7 COLUMNAS) -->
            <div class="lg:col-span-7 space-y-6">

                <!-- ÁREA DE AGREGAR PRODUCTO -->
                <div
                    class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl shadow-xl overflow-hidden text-white relative">
                    <!-- Decoración fondo -->
                    <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl -mr-16 -mt-16">
                    </div>

                    <div class="p-8 relative z-10">
                        <h2 class="text-xl font-bold flex items-center gap-2 mb-6">
                            <span class="material-icons text-sky-400">add_circle</span>
                            Agregar Producto / Servicio
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">

                            <!-- Input Imagen Producto -->
                            <div class="md:col-span-4">
                                <div
                                    class="aspect-square bg-slate-700/50 rounded-2xl border-2 border-dashed border-slate-600 flex flex-col items-center justify-center relative cursor-pointer hover:border-emerald-500/50 hover:bg-slate-700 transition-all overflow-hidden group">

                                    <!-- Image Preview -->
                                    <img x-show="newProduct.previewUrl" :src="newProduct.previewUrl"
                                        class="absolute inset-0 w-full h-full object-cover z-0">

                                    <div x-show="!newProduct.previewUrl" class="text-center p-2 relative z-0">
                                        <span
                                            class="material-icons text-slate-400 text-3xl mb-1 group-hover:text-emerald-400 transition-colors">cloud_upload</span>
                                        <p class="text-xs text-slate-400 font-medium">Foto Producto</p>
                                    </div>

                                    <!-- Input File REAL (se resetea tras agregar) -->
                                    <input type="file" x-ref="newProdFile" accept="image/*" @change="handleNewProdImage"
                                        class="absolute inset-0 opacity-0 cursor-pointer w-full h-full z-10">
                                </div>
                            </div>

                            <!-- Campos Datos -->
                            <div class="md:col-span-8 space-y-4">
                                <input type="text" x-model="newProduct.title"
                                    class="w-full bg-slate-700/50 border border-slate-600 rounded-xl px-4 py-2.5 text-white placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all"
                                    placeholder="Nombre del producto">

                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">$</span>
                                    <input type="number" x-model="newProduct.price"
                                        class="w-full bg-slate-700/50 border border-slate-600 rounded-xl pl-8 pr-4 py-2.5 text-white placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all"
                                        placeholder="0.00">
                                </div>

                                <textarea x-model="newProduct.description" rows="2"
                                    class="w-full bg-slate-700/50 border border-slate-600 rounded-xl px-4 py-2.5 text-white placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all resize-none text-sm"
                                    placeholder="Breve descripción..."></textarea>

                                <button type="button" @click="addProduct" :disabled="!isProductValid()"
                                    class="w-full py-3 rounded-xl font-bold transition-all flex items-center justify-center gap-2"
                                    :class="isProductValid() ?
                                        'bg-gradient-to-r from-sky-500 to-indigo-600 text-white shadow-lg shadow-sky-500/25' :
                                        'bg-slate-700 text-slate-500 cursor-not-allowed'">
                                    <span class="material-icons text-sm">add</span>
                                    Agregar otro Producto
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- LISTA DE PRODUCTOS AGREGADOS -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200/70 p-6">
                    <h3 class="font-bold text-slate-800 mb-4 flex items-center justify-between">
                        <span>Productos Agregados</span>
                        <span class="px-3 py-1 bg-sky-100 text-sky-700 rounded-full text-xs font-bold"
                            x-text="products.length + ' items'"></span>
                    </h3>

                    <!-- Empty State -->
                    <div x-show="products.length === 0"
                        class="text-center py-12 border-2 border-dashed border-slate-100 rounded-2xl">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="material-icons text-slate-300 text-3xl">inventory_2</span>
                        </div>
                        <p class="text-slate-400 font-medium">No hay productos agregados todavía.</p>
                    </div>

                    <!-- List Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" x-show="products.length > 0">
                        <template x-for="(prod, index) in products" :key="prod.id">
                            <div
                                class="bg-slate-50 rounded-2xl p-3 border border-slate-200 hover:border-sky-200 transition-colors flex gap-3 group relative">

                                <button type="button" @click="removeProduct(index)"
                                    class="absolute -top-2 -right-2 w-7 h-7 bg-red-500 text-white rounded-full shadow-sm flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all z-10 hover:bg-red-600 hover:scale-110">
                                    <span class="material-icons text-sm">close</span>
                                </button>

                                <!-- Thumbnail -->
                                <div
                                    class="w-20 h-20 bg-white rounded-xl flex-shrink-0 overflow-hidden border border-slate-100">
                                    <img :src="prod.previewUrl" class="w-full h-full object-cover">
                                </div>

                                <!-- Info -->
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-slate-800 truncate" x-text="prod.title"></h4>
                                    <p class="text-sky-600 font-bold text-sm" x-text="'$' + prod.price"></p>
                                    <p class="text-slate-500 text-xs line-clamp-2 mt-1" x-text="prod.description"></p>

                                    <!-- Inputs Ocultos con ID ÚNICO para enviar al Backend -->
                                    <input type="hidden" :name="`products[${prod.id}][title]`" :value="prod.title">
                                    <input type="hidden" :name="`products[${prod.id}][price]`" :value="prod.price">
                                    <input type="hidden" :name="`products[${prod.id}][description]`"
                                        :value="prod.description">
                                    <!-- El input FILE se adjuntará dinámicamente aquí usando el ID -->
                                    <div :id="`file-container-${prod.id}`"></div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

        </form>
    </div>
@endsection

@section('scripts')
    document.addEventListener('alpine:init', () => {
    Alpine.data('ventureForm', () => ({
    coverPreview: null,
    products: [],
    newProduct: {
    title: '',
    price: '',
    description: '',
    previewUrl: null
    },

    handleCoverChange(event) {
    const file = event.target.files[0];
    if (file) {
    this.coverPreview = URL.createObjectURL(file);
    }
    },

    handleNewProdImage(event) {
    const file = event.target.files[0];
    if (file) {
    this.newProduct.previewUrl = URL.createObjectURL(file);
    }
    },

    isProductValid() {
    return this.newProduct.title.trim() !== '' &&
    this.newProduct.price !== '' &&
    this.newProduct.description.trim() !== '' &&
    this.$refs.newProdFile.files.length > 0;
    },

    resetNewProductForm() {
    this.$refs.newProdFile.value = '';
    this.newProduct = {
    title: '',
    price: '',
    description: '',
    previewUrl: null
    };
    },

    removeProduct(index) {
    this.products.splice(index, 1);
    },

    addProduct() {
    if (!this.isProductValid()) return;

    const uniqueId = Date.now();
    const file = this.$refs.newProdFile.files[0];

    const cleanProduct = {
    id: uniqueId,
    title: this.newProduct.title,
    price: this.newProduct.price,
    description: this.newProduct.description,
    previewUrl: this.newProduct.previewUrl,
    fileObject: file
    };

    this.products.push(cleanProduct);

    this.$nextTick(() => {
    const container = document.getElementById(`file-container-${uniqueId}`);

    if (container) {
    const newInput = document.createElement('input');
    newInput.type = 'file';
    newInput.name = `products[${uniqueId}][image]`;
    newInput.className = 'hidden';

    const dataTransfer = new DataTransfer();
    dataTransfer.items.add(cleanProduct.fileObject);
    newInput.files = dataTransfer.files;

    container.appendChild(newInput);
    }
    this.resetNewProductForm();
    });
    },

    submitForm() {
        const form = document.getElementById('createVentureForm');
        
        // 1. Validar campos del emprendimiento (Manual check para SweetAlert)
        const title = form.querySelector('[name="title"]').value.trim();
        const category = form.querySelector('[name="category_id"]').value;
        const location = form.querySelector('[name="location"]').value.trim();
        const description = form.querySelector('[name="description"]').value.trim();
        const imageInput = form.querySelector('[name="image"]');
        
        // Verificar si hay archivos seleccionados o si ya hay una imagen previa (si fuera edición, pero esto es crear)
        const hasImage = imageInput.files.length > 0; 

        if (!title || !category || !location || !description || !hasImage) {
            Swal.fire({
                title: 'Faltan Datos',
                text: "Debes completar la información del negocio y subir una imagen de portada.",
                icon: 'error',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#ef4444'
            });
            return;
        }

        if (this.products.length === 0) {
            Swal.fire({
                title: 'Emprendimiento sin productos',
                text: "Este emprendimiento no tiene productos agregados. ¿Deseas crearlo de todas formas?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, crear',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#0ea5e9',
                cancelButtonColor: '#6b7280'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        } else {
            form.submit();
        }
    }
    }));
    });
@endsection
