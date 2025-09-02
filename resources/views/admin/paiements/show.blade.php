@extends('admin.layouts.app')

@section('title', 'Détails du paiement')

@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700">
        Détails du paiement #{{ $paiement->reference }}
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
        <a href="{{ route('admin.reservations.show', $reservation) }}" class="text-blue-600 hover:text-blue-800">
            Réservation #{{ $reservation->reference }}
        </a>
        <span class="mx-2">/</span>
        <span>Détails du paiement</span>
    </div>

    <!-- Résumé de la réservation -->
    <div class="p-4 bg-white rounded-lg shadow-md mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <p class="text-sm font-medium text-gray-600">Client</p>
                <p class="text-sm">{{ $reservation->client->nom }} {{ $reservation->client->prenom }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Circuit</p>
                <p class="text-sm">{{ $reservation->circuit->titre }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Montant total</p>
                <p class="text-sm font-semibold">{{ number_format($reservation->montant_total, 2, ',', ' ') }} €</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Montant payé</p>
                <p class="text-sm text-green-600">{{ number_format($reservation->paiements->where('statut', 'valide')->sum('montant'), 2, ',', ' ') }} €</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Montant restant</p>
                <p class="text-sm text-red-600">{{ number_format($reservation->montant_restant, 2, ',', ' ') }} €</p>
            </div>
        </div>
    </div>

    <!-- Détails du paiement -->
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md">
        <div class="grid gap-6 mb-8 md:grid-cols-2">
            <!-- Informations générales -->
            <div class="space-y-4">
                <div>
                    <h3 class="text-lg font-medium text-gray-700 mb-3">Informations générales</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Référence</p>
                            <p class="text-sm">{{ $paiement->reference }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Montant</p>
                            <p class="text-sm font-semibold">{{ number_format($paiement->montant, 2, ',', ' ') }} €</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Méthode</p>
                            <p class="text-sm">{{ $paiement->methode_label }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Date</p>
                            <p class="text-sm">{{ $paiement->date_paiement->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Statut</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background-color: {{ $paiement->statut_color }}20; color: {{ $paiement->statut_color }}">
                                {{ $paiement->statut_label }}
                            </span>
                        </div>
                    </div>
                </div>

                @if($paiement->commentaire)
                <div>
                    <h3 class="text-lg font-medium text-gray-700 mb-3">Commentaire</h3>
                    <p class="text-sm text-gray-600">{{ $paiement->commentaire }}</p>
                </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-gray-700 mb-3">Actions</h3>
                <div class="space-y-3">
                    <!-- Modifier le statut -->
                    <div class="flex items-center space-x-3">
                        <form action="{{ route('admin.reservations.paiements.changeStatus', [$reservation, $paiement]) }}" method="POST" class="flex-1">
                            @csrf
                            @method('PATCH')
                            <div class="flex space-x-2">
                                <select name="statut" class="block w-full text-sm border-gray-300 rounded-md focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    @foreach($statuts as $value => $label)
                                        <option value="{{ $value }}" {{ $paiement->statut === $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Mettre à jour
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Autres actions -->
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.reservations.paiements.edit', [$reservation, $paiement]) }}" class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 text-center">
                            Modifier
                        </a>
                        <form action="{{ route('admin.reservations.paiements.destroy', [$reservation, $paiement]) }}" method="POST" class="flex-1" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce paiement ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection