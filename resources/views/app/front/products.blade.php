@extends('layouts.template-home')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/home/css/estilo-productos.css') }}">
@endsection

@section('content')
    
    {{-- Mensaje de éxito --}}
    @if (session('swal_success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Enviado!',
                    text: '{{ session('swal_success') }}',
                    confirmButtonColor: '#06b6d4',
                    background: 'linear-gradient(135deg, #0891b2 0%, #1e40af 100%)',
                    color: '#fff',
                    customClass: {
                        popup: 'rounded-3xl shadow-2xl border-4 border-white',
                        title: 'font-black text-3xl'
                    },
                    showClass: {
                        popup: 'animate__animated animate__zoomIn animate__faster'
                    }
                });
            });
        </script>
    @endif

    <div class="bg-gradient-to-br from-slate-50 via-cyan-50/30 to-blue-50/20 min-h-screen relative overflow-hidden">

        {{-- Esferas flotantes de fondo --}}
        <div class="fixed inset-0 pointer-events-none z-0">
            <div
                class="absolute top-20 left-10 w-72 h-72 bg-gradient-to-br from-cyan-400/20 to-blue-400/20 rounded-full blur-3xl animate-float">
            </div>
            <div class="absolute top-1/3 right-20 w-96 h-96 bg-gradient-to-br from-teal-400/20 to-cyan-400/20 rounded-full blur-3xl animate-float"
                style="animation-delay: 1s;"></div>
            <div class="absolute bottom-20 left-1/3 w-80 h-80 bg-gradient-to-br from-blue-400/20 to-indigo-400/20 rounded-full blur-3xl animate-float"
                style="animation-delay: 2s;"></div>
        </div>

        {{-- Encabezado inmersivo --}}
        <div class="relative min-h-[70vh] flex items-center justify-center pt-20 overflow-hidden">
            {{-- Fondo con cuadrícula animada --}}
            <div class="absolute inset-0 z-0 opacity-10">
                <div class="absolute inset-0"
                    style="background-image: linear-gradient(#0891b2 1px, transparent 1px), linear-gradient(90deg, #0891b2 1px, transparent 1px); background-size: 50px 50px;">
                </div>
            </div>

            {{-- Botón de regresar --}}
            <div class="absolute top-32 left-6 z-30 animate-fadeInUp">
                <a href="{{ route('home') }}"
                    class="group inline-flex items-center gap-2 w-14 h-14 justify-center rounded-2xl bg-white/80 backdrop-blur-xl text-slate-700 shadow-2xl hover:shadow-cyan-500/50 hover:scale-110 hover:bg-gradient-to-br hover:from-cyan-500 hover:to-blue-600 hover:text-white transition-all duration-500 border border-white/50">
                    <span class="material-icons-round group-hover:scale-110 transition-transform">arrow_back</span>
                </a>
            </div>

            <div class="relative z-10 w-full max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                {{-- Información de texto --}}
                <div class="text-center lg:text-left order-2 lg:order-1 space-y-6">
                    <div
                        class="inline-flex items-center gap-3 px-5 py-3 rounded-full bg-gradient-to-r from-cyan-400/20 to-blue-400/20 backdrop-blur-xl shadow-lg border border-cyan-400/30 mb-6 animate-fadeInUp animate-glow">
                        <span
                            class="w-3 h-3 rounded-full bg-gradient-to-r from-cyan-400 to-blue-500 animate-pulse shadow-lg shadow-cyan-500/50"></span>
                        <span
                            class="text-xs font-black text-cyan-700 uppercase tracking-widest">{{ $venture->category->name ?? 'Emprendimiento' }}</span>
                    </div>

                    <h1
                        class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-black bg-clip-text text-transparent bg-gradient-to-r from-slate-900 via-cyan-900 to-blue-900 leading-tight mb-8 animate-fadeInUp stagger-1 drop-shadow-sm break-words">
                        {{ $venture->title }}
                    </h1>

                    <p
                        class="text-2xl text-slate-600 font-semibold leading-relaxed mb-10 max-w-xl mx-auto lg:mx-0 animate-fadeInUp stagger-2">
                        {{ $venture->description }}
                    </p>

                    <div
                        class="flex flex-col sm:flex-row items-center gap-6 justify-center lg:justify-start animate-fadeInUp stagger-3 mb-12">
                        {{-- Botón Contactar --}}
                        <button onclick="openModal()"
                            class="h-12 px-6 rounded-xl bg-gradient-to-r from-slate-900 via-cyan-900 to-blue-900 text-white font-bold text-sm overflow-hidden hover:shadow-xl hover:shadow-cyan-500/50 hover:-translate-y-1 transition-all duration-500 flex items-center justify-center gap-2 group relative">
                            <div class="absolute inset-0 shimmer-bg"></div>
                            <span class="relative z-10">Contactar ahora</span>
                            <span
                                class="material-icons-round relative z-10 group-hover:translate-x-1 transition-transform text-base">arrow_forward</span>
                        </button>

                        {{-- Badge Creado Por --}}
                        <div
                            class="h-12 px-6 rounded-xl bg-white/60 backdrop-blur-xl border border-white/50 shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300 flex items-center gap-3">
                            <div
                                class="w-7 h-7 rounded-full bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center text-white font-black text-xs border border-white shadow-lg animate-glow">
                                {{ substr($venture->entrepreneur->user->name ?? 'A', 0, 1) }}
                            </div>
                            <div class="text-left leading-tight">
                                <p class="text-[8px] text-cyan-600 font-black uppercase tracking-widest">Creado por</p>
                                <p class="text-xs font-black text-slate-900">
                                    {{ $venture->entrepreneur->user->name ?? 'Emprendedor' }}</p>
                            </div>
                        </div>

                        {{-- Botón WhatsApp --}}
                        @if ($venture->entrepreneur && $venture->entrepreneur->phone)
                            @php
                                $phone = preg_replace('/[^0-9]/', '', $venture->entrepreneur->phone);
                                if (str_starts_with($phone, '0')) {
                                    $phone = '593' . substr($phone, 1);
                                }
                            @endphp
                            <a href="https://wa.me/{{ $phone }}?text=Hola,%20me%20contacto%20desde%20Emprendimientos%20Sucre.%20Me%20gustar%C3%ADa%20solicitar%20m%C3%A1s%20informaci%C3%B3n%20sobre%20sus%20productos."
                                target="_blank"
                                class="h-12 px-6 rounded-xl bg-[#25D366] text-white font-bold text-sm overflow-hidden hover:shadow-xl hover:shadow-green-500/50 hover:-translate-y-1 transition-all duration-500 flex items-center justify-center gap-2 group relative">
                                <span class="relative z-10">WhatsApp</span>
                                <svg class="w-4 h-4 relative z-10 fill-current" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path
                                        d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Imagen principal --}}
                <div class="order-1 lg:order-2 relative group animate-fadeInUp stagger-2">
                    <div
                        class="relative rounded-[3rem] overflow-hidden shadow-2xl hover:shadow-cyan-500/30 transition-all duration-700 border-8 border-white/80 backdrop-blur-xl transform hover:scale-105 hover:rotate-2">
                        @if ($venture->image)
                            <img src="{{ Storage::url($venture->image) }}" alt="{{ $venture->title }}"
                                class="w-full h-full object-cover aspect-[4/3] group-hover:scale-110 transition-transform duration-1000">
                        @else
                            <div
                                class="w-full aspect-[4/3] bg-gradient-to-br from-cyan-500 via-blue-500 to-teal-500 flex items-center justify-center relative overflow-hidden">
                                <div class="absolute inset-0 shimmer-bg"></div>
                                <span
                                    class="material-icons-round text-white/60 text-9xl relative z-10 animate-float">storefront</span>
                            </div>
                        @endif
                        {{-- Capa de degradado --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-cyan-900/30 via-transparent to-blue-900/20">
                        </div>
                    </div>
                    {{-- Elementos decorativos --}}
                    <div
                        class="absolute -bottom-8 -right-8 w-40 h-40 bg-gradient-to-br from-teal-400 to-blue-500 rounded-full blur-3xl opacity-40 animate-pulse">
                    </div>
                    <div
                        class="absolute -top-8 -left-8 w-32 h-32 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-full blur-3xl opacity-30 animate-float">
                    </div>
                </div>
            </div>
        </div>


        {{-- Catálogo de productos --}}
        <div class="relative z-10 max-w-[1600px] mx-auto px-6 pb-32">
            <div
                class="flex items-end justify-between mb-16 pb-8 border-b-2 border-gradient-to-r from-transparent via-indigo-200 to-transparent">
                <div class="animate-fadeInUp">
                    <span
                        class="inline-block text-cyan-600 font-black tracking-widest uppercase text-sm mb-3 px-4 py-2 bg-cyan-100 rounded-full">Explora</span>
                    <h2 class="text-4xl lg:text-5xl font-black text-slate-900">Catálogo</h2>
                </div>
                <div
                    class="hidden md:block text-slate-500 text-base font-bold bg-white/60 backdrop-blur-xl px-6 py-3 rounded-full shadow-lg border border-white/50 animate-fadeInUp stagger-1">
                    {{ $products->count() }} productos
                </div>
            </div>

            @if ($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach ($products as $index => $product)
                        <div class="product-card group relative bg-white/70 backdrop-blur-xl rounded-[2rem] p-4 shadow-lg hover:shadow-2xl hover:shadow-cyan-500/20 hover:-translate-y-4 hover:rotate-1 transition-all duration-700 border border-white/50 animate-fadeInUp"
                            style="animation-delay: {{ $index * 0.1 }}s;">

                            {{-- Contenedor de imagen --}}
                            <div
                                class="relative aspect-square rounded-[1.5rem] overflow-hidden bg-gradient-to-br from-slate-100 to-slate-200 mb-3 cursor-pointer">
                                @if ($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->title }}"
                                        class="w-full h-full object-cover group-hover:scale-125 group-hover:rotate-3 transition-all duration-1000">
                                @else
                                    <div
                                        class="w-full h-full flex items-center justify-center bg-gradient-to-br from-slate-200 to-slate-300 relative overflow-hidden">
                                        <div class="absolute inset-0 shimmer-bg"></div>
                                        <span
                                            class="material-icons-round text-slate-400 text-6xl relative z-10 animate-float">inventory_2</span>
                                    </div>
                                @endif

                                {{-- Etiqueta de precio --}}
                                <div
                                    class="absolute top-3 right-3 bg-gradient-to-br from-white to-cyan-50 backdrop-blur-xl px-3 py-2 rounded-xl shadow-xl shadow-cyan-500/20 transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 border-2 border-white">
                                    <span
                                        class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-600 to-blue-600 font-black text-sm">${{ number_format($product->price, 2) }}</span>
                                </div>

                                {{-- Badge de categoría --}}
                                <div
                                    class="absolute bottom-3 left-3 px-4 py-2 rounded-xl bg-black/20 backdrop-blur-xl shadow-2xl border border-white/30">
                                    <span
                                        class="text-white font-black text-xs uppercase tracking-wider drop-shadow-lg">{{ $venture->category->name ?? 'General' }}</span>
                                </div>

                                {{-- Rating Badge --}}
                                @if ($product->reviews_avg_rating)
                                    <div
                                        class="absolute top-3 left-3 bg-white/90 backdrop-blur-md px-2 py-1 rounded-lg shadow-lg flex items-center gap-1 z-10">
                                        <span class="material-icons-round text-yellow-400 text-sm">star</span>
                                        <span
                                            class="text-xs font-bold text-slate-700">{{ number_format($product->reviews_avg_rating, 1) }}</span>
                                    </div>
                                @endif

                                {{-- Capa hover --}}
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-cyan-900/50 via-blue-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                </div>
                            </div>

                            {{-- Información --}}
                            <div class="px-3 pb-3 space-y-2">
                                {{-- Título del producto --}}
                                <h3
                                    class="text-lg font-black text-slate-900 leading-tight line-clamp-2 h-12 overflow-hidden">
                                    {{ $product->title }}
                                </h3>

                                {{-- Descripción --}}
                                <p
                                    class="text-slate-600 text-xs line-clamp-2 leading-relaxed font-medium h-10 overflow-hidden">
                                    {{ $product->description }}
                                </p>

                                {{-- Botón Ver Más --}}
                                {{-- Botones de Acción --}}
                                <div class="flex gap-2">
                                    <button data-product-id="{{ $product->id }}"
                                        data-product-name="{{ $product->title }}"
                                        data-product-description="{{ $product->description }}"
                                        data-product-price="{{ number_format($product->price, 2) }}"
                                        data-product-category="{{ $venture->category->name ?? 'General' }}"
                                        data-product-image="{{ $product->image ? Storage::url($product->image) : '' }}"
                                        onclick="showProductDetail(this)"
                                        class="flex-1 py-2.5 rounded-xl bg-gradient-to-r from-cyan-600 to-blue-600 text-white font-bold text-xs hover:shadow-xl hover:shadow-cyan-500/30 transition-all duration-300 hover:scale-105 flex items-center justify-center gap-2">
                                        <span>Ver Más</span>
                                        <span class="material-icons-round text-base">visibility</span>
                                    </button>

                                    <button data-product-id="{{ $product->id }}"
                                        data-product-name="{{ $product->title }}" onclick="showRatingModal(this)"
                                        class="flex-1 py-2.5 rounded-xl bg-yellow-100 text-yellow-700 font-bold text-xs hover:bg-yellow-200 hover:shadow-lg transition-all duration-300 hover:scale-105 flex items-center justify-center gap-1"
                                        title="Calificar Producto">
                                        <span class="material-icons-round text-base">star_rate</span>
                                        <span>Calificar</span>
                                    </button>
                                    
                                    <button data-product-id="{{ $product->id }}"
                                        data-product-name="{{ $product->title }}" onclick="showReviewsModal(this)"
                                        class="w-10 py-2.5 rounded-xl bg-slate-100 text-slate-600 font-bold text-xs hover:bg-slate-200 hover:shadow-lg transition-all duration-300 hover:scale-105 flex items-center justify-center"
                                        title="Ver Reseñas">
                                        <span class="material-icons-round text-base">reviews</span>
                                    </button>
                                </div>
                            </div>

                            {{-- Acento decorativo --}}
                            <div
                                class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-cyan-500/10 to-transparent rounded-bl-full opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-24">
                    {{ $products->links() }}
                </div>
            @else
                <div
                    class="flex flex-col items-center justify-center py-32 bg-white/40 backdrop-blur-xl rounded-[3rem] border-2 border-dashed border-slate-300 shadow-xl animate-fadeInUp">
                    <div
                        class="w-32 h-32 bg-gradient-to-br from-slate-100 to-slate-200 rounded-full flex items-center justify-center mb-6 animate-float">
                        <span class="material-icons-round text-7xl text-slate-400">remove_shopping_cart</span>
                    </div>
                    <p class="text-2xl font-black text-slate-500">Sin productos disponibles</p>
                </div>
            @endif
        </div>
    </div>


    {{-- Modal de contacto --}}
    <div id="contactModal" class="fixed inset-0 z-[100] hidden">
        {{-- Fondo con blur --}}
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-700 opacity-0"
            id="modalBackdrop"></div>

        {{-- Panel --}}
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-sm sm:max-w-[400px] transform scale-75 opacity-0 transition-all duration-700 relative overflow-hidden"
                id="modalPanel">

                {{-- Encabezado con degradado --}}
                <div class="relative bg-gradient-to-br from-cyan-600 via-blue-600 to-blue-700 px-5 py-6 text-center">
                    {{-- Icono --}}
                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center mx-auto mb-2 shadow-xl">
                        <span class="material-icons-round text-cyan-600 text-2xl">mail</span>
                    </div>

                    {{-- Botón cerrar --}}
                    <button onclick="closeModal()"
                        class="absolute top-4 right-4 w-10 h-10 bg-white/20 hover:bg-white/30 backdrop-blur-md rounded-full flex items-center justify-center text-white transition-all duration-300 hover:rotate-90">
                        <span class="material-icons-round text-xl">close</span>
                    </button>

                    {{-- Título --}}
                    <h3 class="text-xl font-black text-white mb-1">¡Hablemos!</h3>
                    <p class="text-white/85 text-[12px] font-medium px-4 leading-snug">
                        Envía tu interés a <strong>{{ $venture->title }}</strong>
                    </p>
                </div>

                {{-- Contenido del formulario --}}
                <div class="px-5 py-5">

                    <form action="{{ route('public.inquiry.store') }}" method="POST" class="space-y-3.5"
                        id="inquiryForm">
                        @csrf
                        <input type="hidden" name="venture_id" value="{{ $venture->id }}">

                        {{-- Campo nombre --}}
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-black text-cyan-600 uppercase tracking-wider">Tu
                                Nombre</label>
                            <input type="text" name="name" id="userName"
                                class="w-full px-4 py-2.5 bg-slate-50 border-2 border-slate-200 rounded-xl focus:bg-white focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none font-semibold text-slate-800 text-sm placeholder:text-slate-400"
                                placeholder="Ej: Juan Pérez">
                        </div>

                        {{-- Campo contacto --}}
                        <div class="space-y-1.5">
                            <label
                                class="block text-[10px] font-black text-cyan-600 uppercase tracking-wider">Contacto</label>
                            <input type="text" name="email" id="userContact"
                                class="w-full px-4 py-2.5 bg-slate-50 border-2 border-slate-200 rounded-xl focus:bg-white focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none font-semibold text-slate-800 text-sm placeholder:text-slate-400"
                                placeholder="Email o Teléfono">
                        </div>

                        {{-- Campo mensaje --}}
                        <div class="space-y-1.5">
                            <label
                                class="block text-[10px] font-black text-cyan-600 uppercase tracking-wider">Mensaje</label>
                            <textarea name="message" id="userMessage" rows="3"
                                class="w-full px-4 py-2.5 bg-slate-50 border-2 border-slate-200 rounded-xl focus:bg-white focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none font-semibold text-slate-800 text-sm placeholder:text-slate-400 resize-none"
                                placeholder="Hola, me interesa..."></textarea>
                        </div>

                        {{-- Botón enviar --}}
                        <button type="submit"
                            class="group relative w-full py-3 rounded-xl bg-gradient-to-r from-cyan-600 via-blue-600 to-blue-700 text-white font-black text-sm overflow-hidden shadow-xl hover:shadow-2xl hover:shadow-cyan-500/40 transition-all duration-500 hover:scale-[1.02]">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-blue-600 to-blue-700 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                Enviar Solicitud
                                <span
                                    class="material-icons-round text-base group-hover:translate-x-1 transition-transform">send</span>
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    {{-- Scripts --}}
    <script>
        const modal = document.getElementById('contactModal');
        const backdrop = document.getElementById('modalBackdrop');
        const panel = document.getElementById('modalPanel');

        function openModal() {
            modal.classList.remove('hidden');
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                panel.classList.remove('scale-75', 'opacity-0');
                panel.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeModal() {
            backdrop.classList.add('opacity-0');
            panel.classList.remove('scale-100', 'opacity-100');
            panel.classList.add('scale-75', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 700);
        }

        // Close on backdrop click
        backdrop.addEventListener('click', closeModal);

        // Validation with SweetAlert
        const inquiryForm = document.getElementById('inquiryForm');
        inquiryForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const name = document.getElementById('userName').value.trim();
            const contact = document.getElementById('userContact').value.trim();
            const message = document.getElementById('userMessage').value.trim();

            if (!name || !contact || !message) {
                Swal.fire({
                    icon: 'warning',
                    title: '¡Campos vacíos!',
                    text: 'Por favor, completa todos los campos para enviar tu mensaje.',
                    confirmButtonColor: '#06b6d4',
                    customClass: {
                        popup: 'rounded-3xl'
                    }
                });
                return;
            }

            // Si es válido, enviamos el formulario
            this.submit();
        });

        // --- LOGICA DE RESEÑAS ---



        // Mostrar solo Detalles del Producto
        function showProductDetail(button) {
            const product = {
                name: button.dataset.productName,
                description: button.dataset.productDescription,
                price: button.dataset.productPrice,
                category: button.dataset.productCategory,
                image: button.dataset.productImage
            };

            Swal.fire({
                html: `
                    <div class="text-left font-sans">
                        ${product.image ? `
                                        <div class="mb-6 rounded-2xl overflow-hidden shadow-xl">
                                            <img src="${product.image}" alt="${product.name}" class="w-full h-64 object-cover">
                                        </div>
                                    ` : ''}
                        
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-2xl font-black text-slate-900 mb-2">${product.name}</h3>
                                <span class="inline-block px-3 py-1 bg-gradient-to-r from-cyan-600 to-blue-600 text-white text-xs font-bold uppercase tracking-wider rounded-lg">
                                    ${product.category}
                                </span>
                            </div>
                            
                            <p class="text-slate-600 leading-relaxed text-sm">${product.description}</p>
                            
                            <div class="pt-4 border-t border-slate-200">
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-600 font-semibold">Precio:</span>
                                    <span class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-cyan-600 to-blue-600">
                                        $${product.price}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                `,
                showConfirmButton: true,
                confirmButtonText: 'Cerrar',
                confirmButtonColor: '#0f172a',
                width: '500px',
                padding: '2rem',
                customClass: {
                    popup: 'rounded-[2rem]',
                    confirmButton: 'px-8 py-3 rounded-xl font-bold text-sm'
                }
            });
        }


        // ===== REVIEW MODALS =====
        let currentProductId = null;

        // Modal para CALIFICAR producto
        function showRatingModal(button) {
            const productId = button.dataset.productId;
            const productName = button.dataset.productName;

            Swal.fire({
                title: 'Calificar Producto',
                html: `
                    <div class="text-left">
                        <p class="text-sm font-bold text-slate-700 mb-4">${productName}</p>
                        
                        <form id="ratingForm" class="space-y-4">
                            <input type="hidden" name="product_id" value="${productId}">
                            
                            <div class="flex flex-col items-center justify-center p-4 bg-slate-50 rounded-xl">
                                <div class="flex flex-row-reverse justify-center gap-2">
                                    <input type="radio" name="rating" id="star5" value="5" class="peer hidden" />
                                    <label for="star5" class="peer material-icons-round text-3xl text-slate-200 cursor-pointer hover:text-yellow-400 peer-hover:text-yellow-400 peer-checked:text-yellow-400 transition-colors">star</label>
                                    
                                    <input type="radio" name="rating" id="star4" value="4" class="peer hidden" />
                                    <label for="star4" class="peer material-icons-round text-3xl text-slate-200 cursor-pointer hover:text-yellow-400 peer-hover:text-yellow-400 peer-checked:text-yellow-400 transition-colors">star</label>
                                    
                                    <input type="radio" name="rating" id="star3" value="3" class="peer hidden" />
                                    <label for="star3" class="peer material-icons-round text-3xl text-slate-200 cursor-pointer hover:text-yellow-400 peer-hover:text-yellow-400 peer-checked:text-yellow-400 transition-colors">star</label>
                                    
                                    <input type="radio" name="rating" id="star2" value="2" class="peer hidden" />
                                    <label for="star2" class="peer material-icons-round text-3xl text-slate-200 cursor-pointer hover:text-yellow-400 peer-hover:text-yellow-400 peer-checked:text-yellow-400 transition-colors">star</label>
                                    
                                    <input type="radio" name="rating" id="star1" value="1" class="peer hidden" />
                                    <label for="star1" class="peer material-icons-round text-3xl text-slate-200 cursor-pointer hover:text-yellow-400 peer-hover:text-yellow-400 peer-checked:text-yellow-400 transition-colors">star</label>
                                </div>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-2">Selecciona una calificación</span>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <input type="text" name="name" placeholder="Tu Nombre" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 outline-none">
                                <input type="email" name="email" placeholder="Tu Email" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 outline-none">
                            </div>
                            <textarea name="review" rows="3" placeholder="Comparte tu experiencia..." class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 outline-none resize-none"></textarea>
                        </form>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Publicar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#0ea5e9',
                width: '500px',
                customClass: { popup: 'rounded-2xl' },
                preConfirm: () => {
                    const form = document.getElementById('ratingForm');
                    const formData = new FormData(form);
                    
                    if (!formData.get('rating')) {
                        Swal.showValidationMessage('Por favor selecciona una calificación');
                        return false;
                    }
                    
                    return fetch(`/products/${productId}/reviews`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(data => {
                                throw new Error(data.message || 'Error al enviar');
                            });
                        }
                        return response.json();
                    })
                    .catch(error => {
                        Swal.showValidationMessage(`${error.message}`);
                    });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Reseña Publicada!',
                        text: 'Tu opinión ha sido registrada exitosamente',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                }
            });
        }

        // Modal para VER reseñas (scrolleable, sin paginación)
        function showReviewsModal(button) {
            const productId = button.dataset.productId;
            const productName = button.dataset.productName;
            
            currentProductId = productId;


            Swal.fire({
                title: `Reseñas: ${productName}`,
                html: `
                    <div class="text-left">
                        <div id="reviewsContainer" class="space-y-3 max-h-[400px] overflow-y-auto pr-2" style="scrollbar-width: thin; scrollbar-color: #cbd5e1 #f1f5f9;">
                            <div class="flex items-center justify-center py-8">
                                <div class="w-8 h-8 border-4 border-cyan-500 border-t-transparent rounded-full animate-spin"></div>
                            </div>
                        </div>
                    </div>
                `,
                showConfirmButton: true,
                confirmButtonText: 'Cerrar',
                width: '600px',
                customClass: { popup: 'rounded-2xl' },
                didOpen: () => {
                    loadAllReviews(productId);
                }
            });
        }

        // Función para cargar TODAS las reseñas (sin paginación)
        function loadAllReviews(productId) {
            const container = document.getElementById('reviewsContainer');
            
            if (!container) return;

            fetch(`/products/${productId}/reviews?per_page=100`)
                .then(response => response.json())
                .then(data => {
                    container.innerHTML = '';

                    if (data.data.length === 0) {
                        container.innerHTML = `
                            <div class="text-center py-8 bg-slate-50 rounded-2xl border border-slate-100 border-dashed">
                                <span class="material-icons-round text-slate-300 text-4xl mb-2">rate_review</span>
                                <p class="text-slate-500 text-sm font-medium">Aún no hay reseñas para este producto.</p>
                            </div>
                        `;
                    } else {
                        data.data.forEach(review => {
                            const date = new Date(review.created_at).toLocaleDateString('es-ES', {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric'
                            });
                            let starsHtml = '';
                            for (let i = 1; i <= 5; i++) {
                                starsHtml += `<span class="material-icons-round text-sm ${i <= review.rating ? 'text-yellow-400' : 'text-slate-200'}">star</span>`;
                            }

                            container.innerHTML += `
                                <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 hover:border-cyan-100 hover:shadow-md transition-all">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-cyan-100 to-blue-100 flex items-center justify-center text-cyan-600 font-bold text-xs uppercase">
                                                ${review.name.charAt(0)}
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-slate-800 leading-none mb-1">${review.name}</p>
                                                <div class="flex items-center">${starsHtml}</div>
                                            </div>
                                        </div>
                                        <span class="text-[10px] text-slate-400 font-medium">${date}</span>
                                    </div>
                                    <p class="text-xs text-slate-600 leading-relaxed bg-slate-50 p-3 rounded-lg rounded-tl-none mt-1">"${review.review || 'Sin comentario'}"</p>
                                </div>
                            `;
                        });
                    }
                })
                .catch(err => {
                    container.innerHTML = `
                        <div class="text-center py-8 bg-red-50 rounded-2xl border border-red-100">
                            <span class="material-icons-round text-red-300 text-4xl mb-2">error_outline</span>
                            <p class="text-red-600 text-sm font-medium">Error al cargar las reseñas</p>
                        </div>
                    `;
                    console.error('Error loading reviews:', err);
                });
        }



        // Animate products on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const productCards = document.querySelectorAll('.product-card');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                    }
                });
            }, {
                threshold: 0.1
            });

            productCards.forEach(card => {
                observer.observe(card);
            });
        });
    </script>
@endsection
