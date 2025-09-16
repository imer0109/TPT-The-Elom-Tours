@extends('layouts.admin')

@section('title', 'RÉSERVATIONS - THE ELOM TOURS')

@section('content')
<div class="container mx-auto py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Gestion des réservations</h1>
        <!-- <a href="{{ route('admin.reservations.create') }}" class="btn-primary flex items-center">
            <i class="fas fa-plus mr-2"></i> Nouvelle réservation
        </a> -->
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-calendar-check fa-2x"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total réservations</p>
                    <p class="text-lg font-semibold">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-clock fa-2x"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">En attente</p>
                    <p class="text-lg font-semibold">{{ $stats['pending'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check-circle fa-2x"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Confirmées</p>
                    <p class="text-lg font-semibold">{{ $stats['confirmed'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
             <i class="fas fa-coins fa-2x"></i>

                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Montant total</p>
                    <p class="text-lg font-semibold">{{ number_format($stats['montant_total'], 2, ',', ' ') }} FCFA</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-4">
                <!-- Filtre par statut -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select id="status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        <option value="">Tous les statuts</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmée</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Terminée</option>
                    </select>
                </div>
                
                <!-- Filtre par circuit -->
                <div>
                    <label for="circuit" class="block text-sm font-medium text-gray-700 mb-1">Circuit</label>
                    <select id="circuit" name="circuit" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        <option value="">Tous les circuits</option>
                        @foreach($circuits as $circuit)
                            <option value="{{ $circuit->id }}" {{ request('circuit') == $circuit->id ? 'selected' : '' }}>
                                {{ $circuit->titre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Filtre par date -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" id="date" name="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                </div>
            </div>
            
            <!-- Recherche -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full pl-10 p-2.5" placeholder="Rechercher un client...">
            </div>
        </div>
    </div>
    
    <!-- Tableau des réservations -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        {{-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th> --}}
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Client
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Circuit
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Personnes
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
                    @forelse($reservations as $reservation)
                    <tr class="hover-effect">
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                     <span class="text-gray-700 font-medium">
                                         {{ substr($reservation->nom, 0, 1) }}{{ substr($reservation->email, 0, 1) }}
                                     </span>
                                 </div>
                                 <div class="ml-4">
                                     <div class="text-sm font-medium text-gray-900">
                                         {{ $reservation->nom }}
                                     </div>
                                     <div class="text-sm text-gray-500">
                                         {{ $reservation->email }}
                                     </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                @if($reservation->circuit)
                                    {{ $reservation->circuit->titre }}
                                @else
                                    Circuit non disponible
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                @if($reservation->date_debut && $reservation->date_fin)
                                    {{ $reservation->date_debut->format('d/m/Y') }} - {{ $reservation->date_fin->format('d/m/Y') }}
                                @else
                                    Dates non disponibles
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="text-sm text-gray-900">{{ $reservation->nombre_personnes }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ number_format($reservation->montant_total, 2, ',', ' ') }} FCFA</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($reservation->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($reservation->status == 'confirmed') bg-green-100 text-green-800
                                @elseif($reservation->status == 'cancelled') bg-red-100 text-red-800
                                @elseif($reservation->status == 'completed') bg-blue-100 text-blue-800
                                @endif">
                                {{ $reservation->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.reservations.show', $reservation) }}" class="text-primary hover:text-green-700 mr-3" title="Voir"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('admin.reservations.edit', $reservation) }}" class="text-blue-600 hover:text-blue-800 mr-3" title="Modifier"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.reservations.destroy', $reservation) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" title="Supprimer"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                            Aucune réservation trouvée
                        </td>
                    </tr>
                    @endforelse
                            </span>
                        </td>
                        
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $reservations->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection