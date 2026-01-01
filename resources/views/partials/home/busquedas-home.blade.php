{{-- Filtros y busqueda --}}
<form method="GET" action="{{ route('home') }}" id="searchForm" class="bg-white/65 backdrop-blur-2xl p-3 rounded-[2rem] shadow-2xl shadow-indigo-100/40 max-w-5xl mx-auto border border-white/60 relative overflow-hidden group">
    <div class="absolute inset-0 bg-gradient-to-r from-indigo-50/50 to-pink-50/50 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>

    <div class="relative grid grid-cols-1 md:grid-cols-12 gap-3 z-10">

        <!-- Buscador -->
        <div class="md:col-span-8 relative">
            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                <span class="material-icons-round text-slate-400 group-focus-within:text-indigo-500 transition-colors">search</span>
            </div>
            <input type="text" 
                   id="searchInput"
                   name="search" 
                   value="{{ request('search') }}"
                   placeholder="Buscar por nombre, categoría..." 
                   class="w-full pl-14 pr-4 py-4 bg-white/60 hover:bg-white/80 focus:bg-white rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all duration-300 placeholder-slate-400 text-slate-700 font-medium">
        </div>

        <!-- Filtro de Categorías -->
        <div class="md:col-span-4 relative">
            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                <span class="material-icons-round text-slate-400 group-focus-within:text-indigo-500 transition-colors">filter_list</span>
            </div>
            <select name="category" 
                    id="categorySelect"
                    class="w-full pl-14 pr-10 py-4 bg-white/60 hover:bg-white/80 focus:bg-white rounded-2xl border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all duration-300 text-slate-700 font-medium appearance-none cursor-pointer">
                <option value="">Todas las Categorías</option>
                @if(isset($categories))
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                @endif
            </select>
            <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none">
                <span class="material-icons-round text-indigo-500 font-bold">expand_more</span>
            </div>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('searchInput');
        const select = document.getElementById('categorySelect');
        const form = document.getElementById('searchForm');
        const containerSelector = '#ventures-container';

        const performSearch = () => {
            const url = new URL(form.action);
            if (input.value) url.searchParams.set('search', input.value);
            if (select.value) url.searchParams.set('category', select.value);

            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.text())
                .then(html => {
                    const newDoc = new DOMParser().parseFromString(html, 'text/html');
                    const newContent = newDoc.querySelector(containerSelector);
                    const currentContent = document.querySelector(containerSelector);
                    
                    if (newContent && currentContent) {
                        currentContent.innerHTML = newContent.innerHTML;
                    }
                });
        };

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            performSearch();
        });

        select.addEventListener('change', () => {
            if (select.value === '') input.value = '';
            performSearch();
        });
    });
</script>
