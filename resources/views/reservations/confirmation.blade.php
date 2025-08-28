@extends('layouts.app')

@section('title', 'Confirmation de réservation')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-8">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Réservation confirmée !</h1>
            <p class="text-gray-600">Votre demande de réservation a été enregistrée avec succès.</p>
        </div>
        
        <div class="border-t border-b border-gray-200 py-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Détails de la réservation</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-gray-600 mb-1">Référence</p>
                    <p class="font-medium">{{ $reservation->reference }}</p>
                </div>
                
                <div>
                    <p class="text-gray-600 mb-1">Statut</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        {{ $reservation->statut_label }}
                    </span>
                </div>
                
                <div>
                    <p class="text-gray-600 mb-1">Circuit</p>
                    <p class="font-medium">{{ $reservation->circuit->titre }}</p>
                </div>
                
                <div>
                    <p class="text-gray-600 mb-1">Date de départ</p>
                    <p class="font-medium">{{ $reservation->date_debut->format('d/m/Y') }}</p>
                </div>
                
                <div>
                    <p class="text-gray-600 mb-1">Date de retour</p>
                    <p class="font-medium">{{ $reservation->date_fin->format('d/m/Y') }}</p>
                </div>
                
                <div>
                    <p class="text-gray-600 mb-1">Nombre de voyageurs</p>
                    <p class="font-medium">{{ $reservation->nombre_personnes }}</p>
                </div>
                
                <div>
                    <p class="text-gray-600 mb-1">Montant total</p>
                    <p class="font-medium">{{ number_format($reservation->montant_total, 2, ',', ' ') }} €</p>
                </div>
            </div>
        </div>
        
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Prochaines étapes</h2>
            
            <div class="bg-blue-50 rounded-lg p-4 mb-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Notre équipe va examiner votre demande de réservation et vous contactera dans les 24 heures pour confirmer les détails et procéder au paiement.
                        </p>
                    </div>
                </div>
            </div>
            
            <ol class="space-y-4">
                <li class="flex items-start">
                    <div class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-green-100 text-green-600 font-bold text-sm mr-3">1</div>
                    <div>
                        <p class="font-medium">Vérification de disponibilité</p>
                        <p class="text-gray-600 text-sm">Notre équipe vérifie la disponibilité des dates et services demandés.</p>
                    </div>
                </li>
                
                <li class="flex items-start">
                    <div class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-green-100 text-green-600 font-bold text-sm mr-3">2</div>
                    <div>
                        <p class="font-medium">Confirmation et paiement</p>
                        <p class="text-gray-600 text-sm">Nous vous contacterons pour confirmer les détails et procéder au paiement de l'acompte.</p>
                    </div>
                </li>
                
                <li class="flex items-start">
                    <div class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-green-100 text-green-600 font-bold text-sm mr-3">3</div>
                    <div>
                        <p class="font-medium">Préparation du voyage</p>
                        <p class="text-gray-600 text-sm">Vous recevrez tous les documents nécessaires pour votre voyage.</p>
                    </div>
                </li>
            </ol>
        </div>
        
        <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
            <a href="{{ route('reservations.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                Voir mes réservations
            </a>
            
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Retour à l'accueil
            </a>
        </div>
    </div>
</div>
@endsection