@extends('admin.layouts.app')

@section('title', 'MODIFIER UNE RÉSERVATION - THE ELOM TOURS')

@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700">
        Modifier la réservation #{{ $reservation->id }}
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
        <span>Modifier</span>
    </div>

    <!-- Formulaire d'édition -->
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md">
        <form action="{{ route('admin.reservations.update', $reservation) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid gap-6 mb-8 md:grid-cols-2">
                <!-- Nom du client -->
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom du client <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nom" name="nom" value="{{ old('nom', $reservation->nom) }}" class="block w-full mt-1 text-sm border-gray-300 rounded-md focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('nom') border-red-500 @enderror" required>
                    @error('nom')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email du client -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email du client <span class="text-red-500">*</span>
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email', $reservation->email) }}" class="block w-full mt-1 text-sm border-gray-300 rounded-md focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('email') border-red-500 @enderror" required>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Téléphone du client -->
                <div>
                    <label for="telephone" class="block text-sm font-medium text-gray-700 mb-2">
                        Téléphone du client
                    </label>
                    <input type="tel" id="telephone" name="telephone" value="{{ old('telephone', $reservation->telephone) }}" class="block w-full mt-1 text-sm border-gray-300 rounded-md focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('telephone') border-red-500 @enderror">
                    @error('telephone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Message du client -->
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                        Message du client
                    </label>
                    <textarea id="message" name="message" rows="3" class="block w-full mt-1 text-sm border-gray-300 rounded-md focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('message') border-red-500 @enderror">{{ old('message', $reservation->message) }}</textarea>
                    @error('message')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Circuit -->
                <div class="col-span-2 md:col-span-1">
                    <label for="circuit_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Circuit <span class="text-red-500">*</span>
                    </label>
                    <select id="circuit_id" name="circuit_id" class="block w-full mt-1 text-sm border-gray-300 rounded-md focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('circuit_id') border-red-500 @enderror" required>
                        <option value="">Sélectionner un circuit</option>
                        @foreach($circuits as $circuit)
                            <option value="{{ $circuit->id }}" data-price="{{ $circuit->prix }}" {{ old('circuit_id', $reservation->circuit_id) == $circuit->id ? 'selected' : '' }}>
                                {{ $circuit->titre }} ({{ $circuit->destination }} - {{ $circuit->duree }} jours)
                            </option>
                        @endforeach
                    </select>
                    @error('circuit_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date de début -->
                <div>
                    <label for="date_debut" class="block text-sm font-medium text-gray-700 mb-2">
                        Date de début <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="date_debut" name="date_debut" value="{{ old('date_debut', $reservation->date_debut) }}" class="block w-full mt-1 text-sm border-gray-300 rounded-md focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('date_debut') border-red-500 @enderror" required>
                    @error('date_debut')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date de fin -->
                <div>
                    <label for="date_fin" class="block text-sm font-medium text-gray-700 mb-2">
                        Date de fin <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="date_fin" name="date_fin" value="{{ old('date_fin', $reservation->date_fin) }}" class="block w-full mt-1 text-sm border-gray-300 rounded-md focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('date_fin') border-red-500 @enderror" required>
                    @error('date_fin')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nombre de personnes -->
                <div>
                    <label for="nombre_personnes" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre de personnes <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="nombre_personnes" name="nombre_personnes" value="{{ old('nombre_personnes', $reservation->nombre_personnes) }}" min="1" class="block w-full mt-1 text-sm border-gray-300 rounded-md focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('nombre_personnes') border-red-500 @enderror" required>
                    @error('nombre_personnes')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Montant total -->
                <div>
                    <label for="montant_total" class="block text-sm font-medium text-gray-700 mb-2">
                        Montant total <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">€</span>
                        </div>
                        <input type="number" id="montant_total" name="montant_total" value="{{ old('montant_total', $reservation->montant_total) }}" min="0" step="0.01" class="block w-full pl-7 mt-1 text-sm border-gray-300 rounded-md focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('montant_total') border-red-500 @enderror" required>
                    </div>
                    @error('montant_total')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Statut <span class="text-red-500">*</span>
                    </label>
                    <select id="status" name="status" class="block w-full mt-1 text-sm border-gray-300 rounded-md focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('status') border-red-500 @enderror" required>
                        <option value="pending" {{ old('status', $reservation->status) == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="confirmed" {{ old('status', $reservation->status) == 'confirmed' ? 'selected' : '' }}>Confirmée</option>
                        <option value="cancelled" {{ old('status', $reservation->status) == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                        <option value="completed" {{ old('status', $reservation->status) == 'completed' ? 'selected' : '' }}>Terminée</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Commentaire -->
                <div class="col-span-2">
                    <label for="commentaire" class="block text-sm font-medium text-gray-700 mb-2">
                        Commentaire
                    </label>
                    <textarea id="commentaire" name="commentaire" rows="3" class="block w-full mt-1 text-sm border-gray-300 rounded-md focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('commentaire') border-red-500 @enderror">{{ old('commentaire', $reservation->commentaire) }}</textarea>
                    @error('commentaire')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <a href="{{ route('admin.reservations.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Annuler
                </a>
                <button type="submit" class="ml-3 px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Calcul automatique du montant total
        const circuitSelect = document.getElementById('circuit_id');
        const nombrePersonnesInput = document.getElementById('nombre_personnes');
        const montantTotalInput = document.getElementById('montant_total');
        
        function calculateTotal() {
            const selectedOption = circuitSelect.options[circuitSelect.selectedIndex];
            if (selectedOption && selectedOption.value) {
                const prixUnitaire = parseFloat(selectedOption.dataset.price) || 0;
                const nombrePersonnes = parseInt(nombrePersonnesInput.value) || 1;
                const montantTotal = prixUnitaire * nombrePersonnes;
                montantTotalInput.value = montantTotal.toFixed(2);
            }
        }
        
        circuitSelect.addEventListener('change', calculateTotal);
        nombrePersonnesInput.addEventListener('input', calculateTotal);
        
        // Validation des dates
        const dateDebutInput = document.getElementById('date_debut');
        const dateFinInput = document.getElementById('date_fin');
        
        dateDebutInput.addEventListener('change', function() {
            dateFinInput.min = dateDebutInput.value;
            if (dateFinInput.value && dateFinInput.value < dateDebutInput.value) {
                dateFinInput.value = dateDebutInput.value;
            }
        });
    });
</script>
@endsection