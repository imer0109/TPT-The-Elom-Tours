@extends('layouts.app')

@section('title', 'Détails de la réservation')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Détails de la réservation</h1>
            <a href="{{ route('reservations.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Retour aux réservations
            </a>
        </div>
        
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">Référence: {{ $reservation->reference }}</h2>
                        <p class="text-sm text-gray-500">Réservé le {{ $reservation->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                        @if($reservation->statut == 'en_attente') bg-yellow-100 text-yellow-800
                        @elseif($reservation->statut == 'confirmee') bg-green-100 text-green-800
                        @elseif($reservation->statut == 'annulee') bg-red-100 text-red-800
                        @elseif($reservation->statut == 'terminee') bg-blue-100 text-blue-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ $reservation->statut_label }}
                    </span>
                </div>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informations du circuit</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm font-medium text-gray-500 mb-1">Circuit</p>
                            <p class="text-base mb-3">{{ $reservation->circuit->titre }}</p>
                            
                            <p class="text-sm font-medium text-gray-500 mb-1">Destination</p>
                            <p class="text-base mb-3">{{ $reservation->circuit->destination->nom ?? 'Non spécifiée' }}</p>
                            
                            <p class="text-sm font-medium text-gray-500 mb-1">Durée</p>
                            <p class="text-base">{{ $reservation->duree }} jours</p>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Détails de la réservation</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex justify-between mb-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Date de départ</p>
                                    <p class="text-base">{{ $reservation->date_debut->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Date de retour</p>
                                    <p class="text-base">{{ $reservation->date_fin->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            
                            <p class="text-sm font-medium text-gray-500 mb-1">Nombre de voyageurs</p>
                            <p class="text-base mb-3">{{ $reservation->nombre_personnes }}</p>
                            
                            <p class="text-sm font-medium text-gray-500 mb-1">Montant total</p>
                            <p class="text-xl font-semibold text-green-600">{{ number_format($reservation->montant_total, 2, ',', ' ') }} €</p>
                        </div>
                    </div>
                </div>
                
                @if($reservation->commentaire)
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Commentaires</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-base whitespace-pre-line">{{ $reservation->commentaire }}</p>
                        </div>
                    </div>
                @endif
                
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
                    
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('circuits.show', $reservation->circuit->slug) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                            Voir le circuit
                        </a>
                        
                        @if($reservation->statut == 'en_attente' || $reservation->statut == 'confirmee')
                            <form action="{{ route('reservations.cancel', $reservation->reference) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                                    Annuler la réservation
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route('contact.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Contacter le support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection