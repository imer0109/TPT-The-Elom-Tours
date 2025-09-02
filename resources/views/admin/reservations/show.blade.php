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
    <div class="flex justify-between mb-6">
        <div class="flex space-x-2">
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
                <div class="flex items-center space-x-2">
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
            <div class="grid grid-cols-2 gap-4">
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
            <div class="mb-4">
                <p class="text-sm font-medium text-gray-600">Nom complet</p>
                <p class="text-sm font-semibold">{{ $reservation->client->nom }} {{ $reservation->client->prenom }}</p>
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
        </div>

        <!-- Détails du circuit -->
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">
                Détails du circuit
            </h3>
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
        </div>

        <!-- Détails de la réservation -->
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">
                Détails de la réservation
            </h3>
            <div class="mb-4">
                <p class="text-sm font-medium text-gray-600">Date de début</p>
                <p class="text-sm">{{ \Carbon\Carbon::parse($reservation->date_debut)->format('d/m/Y') }}</p>
            </div>
            <div class="mb-4">
                <p class="text-sm font-medium text-gray-600">Date de fin</p>
                <p class="text-sm">{{ \Carbon\Carbon::parse($reservation->date_fin)->format('d/m/Y') }}</p>
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

    <!-- Historique des paiements -->
    <div class="min-w-0 p-4 bg-white rounded-lg shadow-md mb-8">
        <div class="flex justify-between items-center mb-4 border-b pb-2">
            <h3 class="text-lg font-semibold text-gray-700">
                Historique des paiements
            </h3>
            <a href="{{ route('admin.reservations.paiements.create', $reservation) }}" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fas fa-plus mr-2"></i> Ajouter un paiement
            </a>
        </div>

        <!-- Résumé des paiements -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-sm font-medium text-gray-600">Montant total</p>
                <p class="text-lg font-semibold">{{ number_format($reservation->montant_total, 2, ',', ' ') }} €</p>
            </div>
            <div class="p-4 bg-green-50 rounded-lg">
                <p class="text-sm font-medium text-gray-600">Montant payé</p>
                <p class="text-lg font-semibold text-green-600">{{ number_format($reservation->paiements->where('statut', 'valide')->sum('montant'), 2, ',', ' ') }} €</p>
            </div>
            <div class="p-4 bg-red-50 rounded-lg">
                <p class="text-sm font-medium text-gray-600">Montant restant</p>
                <p class="text-lg font-semibold text-red-600">{{ number_format($reservation->montant_restant, 2, ',', ' ') }} €</p>
            </div>
        </div>

        <!-- Liste des paiements -->
        @if($reservation->paiements->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                            <th class="px-4 py-3">Référence</th>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Méthode</th>
                            <th class="px-4 py-3">Montant</th>
                            <th class="px-4 py-3">Statut</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        @foreach($reservation->paiements->sortByDesc('date_paiement') as $paiement)
                            <tr class="text-gray-700">
                                <td class="px-4 py-3 text-sm">
                                    {{ $paiement->reference }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $paiement->date_paiement->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $paiement->methode_label }}
                                </td>
                                <td class="px-4 py-3 text-sm font-semibold">
                                    {{ number_format($paiement->montant, 2, ',', ' ') }} €
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background-color: {{ $paiement->statut_color }}20; color: {{ $paiement->statut_color }}">
                                        {{ $paiement->statut_label }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.reservations.paiements.show', [$reservation, $paiement]) }}" class="text-blue-600 hover:text-blue-800" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.reservations.paiements.edit', [$reservation, $paiement]) }}" class="text-yellow-600 hover:text-yellow-800" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.reservations.paiements.destroy', [$reservation, $paiement]) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce paiement ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4">
                <p class="text-gray-500">Aucun paiement enregistré</p>
            </div>
        @endif
    </div>
</div>
@endsection