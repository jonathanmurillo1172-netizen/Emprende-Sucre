@extends('layouts.template-dash-empr')

@section('nombre-pagina', 'Reseñas de Productos')

@section('contenido-principal')
<div class="max-w-7xl mx-auto px-4 py-8">
    
    {{-- Header --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 mb-2">
                Reseñas de <span class="text-violet-600">Productos</span>
            </h1>
            <p class="text-slate-600">Gestiona y modera las opiniones de tus clientes.</p>
        </div>
    </div>

    {{-- Alert Success --}}
    @if(session('swal_success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Operación Exitosa!',
                    text: '{{ session('swal_success') }}',
                    confirmButtonColor: '#06b6d4',
                    customClass: { popup: 'rounded-3xl' }
                });
            });
        </script>
    @endif

    {{-- Reviews Table --}}
    @if($reviews->count() > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-xs font-black text-slate-500 uppercase tracking-wider">Producto</th>
                            <th class="px-6 py-4 text-xs font-black text-slate-500 uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-4 text-xs font-black text-slate-500 uppercase tracking-wider">Calificación</th>
                            <th class="px-6 py-4 text-xs font-black text-slate-500 uppercase tracking-wider w-1/3">Comentario</th>
                            <th class="px-6 py-4 text-xs font-black text-slate-500 uppercase tracking-wider text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($reviews as $review)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-indigo-50 overflow-hidden flex-shrink-0 border border-indigo-100">
                                        @if($review->product->image)
                                            <img src="{{ Storage::url($review->product->image) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="flex items-center justify-center h-full text-indigo-300">
                                                <span class="material-icons-round text-sm">inventory_2</span>
                                            </div>
                                        @endif
                                    </div>
                                    <span class="text-sm font-bold text-slate-700">{{ Str::limit($review->product->title, 20) }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div>
                                    <p class="font-bold text-slate-800">{{ $review->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $review->email }}</p>
                                    <p class="text-[10px] text-slate-400 mt-1">{{ $review->created_at->diffForHumans() }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex text-amber-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="material-icons-round text-lg">
                                            {{ $i <= $review->rating ? 'star' : 'star_border' }}
                                        </span>
                                    @endfor
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                @php
                                    $comment = $review->review ?? 'Sin comentario';
                                    $maxLength = 80;
                                    $isTruncated = strlen($comment) > $maxLength;
                                    $displayComment = $isTruncated ? substr($comment, 0, $maxLength) . '...' : $comment;
                                @endphp
                                <p class="text-sm text-slate-600 leading-relaxed italic">
                                    "{{ $displayComment }}"
                                </p>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if(strlen($review->review ?? '') > 80)
                                    <button onclick="viewFullComment(`{{ addslashes($review->review) }}`)" 
                                        class="p-2 rounded-lg bg-sky-50 text-sky-600 hover:bg-sky-600 hover:text-white transition-all" 
                                        title="Ver comentario completo">
                                        <span class="material-icons-round text-lg">visibility</span>
                                    </button>
                                    @endif
                                    <form action="{{ route('entrepreneur.reviews.destroy', $review->id) }}" method="POST" class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all" title="Eliminar Reseña">
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
            {{ $reviews->links() }}
        </div>
    @else
        {{-- Empty State --}}
        <div class="text-center py-20 bg-white rounded-3xl border border-slate-200 border-dashed">
            <div class="w-20 h-20 bg-sky-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <span class="material-icons text-sky-300 text-5xl">rate_review</span>
            </div>
            <h3 class="text-xl font-bold text-slate-800">No tienes reseñas aún</h3>
            <p class="text-slate-500 mt-2 max-w-md mx-auto">
                Las opiniones de tus clientes sobre tus productos aparecerán aquí.
            </p>
        </div>
    @endif
</div>
@endsection

@section('scrip-final')
<script>
    // View full comment in modal
    function viewFullComment(comment) {
        Swal.fire({
            title: 'Comentario Completo',
            html: `<p class="text-slate-700 text-left leading-relaxed italic">"${comment}"</p>`,
            icon: 'info',
            confirmButtonColor: '#0ea5e9',
            confirmButtonText: 'Cerrar',
            customClass: { popup: 'rounded-2xl' },
            width: '600px'
        });
    }

    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Eliminar reseña?',
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
            })
        });
    });
</script>
@endsection
