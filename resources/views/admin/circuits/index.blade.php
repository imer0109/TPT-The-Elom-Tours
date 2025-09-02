@extends('layouts.admin')

@section('title', 'Circuits - The Elom Tours')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Gestion des circuits</h1>
        <a href="{{ route('admin.circuits.create') }}" class="btn-primary flex items-center">
            <i class="fas fa-plus mr-2"></i> Nouveau circuit
        </a>
    </div>

    @push('scripts')
    <script>
        function deleteCircuit(circuitId) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce circuit ?')) {
                document.getElementById('delete-form-' + circuitId).submit();
            }
        }

        // Soumission automatique des filtres
        document.querySelectorAll('#search-form select').forEach(select => {
            select.addEventListener('change', () => {
                document.getElementById('search-form').submit();
            });
        });

        // Soumission du formulaire lors de la saisie dans le champ de recherche
        let searchTimeout;
        document.querySelector('input[name="search"]').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                document.getElementById('search-form').submit();
            }, 500);
        });
    </script>
    @endpush
    
    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form id="search-form" action="{{ route('admin.circuits.index') }}" method="GET">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-4">
                <!-- Filtre par destination -->
                <div>
                    <label for="destination" class="block text-sm font-medium text-gray-700 mb-1">Destination</label>
                    <select id="destination" name="destination" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        <option value="">Toutes les destinations</option>
                        @foreach($circuits->pluck('destination')->unique() as $destination)
                            <option value="{{ $destination }}" {{ request('destination') == $destination ? 'selected' : '' }}>
                                {{ $destination }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Filtre par difficulté -->
                <div>
                    <label for="difficulte" class="block text-sm font-medium text-gray-700 mb-1">Difficulté</label>
                    <select id="difficulte" name="difficulte" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        <option value="">Toutes les difficultés</option>
                        @foreach($circuits->pluck('difficulte')->unique() as $difficulte)
                            <option value="{{ $difficulte }}" {{ request('difficulte') == $difficulte ? 'selected' : '' }}>
                                {{ ucfirst($difficulte) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Filtre par statut -->
                <div>
                    <label for="statut" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select id="statut" name="statut" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        <option value="">Tous les statuts</option>
                        <option value="actif" {{ request('statut') == 'actif' ? 'selected' : '' }}>Actif</option>
                        <option value="inactif" {{ request('statut') == 'inactif' ? 'selected' : '' }}>Inactif</option>
                    </select>
                </div>
            </div>
            
            <!-- Recherche -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full pl-10 p-2.5" placeholder="Rechercher un circuit...">
            </div>
        </div>
        </form>
    </div>
    
    <!-- Grille des circuits -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($circuits as $circuit)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover-effect">
            <div class="relative">
                @if($circuit->images->isNotEmpty())
                    <img src="{{ asset('storage/' . $circuit->images->first()->url) }}" alt="{{ $circuit->images->first()->alt }}" class="w-full h-48 object-cover">
                @else
                    <img src="{{ asset('assets/images/circuit-placeholder.svg') }}" alt="{{ $circuit->titre }}" class="w-full h-48 object-cover bg-gray-100">
                    
                @endif
                <div class="absolute top-0 right-0 m-2">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $circuit->est_actif ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $circuit->est_actif ? 'Actif' : 'Inactif' }}
                    </span>
                </div>
            </div>
            <div class="p-4">
                <h3 class="text-lg font-semibold mb-2">{{ $circuit->titre }}</h3>
                <div class="flex items-center text-sm text-gray-600 mb-2">
                    <i class="fas fa-map-marker-alt mr-2 text-primary"></i>
                    <span>{{ $circuit->destination }}</span>
                </div>
                <div class="flex items-center text-sm text-gray-600 mb-2">
                    <i class="fas fa-clock mr-2 text-primary"></i>
                    <span>{{ $circuit->duree }} jours</span>
                </div>
                <div class="flex items-center text-sm text-gray-600 mb-4">
                    <i class="fas fa-tag mr-2 text-primary"></i>
                    <span>{{ number_format($circuit->prix, 2, ',', ' ') }}€ / personne</span>
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <span class="text-sm font-medium text-gray-700 mr-2">Difficulté:</span>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ 
                            $circuit->difficulte === 'facile' ? 'bg-blue-100 text-blue-800' : 
                            ($circuit->difficulte === 'modere' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')
                        }}">
                            {{ ucfirst($circuit->difficulte) }}
                        </span>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.circuits.show', $circuit) }}" class="text-primary hover:text-green-700" title="Voir les détails"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.circuits.edit', $circuit) }}" class="text-blue-600 hover:text-blue-800" title="Modifier"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.circuits.toggle-active', $circuit) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="{{ $circuit->est_actif ? 'text-green-600 hover:text-green-800' : 'text-gray-600 hover:text-gray-800' }}" title="{{ $circuit->est_actif ? 'Désactiver' : 'Activer' }}">
                                <i class="fas {{ $circuit->est_actif ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                            </button>
                        </form>
                        <button onclick="deleteCircuit('{{ $circuit->id }}')" class="text-red-600 hover:text-red-800" title="Supprimer"><i class="fas fa-trash"></i></button>
                        <form id="delete-form-{{ $circuit->id }}" action="{{ route('admin.circuits.destroy', $circuit) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="lg:col-span-3 text-center py-12">
            <i class="fas fa-route text-gray-400 text-5xl mb-4"></i>
            <p class="text-gray-600">Aucun circuit trouvé</p>
        </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    @if($circuits->hasPages())
    <div class="mt-6">
        {{ $circuits->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection