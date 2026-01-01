@extends('layouts.template-dash-empr')

@section('contenido-principal')
    <div class="max-w-7xl mx-auto px-4 py-8 space-y-10">


        <script>
            function requestActivation() {
                Swal.fire({
                    title: '¿Solicitar Activación?',
                    text: "Se notificará al administrador para revisar tu cuenta.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Sí, solicitar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('{{ route("entrepreneur.request.activation") }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if(data.success) {
                                Swal.fire(
                                    '¡Solicitud Enviada!',
                                    data.message,
                                    'success'
                                ).then(() => {
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
                })
            }
        </script>

        <!-- HEADER -->
        <div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">
                Estadísticas
            </h2>
            <p class="text-slate-500 mt-1">
                Resumen del rendimiento y actividad de tus emprendimientos.
            </p>
        </div>

        <!-- TARJETAS RESUMEN -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- TOTAL EMPRENDIMIENTOS -->
            <a href="{{ route('entrepreneur.emprendimientos.index') }}"
                class="relative overflow-hidden rounded-2xl p-6 text-white
                   bg-gradient-to-br from-sky-400 to-indigo-600 shadow-lg transition-transform hover:scale-105">
                <p class="text-sm opacity-90">Mis Emprendimientos</p>
                <p class="mt-2 text-4xl font-black">{{ $venturesCount }}</p>
                <span class="absolute right-4 bottom-4 opacity-20 text-6xl">🏪</span>
            </a>

            <!-- PENDIENTES -->
            <a href="{{ route('entrepreneur.emprendimientos.index') }}"
                class="relative overflow-hidden rounded-2xl p-6 text-white
                   bg-gradient-to-br from-slate-400 to-slate-600 shadow-lg transition-transform hover:scale-105">
                <p class="text-sm opacity-90">Pendientes de Aprobación</p>
                <p class="mt-2 text-4xl font-black">{{ $pendingVenturesCount }}</p>
                <span class="absolute right-4 bottom-4 opacity-20 text-6xl">⏳</span>
            </a>

            <!-- CONSULTAS -->
            <a href="{{ route('entrepreneur.consultas.index') }}"
                class="relative overflow-hidden rounded-2xl p-6 text-white
                   bg-gradient-to-br from-indigo-500 to-sky-600 shadow-lg transition-transform hover:scale-105">
                <p class="text-sm opacity-90">Consultas Recibidas</p>
                <p class="mt-2 text-4xl font-black">{{ $inquiriesCount }}</p>
                <span class="absolute right-4 bottom-4 opacity-20 text-6xl">💬</span>
            </a>

            <!-- VISITAS -->
            <div
                class="relative overflow-hidden rounded-2xl p-6 text-white
                   bg-gradient-to-br from-cyan-500 to-sky-700 shadow-lg transition-transform hover:scale-105">
                <p class="text-sm opacity-90">Visitas Totales</p>
                <p class="mt-2 text-4xl font-black">{{ $visitsCount }}</p>
                <span class="absolute right-4 bottom-4 opacity-20 text-6xl">👁️</span>
            </div>

        </div>

        @if(Auth::user()->entrepreneur && Auth::user()->entrepreneur->status === 'inactive')
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <span class="material-icons text-red-500 text-2xl">error_outline</span>
                    </div>
                    <div class="ml-3 w-full">
                        <h3 class="text-sm font-bold text-red-800">
                            Cuenta Inactiva
                        </h3>
                        <div class="mt-1 text-sm text-red-700">
                            Tu cuenta de emprendedor está actualmente inactiva. Tus emprendimientos no serán visibles para el público.
                        </div>
                        
                        <div class="mt-4">
                            @if(Auth::user()->entrepreneur->activation_requested_at)
                                <div class="inline-flex items-center gap-2 px-4 py-2 bg-red-100 text-red-700 rounded-lg text-sm font-bold">
                                    <span class="material-icons text-sm">schedule</span>
                                    Solicitud de activación enviada. Esperando aprobación.
                                </div>
                            @else
                                <button onclick="requestActivation()" 
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition shadow-md shadow-red-500/30 text-sm font-bold">
                                    <span class="material-icons text-sm">notifications_active</span>
                                    Solicitar Activación
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- GRÁFICAS -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-10">

            <!-- VISITAS POR EMPRENDIMIENTO -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                <h3 class="text-lg font-bold text-slate-800 mb-4">
                    Visitas por Emprendimiento
                </h3>

                <div class="relative h-72">
                    <canvas id="visitasEmprendimientos"></canvas>
                </div>
            </div>

            <!-- ESTADO DE EMPRENDIMIENTOS -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                <h3 class="text-lg font-bold text-slate-800 mb-4">
                    Estado de Mis Emprendimientos
                </h3>

                <div class="relative h-72 flex items-center justify-center">
                    <canvas id="estadoEmprendimientos"></canvas>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Lógica de Gráfica de Visitas
            const ctxVisitas = document.getElementById('visitasEmprendimientos').getContext('2d');
            new Chart(ctxVisitas, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($ventureVisits->pluck('label')) !!},
                    datasets: [{
                        label: 'Visitas',
                        data: {!! json_encode($ventureVisits->pluck('count')) !!},
                        backgroundColor: 'rgba(56, 189, 248, 0.2)', // sky-400
                        borderColor: 'rgba(56, 189, 248, 1)',
                        borderWidth: 2,
                        borderRadius: 8,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true, grid: { display: false } },
                        x: { grid: { display: false } }
                    },
                    plugins: { legend: { display: false } }
                }
            });

            // Lógica de Gráfica de Estados
            const ctxEstados = document.getElementById('estadoEmprendimientos').getContext('2d');
            new Chart(ctxEstados, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode(array_keys($states)) !!},
                    datasets: [{
                        data: {!! json_encode(array_values($states)) !!},
                        backgroundColor: [
                            '#0ea5e9', // Activos (Sky-500)
                            '#94a3b8', // Pendientes (Slate-400)
                            '#475569'  // Desactivados (Slate-600)
                        ],
                        borderWidth: 0,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' }
                    },
                    cutout: '70%'
                }
            });
        });
    </script>
@endsection

@section('scrip-final')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/admin/js/alerta-logout-admin.js') }}"></script>
    @if (session('swal_success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Operación Exitosa!',
                text: "{{ session('swal_success') }}",
                showConfirmButton: false,
                timer: 2500,
                toast: true,
                position: 'top-end'
            });
        </script>
    @endif
    @if (session('swal_login'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Bienvenido!',
                text: "{{ session('swal_login') }}",
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#4f46e5'
            });
        </script>
    @endif
@endsection
