@extends('admin.layouts.app')

@section('title', 'Paiements de la réservation #' . $reservation->reference)

@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700">
        Paiements de la réservation #{{ $reservation->reference }}
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
        <span>Paiements</span>
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
                    @elseif($reservation->status == 'completed')
                        <span class="px-2 py-1 text-xs font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full">
                            Terminée
                        </span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-between mb-6">
        <div class="flex space-x-2">
            <a href="{{ route('admin.reservations.paiements.create', $reservation) }}" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fas fa-plus mr-2"></i> Ajouter un paiement
            </a>
        </div>
    </div>

    <!-- Liste des paiements -->
    <div class="w-full overflow-hidden rounded-lg shadow-md">
        <div class="w-full overflow-x-auto">
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
                    @forelse($paiements as $paiement)
                        <tr class="text-gray-700">
                            <td class="px-4 py-3">
                                {{ $paiement->reference }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $paiement->date_paiement->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $paiement->methode_label }}
                            </td>
                            <td class="px-4 py-3 font-semibold">
                                {{ number_format($paiement->montant, 2, ',', ' ') }} €
                            </td>
                            <td class="px-4 py-3">
                                <form action="{{ route('admin.reservations.paiements.change-status', [$reservation, $paiement]) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="statut" onchange="this.form.submit()" class="text-sm rounded-full px-2 py-1 {{ $paiement->statut_color == 'green' ? 'bg-green-100 text-green-700' : ($paiement->statut_color == 'yellow' ? 'bg-yellow-100 text-yellow-700' : ($paiement->statut_color == 'red' ? 'bg-red-100 text-red-700' : 'bg-purple-100 text-purple-700')) }}">
                                        @foreach(\App\Models\Paiement::$statuts as $value => $label)
                                            <option value="{{ $value }}" {{ $paiement->statut == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-2 text-sm">
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
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-gray-500">
                                Aucun paiement enregistré pour cette réservation.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection