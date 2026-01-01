@extends('layouts.template-back')

@section('titulo', 'Dashboard Administrador')

@section('contenido-principal')
    <div class="max-w-7xl mx-auto px-6 py-8 space-y-8">

        <!-- HEADER DASHBOARD -->

        <!-- HEADER DASHBOARD -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">Dashboard Administrador</h1>
                <p class="text-slate-500 mt-2 text-lg">Resumen general de la plataforma.</p>
            </div>
            <div class="hidden md:block">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-50 text-indigo-700 text-sm font-bold">
                    <span class="relative flex h-3 w-3">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-500"></span>
                    </span>
                    Sistema Activo
                </span>
            </div>
        </div>

        <!-- TARJETAS ESTADÍSTICAS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- Total Usuarios -->
            <a href="{{ route('admin.usuarios.index') }}" class="relative overflow-hidden rounded-2xl p-5 bg-gradient-to-br from-blue-600 via-blue-500 to-cyan-400 shadow-lg shadow-blue-200/50 hover:shadow-xl hover:shadow-blue-300/50 hover:-translate-y-1 transition-all duration-300 group block">
                <!-- Efectos de Fondo -->
                <div class="absolute top-0 right-0 -mr-6 -mt-6 w-32 h-32 rounded-full bg-white/10 blur-xl group-hover:scale-125 transition-transform duration-500"></div>
                <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-24 h-24 rounded-full bg-black/10 blur-xl"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/5 to-transparent"></div>
                
                <div class="relative z-10 flex flex-col h-full justify-between gap-4">
                    <div class="flex items-center justify-between">
                        <div class="p-3 bg-white/20 backdrop-blur-md rounded-xl border border-white/10 shadow-inner">
                            <span class="material-icons text-white text-2xl">people</span>
                        </div>
                        <span class="material-icons text-white/50 text-2xl group-hover:text-white transition-colors">arrow_forward</span>
                    </div>
                    <div>
                        <p class="text-blue-50 text-xs font-bold uppercase tracking-wider mb-1 opacity-90">Total Usuarios</p>
                        <h3 class="text-3xl font-black text-white tracking-tight drop-shadow-sm">{{ $totalUsers }}</h3>
                    </div>
                </div>
            </a>

            <!-- Emprendimientos Aprobados -->
            <a href="{{ route('admin.emprendimientos.index') }}" class="relative overflow-hidden rounded-2xl p-5 bg-gradient-to-br from-indigo-600 via-violet-600 to-purple-500 shadow-lg shadow-indigo-200/50 hover:shadow-xl hover:shadow-indigo-300/50 hover:-translate-y-1 transition-all duration-300 group block">
                <!-- Efectos de Fondo -->
                <div class="absolute top-0 right-0 -mr-6 -mt-6 w-32 h-32 rounded-full bg-white/10 blur-xl group-hover:scale-125 transition-transform duration-500"></div>
                <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-24 h-24 rounded-full bg-black/10 blur-xl"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/5 to-transparent"></div>

                <div class="relative z-10 flex flex-col h-full justify-between gap-4">
                    <div class="flex items-center justify-between">
                        <div class="p-3 bg-white/20 backdrop-blur-md rounded-xl border border-white/10 shadow-inner">
                             <span class="material-icons text-white text-2xl">verified</span>
                        </div>
                        <span class="material-icons text-white/50 text-2xl group-hover:text-white transition-colors">arrow_forward</span>
                    </div>
                    <div>
                        <p class="text-indigo-50 text-xs font-bold uppercase tracking-wider mb-1 opacity-90">Aprobados</p>
                        <h3 class="text-3xl font-black text-white tracking-tight drop-shadow-sm">{{ $approvedVentures }}</h3>
                    </div>
                </div>
            </a>

            <!-- Pendientes -->
            <a href="{{ route('admin.validar.index') }}" class="relative overflow-hidden rounded-2xl p-5 bg-gradient-to-br from-amber-500 via-orange-500 to-red-400 shadow-lg shadow-orange-200/50 hover:shadow-xl hover:shadow-orange-300/50 hover:-translate-y-1 transition-all duration-300 group block">
                <!-- Efectos de Fondo -->
                <div class="absolute top-0 right-0 -mr-6 -mt-6 w-32 h-32 rounded-full bg-white/10 blur-xl group-hover:scale-125 transition-transform duration-500"></div>
                <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-24 h-24 rounded-full bg-black/10 blur-xl"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/5 to-transparent"></div>

                <div class="relative z-10 flex flex-col h-full justify-between gap-4">
                    <div class="flex items-center justify-between">
                        <div class="p-3 bg-white/20 backdrop-blur-md rounded-xl border border-white/10 shadow-inner">
                            <span class="material-icons text-white text-2xl">hourglass_top</span>
                        </div>
                        <span class="material-icons text-white/50 text-2xl group-hover:text-white transition-colors">arrow_forward</span>
                    </div>
                    <div>
                        <div class="flex items-center justify-between">
                            <p class="text-amber-50 text-xs font-bold uppercase tracking-wider mb-1 opacity-90">Pendientes</p>
                             @if($pendingVentures > 0)
                                <span class="bg-white/20 px-2 py-0.5 rounded text-[10px] font-bold text-white mb-1 animate-pulse">ACCIÓN</span>
                            @endif
                        </div>
                        <h3 class="text-3xl font-black text-white tracking-tight drop-shadow-sm">{{ $pendingVentures }}</h3>
                    </div>
                </div>
            </a>

            <!-- Categorías -->
            <a href="{{ route('admin.categoria.index') }}" class="relative overflow-hidden rounded-2xl p-5 bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-500 shadow-lg shadow-teal-200/50 hover:shadow-xl hover:shadow-teal-300/50 hover:-translate-y-1 transition-all duration-300 group block">
                <!-- Efectos de Fondo -->
                <div class="absolute top-0 right-0 -mr-6 -mt-6 w-32 h-32 rounded-full bg-white/10 blur-xl group-hover:scale-125 transition-transform duration-500"></div>
                <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-24 h-24 rounded-full bg-black/10 blur-xl"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/5 to-transparent"></div>

                <div class="relative z-10 flex flex-col h-full justify-between gap-4">
                    <div class="flex items-center justify-between">
                        <div class="p-3 bg-white/20 backdrop-blur-md rounded-xl border border-white/10 shadow-inner">
                             <span class="material-icons text-white text-2xl">category</span>
                        </div>
                        <span class="material-icons text-white/50 text-2xl group-hover:text-white transition-colors">arrow_forward</span>
                    </div>
                    <div>
                        <p class="text-teal-50 text-xs font-bold uppercase tracking-wider mb-1 opacity-90">Categorías</p>
                        <h3 class="text-3xl font-black text-white tracking-tight drop-shadow-sm">{{ $categoriesCount }}</h3>
                    </div>
                </div>
            </a>

        </div>

        @if(isset($pendingEntrepreneurs) && $pendingEntrepreneurs->count() > 0)
            <div class="bg-orange-50 border border-orange-200 rounded-2xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-orange-100 rounded-lg text-orange-600">
                            <span class="material-icons">notifications_active</span>
                        </div>
                        <h3 class="text-lg font-bold text-orange-900">Solicitudes de Activación Pendientes</h3>
                    </div>
                    <span class="px-3 py-1 bg-orange-200 text-orange-800 rounded-full text-xs font-bold">{{ $pendingEntrepreneurs->count() }} Pendientes</span>
                </div>

                <div class="space-y-3">
                    @foreach($pendingEntrepreneurs as $entrepreneur)
                        <div class="bg-white p-4 rounded-xl border border-orange-100 flex flex-col md:flex-row items-center justify-between gap-4" id="request-{{ $entrepreneur->id }}">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-500">
                                    {{ strtoupper(substr($entrepreneur->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800">{{ $entrepreneur->user->name }}</p>
                                    <p class="text-sm text-slate-500">{{ $entrepreneur->description ?? 'Sin descripción' }}</p>
                                    <p class="text-xs text-orange-500 mt-1">Solicitado: {{ \Carbon\Carbon::parse($entrepreneur->activation_requested_at)->diffForHumans() }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-2">
                                <button onclick="approveRequest({{ $entrepreneur->id }}, '{{ $entrepreneur->user->name }}')" 
                                    class="px-4 py-2 bg-emerald-100 text-emerald-700 hover:bg-emerald-200 rounded-lg text-sm font-bold transition flex items-center gap-2">
                                    <span class="material-icons text-base">check</span> Aprobar
                                </button>
                                <button onclick="rejectRequest({{ $entrepreneur->id }}, '{{ $entrepreneur->user->name }}')"
                                    class="px-4 py-2 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-sm font-bold transition flex items-center gap-2">
                                    <span class="material-icons text-base">close</span> Rechazar
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <script>
                function approveRequest(id, name) {
                    Swal.fire({
                        title: '¿Aprobar Cuenta?',
                        text: `Se activará la cuenta de ${name} y sus emprendimientos serán visibles.`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#10B981',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Sí, aprobar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            sendRequest(`{{ url('/admin/entrepreneurs') }}/${id}/approve`);
                        }
                    })
                }

                function rejectRequest(id, name) {
                    Swal.fire({
                        title: '¿Rechazar Solicitud?',
                        text: `La cuenta de ${name} permanecerá inactiva.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Sí, rechazar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            sendRequest(`{{ url('/admin/entrepreneurs') }}/${id}/reject`);
                        }
                    })
                }

                function sendRequest(url) {
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            Swal.fire('¡Éxito!', data.message, 'success').then(() => {
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
            </script>
        @endif

        <!-- GRÁFICOS -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- Emprendimientos por Categoría -->
            <div class="bg-white rounded-[2.5rem] p-8 shadow-2xl shadow-slate-200/60 border border-slate-100/60 relative overflow-hidden group hover:shadow-slate-300/60 transition-all duration-500">
                <div class="absolute top-0 right-0 w-40 h-40 bg-indigo-50/80 rounded-bl-[5rem] -mr-10 -mt-10 pointer-events-none transition-transform group-hover:scale-110 duration-700"></div>
                
                <div class="flex items-center justify-between mb-10 relative z-10">
                    <div>
                        <h2 class="text-2xl font-black text-slate-800 tracking-tight">Por Categoría</h2>
                        <p class="text-slate-400 text-sm font-semibold">Distribución global</p>
                    </div>
                     <div class="p-3 bg-indigo-50 rounded-2xl text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                        <span class="material-icons">bar_chart</span>
                    </div>
                </div>
                <div class="relative h-80 w-full">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>

            <!-- Estado de Emprendimientos -->
            <div class="bg-white rounded-[2.5rem] p-8 shadow-2xl shadow-slate-200/60 border border-slate-100/60 relative overflow-hidden group hover:shadow-slate-300/60 transition-all duration-500">
                <div class="absolute top-0 right-0 w-40 h-40 bg-sky-50/80 rounded-bl-[5rem] -mr-10 -mt-10 pointer-events-none transition-transform group-hover:scale-110 duration-700"></div>

                <div class="flex items-center justify-between mb-10 relative z-10">
                     <div>
                        <h2 class="text-2xl font-black text-slate-800 tracking-tight">Estado Actual</h2>
                        <p class="text-slate-400 text-sm font-semibold">Métricas de validación</p>
                    </div>
                    <div class="p-3 bg-sky-50 rounded-2xl text-sky-600 group-hover:bg-sky-600 group-hover:text-white transition-colors duration-300">
                        <span class="material-icons">donut_large</span>
                    </div>
                </div>
                <div class="relative h-80 w-full flex justify-center">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>

        </div>

    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // CONFIGURACIÓN COMÚN
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.color = '#64748b';

        // DATOS DESDE CONTROLLER
        const categories = @json($venturesByCategory->pluck('name'));
        const categoryData = @json($venturesByCategory->pluck('count'));
        const categoryColors = @json($venturesByCategory->pluck('color'));

        const approvedCount = {{ $approvedVentures }};
        const pendingCount = {{ $pendingVentures }};

        // Gráfico de Barras
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'bar',
            data: {
                labels: categories,
                datasets: [{
                    label: 'Emprendimientos',
                    data: categoryData,
                    backgroundColor: categoryColors,
                    borderRadius: 8,
                    barThickness: 30
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [2, 4], color: '#f1f5f9' },
                        ticks: { stepSize: 1 }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });

        // Gráfico Donut
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Aprobados', 'Pendientes'],
                datasets: [{
                    data: [approvedCount, pendingCount],
                    backgroundColor: ['#10B981', '#F59E0B'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: { weight: 'bold' }
                        }
                    }
                }
            }
        });
    </script>
@endsection
