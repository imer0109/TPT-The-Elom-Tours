@extends('admin.layouts.app')

@section('title', 'Créer une réservation')

@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700">
        Créer une nouvelle réservation
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
        <span>Créer</span>
    </div>

    <!-- Formulaire de création -->
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md">
        <form action="{{ route('admin.reservations.store') }}" method="POST">
            @csrf

            <div class="grid gap-6 mb-8 md:grid-cols-2">
                <!-- Client -->
                <div class="col-span-2 md:col-span-1">
                    <label for="client_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Client <span class="text-red-500">*</span>
                    </label>
                    <select id="client_id" name="client_id" class="block w-full mt-1 text-sm border-gray-300 rounded-md focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('client_id') border-red-500 @enderror" required>
                        <option value="">Sélectionner un client</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                {{ $client->nom }} {{ $client->prenom }} ({{ $client->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('client_id')
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
                            <option value="{{ $circuit->id }}" data-price="{{ $circuit->prix }}" {{ old('circuit_id') == $circuit->id ? 'selected' : '' }}>
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
                    <input type="date" id="date_debut" name="date_debut" value="{{ old('date_debut') }}" class="block w-full mt-1 text-sm border-gray-300 rounded-md focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('date_debut') border-red-500 @enderror" required>
                    @error('date_debut')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date de fin -->
                <div>
                    <label for="date_fin" class="block text-sm font-medium text-gray-700 mb-2">
                        Date de fin <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="date_fin" name="date_fin" value="{{ old('date_fin') }}" class="block w-full mt-1 text-sm border-gray-300 rounded-md focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('date_fin') border-red-500 @enderror" required>
                    @error('date_fin')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nombre de personnes -->
                <div>
                    <label for="nombre_personnes" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre de personnes <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="nombre_personnes" name="nombre_personnes" value="{{ old('nombre_personnes', 1) }}" min="1" class="block w-full mt-1 text-sm border-gray-300 rounded-md focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('nombre_personnes') border-red-500 @enderror" required>
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
                        <input type="number" id="montant_total" name="montant_total" value="{{ old('montant_total', 0) }}" min="0" step="0.01" class="block w-full pl-7 mt-1 text-sm border-gray-300 rounded-md focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('montant_total') border-red-500 @enderror" required>
                    </div>
                    @error('montant_total')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Statut -->
                <div>
                    <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">
                        Statut <span class="text-red-500">*</span>
                    </label>
                    <select id="statut" name="statut" class="block w-full mt-1 text-sm border-gray-300 rounded-md focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('statut') border-red-500 @enderror" required>
                        <option value="pending" {{ old('statut') == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="confirmed" {{ old('statut') == 'confirmed' ? 'selected' : '' }}>Confirmée</option>
                        <option value="cancelled" {{ old('statut') == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                    </select>
                    @error('statut')
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
                <a href="{{ route('admin.reservations.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Annuler
                </a>
                <button type="submit" class="ml-3 px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Créer la réservation
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
        
        // Calcul initial
        calculateTotal();
        
        // Validation des dates
        const dateDebutInput = document.getElementById('date_debut');
        const dateFinInput = document.getElementById('date_fin');
        
        dateDebutInput.addEventListener('change', function() {
            dateFinInput.min = dateDebutInput.value;
            if (dateFinInput.value && dateFinInput.value < dateDebutInput.value) {
                dateFinInput.value = dateDebutInput.value;
            }
        });
        
        // Définir la date minimale à aujourd'hui
        const today = new Date().toISOString().split('T')[0];
        dateDebutInput.min = today;
        if (!dateDebutInput.value) {
            dateFinInput.min = today;
        }
    });
</script>
@endsection