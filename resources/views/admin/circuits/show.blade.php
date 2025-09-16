@extends('layouts.admin')

@section('title', 'DÉTAILS DU CIRCUIT - THE ELOM TOURS')

@section('content')
<div class="container mx-auto">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.circuits.index') }}" class="text-gray-600 hover:text-gray-900 mr-2">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold">{{ $circuit->titre }}</h1>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Informations principales -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Image et informations de base -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @if($circuit->images->isNotEmpty())
                    <img src="{{ asset('storage/' . $circuit->images->first()->url) }}" alt="{{ $circuit->images->first()->alt }}" class="w-full h-96 object-cover">
                @else
                    <img src="{{ asset('assets/images/circuit-placeholder.svg') }}" alt="{{ $circuit->titre }}" class="w-full h-96 object-cover bg-gray-100">
                @endif
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-2">
                            <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $circuit->est_actif ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $circuit->est_actif ? 'Actif' : 'Inactif' }}
                            </span>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full {{ 
                                $circuit->difficulte === 'facile' ? 'bg-blue-100 text-blue-800' : 
                                ($circuit->difficulte === 'modere' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')
                            }}">
                                {{ ucfirst($circuit->difficulte) }}
                            </span>
                        </div>
                        <div class="text-2xl font-bold text-primary">
                            {{ number_format($circuit->prix, 2, ',', ' ') }} €
                            <span class="text-sm text-gray-600 font-normal">/ personne</span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-sm text-gray-600">Destination</p>
                            <p class="font-semibold">{{ $circuit->destination }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Durée</p>
                            <p class="font-semibold">{{ $circuit->duree }} jours</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Taille du groupe</p>
                            <p class="font-semibold">{{ $circuit->taille_groupe }} personnes max.</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Langues disponibles</p>
                            <p class="font-semibold">
                                @foreach($circuit->langues as $langue)
                                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 mr-1">
                                        {{ strtoupper($langue) }}
                                    </span>
                                @endforeach
                            </p>
                        </div>
                    </div>
                    
                    <div class="prose max-w-none">
                        {!! nl2br(e($circuit->description)) !!}
                    </div>
                </div>
            </div>
            
            <!-- Étapes du circuit -->
            @if($circuit->etapes->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Itinéraire détaillé</h2>
                <div class="space-y-6">
                    @foreach($circuit->etapes as $etape)
                    <div class="flex">
                        <div class="flex-shrink-0 w-12 relative">
                            <div class="w-4 h-4 bg-primary rounded-full mx-auto"></div>
                            @if(!$loop->last)
                                <div class="h-full w-0.5 bg-gray-200 absolute left-1/2 transform -translate-x-1/2 top-4"></div>
                            @endif
                        </div>
                        <div class="flex-grow pb-6">
                            <h3 class="text-lg font-semibold mb-2">{{ $etape->titre }}</h3>
                            <p class="text-gray-600">{{ $etape->description }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Galerie d'images -->
            @if($circuit->images->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Galerie photos</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($circuit->images as $image)
                    <div class="relative group">
                        <img src="{{ asset('storage/' . $image->url) }}" alt="{{ $image->alt }}" class="w-full h-48 object-cover rounded-lg">
                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-lg flex items-center justify-center">
                            <a href="{{ asset('storage/' . $image->url) }}" target="_blank" class="text-white hover:text-primary">
                                <i class="fas fa-expand-alt fa-lg"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('admin.circuits.edit', $circuit) }}" class="btn-primary w-full justify-center">
                        <i class="fas fa-edit mr-2"></i> Modifier
                    </a>
                    <button onclick="toggleStatus()" class="btn-secondary w-full justify-center">
                        <i class="fas fa-power-off mr-2"></i> {{ $circuit->est_actif ? 'Désactiver' : 'Activer' }}
                    </button>
                    <button onclick="deleteCircuit()" class="btn-danger w-full justify-center">
                        <i class="fas fa-trash-alt mr-2"></i> Supprimer
                    </button>
                </div>
                
                <form id="toggle-form" action="{{ route('admin.circuits.toggle-active', $circuit) }}" method="POST" class="hidden">
                    @csrf
                    @method('PATCH')
                </form>
                
                <form id="delete-form" action="{{ route('admin.circuits.destroy', $circuit) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
            
            <!-- Statistiques -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Statistiques</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600">Note moyenne</p>
                        <div class="flex items-center">
                            <span class="text-2xl font-bold mr-2">{{ number_format($circuit->note_moyenne, 1) }}</span>
                            <div class="text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $circuit->note_moyenne)
                                        <i class="fas fa-star"></i>
                                    @elseif($i - 0.5 <= $circuit->note_moyenne)
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-sm text-gray-600 ml-2">({{ $circuit->nombre_avis }})</span>
                        </div>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600">Réservations confirmées</p>
                        <p class="text-2xl font-bold">{{ $circuit->nombre_reservations_confirmees }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Catégories -->
            @if($circuit->categories->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Catégories</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach($circuit->categories as $categorie)
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                        {{ $categorie->nom }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleStatus() {
        if (confirm('Êtes-vous sûr de vouloir {{ $circuit->est_actif ? 'désactiver' : 'activer' }} ce circuit ?')) {
            document.getElementById('toggle-form').submit();
        }
    }
    
    function deleteCircuit() {
        if (confirm('Êtes-vous sûr de vouloir supprimer ce circuit ? Cette action est irréversible.')) {
            document.getElementById('delete-form').submit();
        }
    }
</script>
@endsection