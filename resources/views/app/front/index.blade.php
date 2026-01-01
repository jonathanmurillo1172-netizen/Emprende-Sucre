@extends('layouts.template-home')
{{-- link css --}}
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/home/css/estilo-index.css') }}">
@endsection
{{-- seccion principal --}}
@section('content')
    <section class="relative overflow-hidden bg-white pt-20 lg:pt-32 pb-16 lg:pb-32 px-6">
        <!-- FORMAS DIAGONALES DE FONDO (Desktop Only) -->
        <div class="hero-diagonal-container absolute inset-0 pointer-events-none hidden lg:block">
            <div class="diagonal-shape shape-cyan"></div>
            <div class="diagonal-shape shape-blue"></div>
            <div class="diagonal-shape shape-mint"></div>
        </div>

        <div class="relative max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                
                <!-- COLUMNA IZQUIERDA: CONTENIDO -->
                <div class="space-y-8 lg:space-y-12 relative z-10 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-slate-50 rounded-full border border-slate-100 shadow-sm animate-fade">
                        <span class="w-2 h-2 rounded-full bg-cyan-500 animate-pulse"></span>
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Emprendimientos Sucre</span>
                    </div>

                    <h1 class="text-6xl sm:text-7xl md:text-8xl lg:text-[110px] xl:text-[130px] font-black tracking-tighter text-slate-900 leading-[0.8] animate-fade">
                        EMPRENDE<br>
                        <span id="typewriter" class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-600 to-blue-700">
                            SUCRE
                        </span>
                    </h1>

                    <p class="max-w-xl mx-auto lg:mx-0 text-xl md:text-2xl text-slate-500 font-medium leading-relaxed animate-fade delay-200">
                        La plataforma donde el talento local se encuentra con grandes oportunidades. Descubre y apoya lo nuestro.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center gap-8 pt-4 animate-fade delay-400">
                        <a href="#emprendimientos" class="group relative px-12 py-6 rounded-2xl font-black text-xs uppercase tracking-[0.25em] text-white overflow-hidden shadow-2xl shadow-cyan-500/30 transition-all duration-500 hover:scale-105 active:scale-95">
                            <span class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-blue-600"></span>
                            <span class="relative z-10">Explorar Más</span>
                        </a>
                    </div>

                    <!-- SIGNOS DECORATIVOS -->
                    <div class="absolute -top-10 -left-10 text-slate-100 hidden xl:block animate-float">
                        <span class="material-icons-round text-6xl">add</span>
                    </div>
                </div>

                <!-- COLUMNA DERECHA: COMPOSICIÓN VISUAL -->
                <div class="relative animate-fade delay-200">
                    <!-- IMAGEN PRINCIPAL (Empresaria) -->
                    <div class="relative z-0 rounded-[4rem] overflow-hidden shadow-[0_60px_120px_-30px_rgba(0,0,0,0.2)] aspect-[4/5] lg:aspect-[3.5/4.5] lg:h-[650px] border-[12px] border-white hero-main-img">
                        <img src="{{ asset('img/portda.avif') }}" 
                             alt="Business Leader" 
                             class="w-full h-full object-cover grayscale-[0.1] hover:grayscale-0 transition-all duration-1000">
                        
                        <!-- OVERLAY DE COLOR -->
                        <div class="absolute inset-0 bg-gradient-to-tr from-cyan-500/20 to-transparent mix-blend-overlay"></div>
                    </div>

                    <!-- CÍRCULO SUPERPUESTO 1 (Equipo) -->
                    <div class="absolute -left-16 lg:-left-24 top-1/2 w-48 h-48 lg:w-64 lg:h-64 rounded-full overflow-hidden circle-img-overlay z-20 animate-float">
                         <img src="{{ asset('img/foto circular.avif') }}" 
                              alt="Collaboration Team" 
                              class="w-full h-full object-cover">
                    </div>

                    <!-- CÍRCULO SUPERPUESTO 2 (Decorativo/Placeholder) -->
                    <div class="absolute -right-8 lg:-right-12 top-12 w-32 h-32 lg:w-48 lg:h-48 rounded-full overflow-hidden circle-img-overlay z-10 animate-float-slow">
                        <div class="w-full h-full bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center p-6 text-center">
                            <span class="text-white text-[10px] font-black uppercase tracking-[0.2em] leading-tight">Gestión Creativa</span>
                        </div>
                    </div>

                    <!-- SIGNOS DECORATIVOS PLUS -->
                    <div class="absolute top-1/2 -right-10 text-cyan-400 animate-pulse">
                        <span class="material-icons-round text-5xl">add</span>
                    </div>
                    <div class="absolute bottom-10 -left-5 text-emerald-400 animate-float-slow">
                        <span class="material-icons-round text-4xl">add</span>
                    </div>
                </div>

            </div>
        </div>
    </section>




    {{-- CUADRÍCULA DE EMPRENDIMIENTOS --}}
    <section class="py-20 px-6 bg-white" id="emprendimientos">
        <div class="max-w-7xl mx-auto">
            {{-- Encabezado de Sección con Búsqueda --}}
            <div class="text-center mb-8">
                <span
                    class="inline-block px-4 py-2 bg-cyan-100 text-cyan-700 rounded-full text-sm font-bold uppercase tracking-wide mb-4">
                    Explora
                </span>
                <h2 class="text-4xl md:text-5xl font-black text-slate-900 mb-4">
                    Emprendimientos Destacados
                </h2>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto mb-6">
                    Conoce los proyectos más innovadores de nuestra comunidad
                </p>

                {{-- Barra de Búsqueda --}}
                <div class="max-w-4xl mx-auto">
                    <div class="bg-white rounded-2xl shadow-xl shadow-slate-900/5 p-1.5 border border-slate-200/50">
                        @include('partials.home.busquedas-home')
                    </div>
                </div>
            </div>

            <div id="ventures-container">
                @if ($ventures->count() > 0)
                    {{-- Cuadrícula de Emprendimientos --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
                        @foreach ($ventures as $index => $venture)
                            <div class="venture-card group relative flex flex-col h-full rounded-[2rem] bg-white/55 backdrop-blur-2xl border border-white/40 shadow-[0_30px_60px_-25px_rgba(15,23,42,0.35)] hover:shadow-[0_50px_100px_-30px_rgba(99,102,241,0.55)] transition-all duration-[800ms] ease-[cubic-bezier(.19,1,.22,1)] hover:-translate-y-4 animate-fadeInUp"
                                style="animation-delay: {{ $index * 0.05 }}s;">

                                {{-- HALO LUMINOSO --}}
                                <div
                                    class="pointer-events-none absolute -inset-1 rounded-[2.2rem] opacity-0 group-hover:opacity-100 transition duration-700 bg-gradient-to-br from-cyan-500/25 via-blue-500/10 to-teal-500/20 blur-2xl">
                                </div>

                                {{-- CAPA PROFUNDA --}}
                                <div
                                    class="pointer-events-none absolute inset-0 rounded-[2rem] bg-gradient-to-br from-white/40 to-white/5 opacity-70">
                                </div>

                                {{-- IMAGEN --}}
                                <div class="relative h-56 overflow-hidden rounded-t-[2rem] bg-slate-100">
                                    @if ($venture->image)
                                        <img src="{{ Storage::url($venture->image) }}" alt="{{ $venture->title }}"
                                            class="w-full h-full object-cover scale-100 group-hover:scale-[1.15] transition-transform duration-[1400ms] ease-out">
                                    @else
                                        <div
                                            class="w-full h-full flex items-center justify-center bg-gradient-to-br from-cyan-500/15 via-blue-500/10 to-teal-500/15">
                                            <span class="material-icons-round text-cyan-400 text-7xl">storefront</span>
                                        </div>
                                    @endif

                                    {{-- OVERLAY CINEMÁTICO --}}
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-slate-900/70 via-slate-900/20 to-transparent opacity-70 group-hover:opacity-95 transition duration-500">
                                    </div>

                                    {{-- CATEGORÍA --}}
                                    <div class="absolute top-4 left-4">
                                        <span
                                            class="px-4 py-1.5 rounded-full bg-white/90 backdrop-blur-xl text-[10px] font-black uppercase tracking-[0.2em] text-cyan-600 border border-white/60 shadow-md">
                                            {{ $venture->category->name ?? 'General' }}
                                        </span>
                                    </div>

                                    {{-- CREADOR --}}
                                    <div
                                        class="absolute bottom-6 left-6 flex items-center gap-3 opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-500">
                                        <div
                                            class="w-12 h-12 rounded-full bg-white flex items-center justify-center border-2 border-white shadow-xl">
                                            <span
                                                class="text-sm font-black text-transparent bg-clip-text bg-gradient-to-br from-cyan-600 to-blue-700">
                                                {{ substr($venture->entrepreneur->user->name ?? 'A', 0, 1) }}
                                            </span>
                                        </div>

                                        <div class="px-4 py-2 rounded-full bg-white/95 backdrop-blur-xl shadow-xl">
                                            <span class="text-xs font-bold text-slate-800">
                                                {{ $venture->entrepreneur->user->name ?? 'Emprendedor' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- CONTENIDO --}}
                                <div class="relative z-10 p-7 flex-1 flex flex-col space-y-4">
                                    <h3
                                        class="text-[17px] font-black leading-tight tracking-tight text-slate-900 line-clamp-2 h-11 group-hover:text-cyan-600 transition-colors duration-300">
                                        {{ $venture->title }}
                                    </h3>

                                    <p class="text-slate-500 text-[13px] leading-relaxed font-medium line-clamp-2 h-10">
                                        {{ $venture->description }}
                                    </p>

                                    {{-- DIVISOR PREMIUM --}}
                                    <div
                                        class="h-px w-12 bg-gradient-to-r from-cyan-400 via-blue-400 to-teal-400 opacity-40 group-hover:w-full transition-all duration-500">
                                    </div>

                                    {{-- BOTÓN MAGNÉTICO --}}
                                    <a href="{{ route('public.venture.products', $venture->id) }}"
                                        class="group/btn relative mt-auto flex items-center justify-between px-6 py-4 rounded-2xl bg-white/85 backdrop-blur-xl border border-white/60 font-black text-[11px] uppercase tracking-[0.18em] text-slate-900 shadow-[0_15px_30px_-15px_rgba(0,0,0,0.3)] hover:shadow-[0_25px_50px_-20px_rgba(34,211,238,0.6)] transition-all duration-500 overflow-hidden">
                                        <span
                                            class="absolute inset-0 bg-gradient-to-r from-cyan-600 via-blue-600 to-teal-600 opacity-0 group-hover/btn:opacity-100 transition duration-500"></span>
                                        <span class="relative z-10 group-hover/btn:text-white transition">
                                            Explorar
                                        </span>
                                        <span
                                            class="material-icons-round relative z-10 text-base group-hover/btn:text-white group-hover/btn:translate-x-1 transition">
                                            arrow_forward
                                        </span>
                                    </a>
                                </div>

                                {{-- ESQUINA DECORATIVA --}}
                                <div
                                    class="absolute top-0 right-0 w-28 h-28 rounded-bl-full bg-gradient-to-br from-cyan-500/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-500">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Paginación --}}
                    <div class="mt-16 flex justify-center">
                        {{ $ventures->links() }}
                    </div>
                @else
                    {{-- Estado Vacío --}}
                    <div class="text-center py-20">
                        <div class="w-32 h-32 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <span class="material-icons-round text-slate-400 text-6xl">travel_explore</span>
                        </div>
                        <h3 class="text-3xl font-bold text-slate-800 mb-3">Aún no hay emprendimientos</h3>
                        <p class="text-slate-500 text-lg">
                            Estamos preparando nuevos proyectos. Vuelve pronto.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- Script de Animación al Hacer Scroll --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ventureCards = document.querySelectorAll('.venture-card');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                    }
                });
            }, {
                threshold: 0.1
            });

            ventureCards.forEach(card => {
                observer.observe(card);
            });
        });
    </script>
@endsection

@section('scripts')
    <script src="{{ asset('assets/home/js/script-hero.js') }}"></script>
@endsection
