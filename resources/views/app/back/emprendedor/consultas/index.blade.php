@extends('layouts.template-dash-empr')

@section('nombre-pagina', 'Consultas Recibidas')

@section('contenido-principal')
    <div class="max-w-7xl mx-auto px-4 py-8">
        
        <!-- HEADER -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-800 mb-2">
                    Consultas <span class="text-violet-600">Recibidas</span>
                </h1>
                <p class="text-slate-600">Gestiona los mensajes de clientes interesados en tus emprendimientos.</p>
            </div>

            <!-- FILTROS -->
            <div class="flex items-center bg-slate-100 p-1 rounded-2xl border border-slate-200">
                <a href="{{ route('entrepreneur.consultas.index', ['filter' => 'pending']) }}" 
                    class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all {{ $filter === 'pending' ? 'bg-white text-sky-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                    Pendientes
                </a>
                <a href="{{ route('entrepreneur.consultas.index', ['filter' => 'attended']) }}" 
                    class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all {{ $filter === 'attended' ? 'bg-white text-sky-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                    Atendidas
                </a>
            </div>
        </div>

        @if($inquiries->count() > 0)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 text-xs font-black text-slate-500 uppercase tracking-wider">Cliente</th>
                                <th class="px-6 py-4 text-xs font-black text-slate-500 uppercase tracking-wider">Emprendimiento</th>
                                <th class="px-6 py-4 text-xs font-black text-slate-500 uppercase tracking-wider">Mensaje</th>
                                <th class="px-6 py-4 text-xs font-black text-slate-500 uppercase tracking-wider">Fecha</th>
                                <th class="px-6 py-4 text-xs font-black text-slate-500 uppercase tracking-wider text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($inquiries as $inquiry)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold">
                                                {{ strtoupper(substr($inquiry->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-800">{{ $inquiry->name }}</p>
                                                <p class="text-xs text-slate-500">{{ $inquiry->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="px-3 py-1 rounded-full bg-violet-50 text-violet-700 text-xs font-bold">
                                            {{ $inquiry->venture->title }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <p class="text-sm text-slate-600 line-clamp-2 max-w-xs" title="{{ $inquiry->message }}">
                                            {{ $inquiry->message }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-5">
                                        <p class="text-xs text-slate-500">
                                            {{ $inquiry->created_at->diffForHumans() }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <button onclick="viewInquiry('{{ $inquiry->name }}', '{{ $inquiry->email }}', '{{ addslashes($inquiry->message) }}', '{{ $inquiry->venture->title }}')" 
                                                class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all" title="Ver detalle">
                                                <span class="material-icons text-lg">visibility</span>
                                            </button>

                                            <!-- BOTÓN MARCAR COMO LEÍDO/PENDIENTE -->
                                            <form action="{{ route('entrepreneur.consultas.toggle-status', $inquiry->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" 
                                                    class="p-2 rounded-lg transition-all {{ $inquiry->attended ? 'bg-amber-50 text-amber-600 hover:bg-amber-600' : 'bg-emerald-50 text-emerald-600 hover:bg-emerald-600' }} hover:text-white"
                                                    title="{{ $inquiry->attended ? 'Marcar como pendiente' : 'Marcar como atendido' }}">
                                                    <span class="material-icons text-lg">{{ $inquiry->attended ? 'undo' : 'check_circle' }}</span>
                                                </button>
                                            </form>
                                            
                                            <form action="{{ route('entrepreneur.consultas.destroy', $inquiry->id) }}" method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all" title="Eliminar">
                                                    <span class="material-icons text-lg">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                {{ $inquiries->links() }}
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-3xl border border-slate-200 border-dashed">
                <div class="w-20 h-20 bg-sky-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-icons text-sky-300 text-5xl">chat_bubble_outline</span>
                </div>
                <h3 class="text-xl font-bold text-slate-800">
                    {{ $filter === 'pending' ? 'No tienes consultas pendientes' : 'No tienes consultas atendidas' }}
                </h3>
                <p class="text-slate-500 mt-2 max-w-md mx-auto">
                    {{ $filter === 'pending' 
                        ? 'Cuando un cliente se interese en tus productos sus mensajes aparecerán aquí como pendientes.' 
                        : 'Aquí aparecerán las consultas que ya hayas marcado como atendidas.' }}
                </p>
                @if($filter === 'attended')
                    <a href="{{ route('entrepreneur.consultas.index', ['filter' => 'pending']) }}" class="mt-6 inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-sky-500 to-indigo-600 text-white rounded-2xl font-bold hover:opacity-90 transition-all shadow-md shadow-sky-200">
                        Ver pendientes
                    </a>
                @endif
            </div>
        @endif

    </div>
@endsection

@section('scrip-final')
    <script>
        function viewInquiry(name, contact, message, venture) {
            Swal.fire({
                title: `<span class="text-xl font-black text-slate-800">Detalle de Consulta</span>`,
                html: `
                    <div class="text-left mt-4 space-y-4">
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <p class="text-xs font-black text-indigo-600 uppercase tracking-widest mb-1">Cliente</p>
                            <p class="font-bold text-slate-800">${name}</p>
                            <p class="text-sm text-slate-500">${contact}</p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <p class="text-xs font-black text-indigo-600 uppercase tracking-widest mb-1">Interés en</p>
                            <p class="font-bold text-slate-800">${venture}</p>
                        </div>
                        <div class="p-4 bg-white rounded-2xl border border-slate-200">
                            <p class="text-xs font-black text-indigo-600 uppercase tracking-widest mb-1">Mensaje</p>
                            <p class="text-slate-600 whitespace-pre-line text-sm leading-relaxed">${message}</p>
                        </div>
                    </div>
                `,
                confirmButtonText: 'Cerrar',
                confirmButtonColor: '#4f46e5',
                customClass: {
                    popup: 'rounded-3xl'
                }
            });
        }

        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Eliminar consulta?',
                    text: "Esta acción no se puede deshacer.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    customClass: { popup: 'rounded-2xl' }
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>
@endsection
