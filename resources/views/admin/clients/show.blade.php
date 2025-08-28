@extends('layouts.admin')

@section('title', 'Détails du client - The Elom Tours')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Détails du client</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.clients.edit', $client) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition duration-300">
                <i class="fas fa-edit mr-1"></i> Modifier
            </a>
            <a href="{{ route('admin.clients.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition duration-300">
                <i class="fas fa-arrow-left mr-1"></i> Retour à la liste
            </a>
        </div>
    </div>
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Informations du client -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        @if($client->file)
                            <img src="{{ asset('storage/' . $client->file->path) }}" alt="Photo de {{ $client->nom_complet }}" class="h-24 w-24 object-cover rounded-full mr-6">
                        @else
                            <div class="h-24 w-24 rounded-full bg-gray-200 flex items-center justify-center mr-6">
                                <span class="text-gray-700 font-medium text-2xl">{{ substr($client->prenom, 0, 1) }}{{ substr($client->nom, 0, 1) }}</span>
                            </div>
                        @endif
                        <div>
                            <h2 class="text-xl font-bold">{{ $client->nom_complet }}</h2>
                            <p class="text-gray-600">Client depuis {{ $client->created_at->format('d/m/Y') }}</p>
                            @if($client->user_id)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mt-2">
                                    <i class="fas fa-user-circle mr-1"></i> Compte utilisateur actif
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Informations personnelles -->
                        <div>
                            <h3 class="text-lg font-medium mb-4 pb-2 border-b">Informations personnelles</h3>
                            
                            <div class="space-y-3">
                                <div>
                                    <span class="text-gray-600 font-medium">Email:</span>
                                    <p>{{ $client->email }}</p>
                                </div>
                                
                                <div>
                                    <span class="text-gray-600 font-medium">Téléphone:</span>
                                    <p>{{ $client->telephone }}</p>
                                </div>
                                
                                <div>
                                    <span class="text-gray-600 font-medium">Date de naissance:</span>
                                    <p>{{ $client->date_naissance ? $client->date_naissance->format('d/m/Y') : 'Non renseignée' }}</p>
                                </div>
                                
                                <div>
                                    <span class="text-gray-600 font-medium">ID client:</span>
                                    <p>#{{ $client->id }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Adresse -->
                        <div>
                            <h3 class="text-lg font-medium mb-4 pb-2 border-b">Adresse</h3>
                            
                            <div class="space-y-3">
                                <div>
                                    <span class="text-gray-600 font-medium">Adresse:</span>
                                    <p>{{ $client->adresse ?: 'Non renseignée' }}</p>
                                </div>
                                
                                <div>
                                    <span class="text-gray-600 font-medium">Ville:</span>
                                    <p>{{ $client->ville ?: 'Non renseignée' }}</p>
                                </div>
                                
                                <div>
                                    <span class="text-gray-600 font-medium">Code postal:</span>
                                    <p>{{ $client->code_postal ?: 'Non renseigné' }}</p>
                                </div>
                                
                                <div>
                                    <span class="text-gray-600 font-medium">Pays:</span>
                                    <p>
                                        @switch($client->pays)
                                            @case('FR')
                                                France
                                                @break
                                            @case('BE')
                                                Belgique
                                                @break
                                            @case('CH')
                                                Suisse
                                                @break
                                            @case('CA')
                                                Canada
                                                @break
                                            @case('TG')
                                                Togo
                                                @break
                                            @case('US')
                                                États-Unis
                                                @break
                                            @default
                                                Non renseigné
                                        @endswitch
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Statistiques -->
        <div>
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-medium mb-4 pb-2 border-b">Statistiques</h3>
                
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-gray-600">Réservations</span>
                            <span class="font-medium">{{ $client->nombre_reservations }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-primary h-2 rounded-full" style="width: {{ min($client->nombre_reservations * 10, 100) }}%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-gray-600">Montant total</span>
                            <span class="font-medium">{{ number_format($client->montant_total, 2, ',', ' ') }} €</span>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-gray-600">Dernière réservation</span>
                            <span class="font-medium">
                                @if($client->reservations->count() > 0)
                                    {{ $client->reservations->sortByDesc('created_at')->first()->created_at->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-medium mb-4 pb-2 border-b">Actions</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('admin.reservations.create', ['client_id' => $client->id]) }}" class="flex items-center text-blue-600 hover:text-blue-800">
                        <i class="fas fa-calendar-plus mr-2"></i> Créer une réservation
                    </a>
                    
                    <a href="#" class="flex items-center text-green-600 hover:text-green-800">
                        <i class="fas fa-envelope mr-2"></i> Envoyer un email
                    </a>
                    
                    <form action="{{ route('admin.clients.destroy', $client) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex items-center text-red-600 hover:text-red-800 w-full text-left">
                            <i class="fas fa-trash mr-2"></i> Supprimer le client
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Réservations du client -->
    <div class="mt-8">
        <h2 class="text-xl font-bold mb-4">Réservations du client</h2>
        
        @if($client->reservations->count() > 0)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Circuit
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Participants
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Montant
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Statut
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($client->reservations as $reservation)
                                <tr class="hover-effect">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">#{{ $reservation->id }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $reservation->circuit->titre ?? 'Circuit inconnu' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $reservation->date_debut->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $reservation->date_fin->format('d/m/Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="text-sm text-gray-900">{{ $reservation->nombre_participants }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ number_format($reservation->montant_total, 2, ',', ' ') }} €</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @switch($reservation->statut)
                                            @case('en_attente')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    En attente
                                                </span>
                                                @break
                                            @case('confirmee')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Confirmée
                                                </span>
                                                @break
                                            @case('annulee')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Annulée
                                                </span>
                                                @break
                                            @case('terminee')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    Terminée
                                                </span>
                                                @break
                                            @default
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    {{ $reservation->statut }}
                                                </span>
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.reservations.show', $reservation) }}" class="text-primary hover:text-green-700 mr-3"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('admin.reservations.edit', $reservation) }}" class="text-blue-600 hover:text-blue-800 mr-3"><i class="fas fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <p class="text-gray-600">Ce client n'a pas encore effectué de réservation.</p>
                <a href="{{ route('admin.reservations.create', ['client_id' => $client->id]) }}" class="inline-block mt-4 bg-primary hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition duration-300">
                    <i class="fas fa-calendar-plus mr-2"></i> Créer une réservation
                </a>
            </div>
        @endif
    </div>
</div>
@endsection