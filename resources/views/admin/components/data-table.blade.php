<div class="overflow-x-auto bg-white rounded-lg shadow-md">
    <div class="flex flex-col md:flex-row justify-between p-4 border-b border-gray-200">
        <!-- Titre du tableau -->
        <h3 class="text-lg font-semibold text-gray-800 mb-3 md:mb-0">{{ $title ?? 'Liste des données' }}</h3>
        
        <!-- Recherche et filtres -->
        <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2">
            @if(isset($search) && $search)
            <div class="relative">
                <input type="text" 
                       id="{{ $searchId ?? 'table-search' }}" 
                       placeholder="{{ $searchPlaceholder ?? 'Rechercher...' }}" 
                       class="border border-gray-300 rounded-md pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
            @endif
            
            @if(isset($filters))
                {{ $filters }}
            @endif
            
            @if(isset($actions))
                {{ $actions }}
            @endif
        </div>
    </div>
    
    <!-- Tableau -->
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                @if(isset($headers))
                    {{ $headers }}
                @endif
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @if(isset($rows) && $rows->count() > 0)
                {{ $rows }}
            @else
                <tr>
                    <td colspan="100" class="px-6 py-8 text-center text-gray-500 italic">
                        {{ $emptyMessage ?? 'Aucune donnée disponible' }}
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
    
    <!-- Pagination -->
    @if(isset($pagination))
    <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 sm:px-6">
        {{ $pagination }}
    </div>
    @endif
</div>

@push('scripts')
<script>
    // Script pour la recherche en temps réel
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('{{ $searchId ?? "table-search" }}');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const tableRows = document.querySelectorAll('{{ $tableRowsSelector ?? "tbody tr" }}');
                
                tableRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endpush