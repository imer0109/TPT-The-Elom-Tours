@extends('admin.layouts.app')

@section('title', 'Ajouter un paiement')

@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700">
        Ajouter un paiement pour la réservation #{{ $reservation->reference }}
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
        <span>Ajouter un paiement</span>
    </div>

    <!-- Résumé de la réservation -->
    <div class="p-4 bg-white rounded-lg shadow-md mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <p class="text-sm font-medium text-gray-600">Client</p>
                <p class="text-sm">{{ $reservation->nom }}</p>
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

    <!-- Formulaire de création -->
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md">
        <form action="{{ route('admin.reservations.paiements.store', $reservation) }}" method="POST">
            @csrf

            <div class="grid gap-6 mb-8 md:grid-cols-2">
                <!-- Montant -->
                <div>
                    <label for="montant" class="block text-sm font-medium text-gray-700 mb-2">
                        Montant <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">€</span>
                        </div>
                        <input type="number" id="montant" name="montant" value="{{ old('montant', $reservation->montant_restant) }}" min="0" max="{{ $reservation->montant_restant }}" step="0.01" class="block w-full pl-7 mt-1 text-sm border-gray-300 rounded-md focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('montant') border-red-500 @enderror" required>
                    </div>
                    @error('montant')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Méthode de paiement -->
                <div>
                    <label for="methode" class="block text-sm font-medium text-gray-700 mb-2">
                        Méthode de paiement <span class="text-red-500">*</span>
                    </label>
                    <select id="methode" name="methode" class="block w-full mt-1 text-sm border-gray-300 rounded-md focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('methode') border-red-500 @enderror" required>
                        <option value="">Sélectionner une méthode</option>
                        @foreach($methodes as $value => $label)
                            <option value="{{ $value }}" {{ old('methode') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('methode')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date de paiement -->
                <div>
                    <label for="date_paiement" class="block text-sm font-medium text-gray-700 mb-2">
                        Date de paiement <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" id="date_paiement" name="date_paiement" value="{{ old('date_paiement', now()->format('Y-m-d\TH:i')) }}" class="block w-full mt-1 text-sm border-gray-300 rounded-md focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('date_paiement') border-red-500 @enderror" required>
                    @error('date_paiement')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Commentaire -->
                <div class="col-span-2">
                    <label for="commentaire" class="block text-sm font-medium text-gray-700 mb-2">
                        Commentaire
                    </label>
                    <textarea id="commentaire" name="commentaire" rows="3" class="block w-full mt-1 text-sm border-gray-300 rounded-md focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('commentaire') border-red-500 @enderror">{{ old('commentaire') }}</textarea>
                    @error('commentaire')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <a href="{{ route('admin.reservations.show', $reservation) }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Annuler
                </a>
                <button type="submit" class="ml-3 px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Enregistrer le paiement
                </button>
            </div>
        </form>
    </div>
</div>
@endsection