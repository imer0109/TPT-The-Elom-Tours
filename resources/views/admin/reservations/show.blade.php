@extends('admin.layouts.app')

@section('title', 'Détails de la réservation')

@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700">
        Détails de la réservation #{{ $reservation->id }}
    </h2>

    <!-- Breadcrumb -->
    <div class="flex text-sm text-gray-600 mb-4">
        <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800">
            Dashboard
        </a>
        <span class="mx-2">/</span>
        <a href="{{ route('admin.reservations.index') }}" class="text-blue-600 hover:text-blue-800">
            Réservations
        </a>
        <span class="mx-2">/</span>
        <span>Détails</span>
    </div>

    <!-- Actions -->
    <div class="flex flex-col md:flex-row justify-between mb-6 gap-4">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.reservations.edit', $reservation) }}" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fas fa-edit mr-2"></i> Modifier
            </a>
            <form action="{{ route('admin.reservations.destroy', $reservation) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <i class="fas fa-trash mr-2"></i> Supprimer
                </button>
            </form>
        </div>
        <div>
            <form action="{{ route('admin.reservations.change-status', $reservation) }}" method="POST" class="inline">
                @csrf
                @method('PATCH')
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
                    <select name="status" class="text-sm border-gray-300 rounded-md focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="confirmed" {{ $reservation->status == 'confirmed' ? 'selected' : '' }}>Confirmée</option>
                        <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                    </select>
                    <button type="submit" class="px-3 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Changer le statut
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Détails de la réservation -->
    <div class="grid gap-6 mb-8 md:grid-cols-2">
        <!-- Informations générales -->
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">
                Informations générales
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-600">Numéro de réservation</p>
                    <p class="text-sm font-semibold">#{{ $reservation->id }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Date de création</p>
                    <p class="text-sm">{{ $reservation->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Statut</p>
                    <p class="text-sm">
                        @if($reservation->status == 'pending')
                            <span class="px-2 py-1 text-xs font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full">
                                En attente
                            </span>
                        @elseif($reservation->status == 'confirmed')
                            <span class="px-2 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                                Confirmée
                            </span>
                        @elseif($reservation->status == 'cancelled')
                            <span class="px-2 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded-full">
                                Annulée
                            </span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Dernière mise à jour</p>
                    <p class="text-sm">{{ $reservation->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Informations du client -->
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">
                Informations du client
            </h3>
            @if($reservation->client)
                <div class="mb-4">
                    <p class="text-sm font-medium text-gray-600">Nom complet</p>
                    <p class="text-sm font-semibold">
                        {{ $reservation->client->nom }} {{ $reservation->client->prenom }}
                    </p>
                </div>
                <div class="mb-4">
                    <p class="text-sm font-medium text-gray-600">Email</p>
                    <p class="text-sm">{{ $reservation->client->email }}</p>
                </div>
                <div class="mb-4">
                    <p class="text-sm font-medium text-gray-600">Téléphone</p>
                    <p class="text-sm">{{ $reservation->client->telephone ?? 'Non renseigné' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Adresse</p>
                    <p class="text-sm">
                        {{ $reservation->client->adresse ?? 'Non renseignée' }}<br>
                        @if($reservation->client->code_postal || $reservation->client->ville)
                            {{ $reservation->client->code_postal ?? '' }} {{ $reservation->client->ville ?? '' }}<br>
                        @endif
                        {{ $reservation->client->pays ?? '' }}
                    </p>
                </div>
            @else
                <p class="text-sm text-gray-500">Aucune information client disponible</p>
            @endif
        </div>

        <!-- Détails du circuit -->
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">
                Détails du circuit
            </h3>
            @if($reservation->circuit)
                <div class="mb-4">
                    <p class="text-sm font-medium text-gray-600">Titre</p>
                    <p class="text-sm font-semibold">{{ $reservation->circuit->titre }}</p>
                </div>
                <div class="mb-4">
                    <p class="text-sm font-medium text-gray-600">Destination</p>
                    <p class="text-sm">{{ $reservation->circuit->destination }}</p>
                </div>
                <div class="mb-4">
                    <p class="text-sm font-medium text-gray-600">Durée</p>
                    <p class="text-sm">{{ $reservation->circuit->duree }} jours</p>
                </div>
                <div class="mb-4">
                    <p class="text-sm font-medium text-gray-600">Prix unitaire</p>
                    <p class="text-sm">{{ number_format($reservation->circuit->prix, 2, ',', ' ') }} €</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Difficulté</p>
                    <p class="text-sm">
                        @if($reservation->circuit->difficulte == 'facile')
                            <span class="px-2 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                                Facile
                            </span>
                        @elseif($reservation->circuit->difficulte == 'modere')
                            <span class="px-2 py-1 text-xs font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full">
                                Modéré
                            </span>
                        @elseif($reservation->circuit->difficulte == 'difficile')
                            <span class="px-2 py-1 text-xs font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full">
                                Difficile
                            </span>
                        @elseif($reservation->circuit->difficulte == 'extreme')
                            <span class="px-2 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded-full">
                                Extrême
                            </span>
                        @endif
                    </p>
                </div>
            @else
                <p class="text-sm text-gray-500">Aucune information circuit disponible</p>
            @endif
        </div>

        <!-- Détails de la réservation -->
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">
                Détails de la réservation
            </h3>
            <div class="mb-4">
                <p class="text-sm font-medium text-gray-600">Date de début</p>
                <p class="text-sm">{{ $reservation->date_debut ? \Carbon\Carbon::parse($reservation->date_debut)->format('d/m/Y') : 'Non définie' }}</p>
            </div>
            <div class="mb-4">
                <p class="text-sm font-medium text-gray-600">Date de fin</p>
                <p class="text-sm">{{ $reservation->date_fin ? \Carbon\Carbon::parse($reservation->date_fin)->format('d/m/Y') : 'Non définie' }}</p>
            </div>
            <div class="mb-4">
                <p class="text-sm font-medium text-gray-600">Nombre de personnes</p>
                <p class="text-sm">{{ $reservation->nombre_personnes }}</p>
            </div>
            <div class="mb-4">
                <p class="text-sm font-medium text-gray-600">Montant total</p>
                <p class="text-sm font-semibold">{{ number_format($reservation->montant_total, 2, ',', ' ') }} €</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Commentaire</p>
                <p class="text-sm">{{ $reservation->commentaire ?? 'Aucun commentaire' }}</p>
            </div>
        </div>
    </div>

    
</div>
@endsection