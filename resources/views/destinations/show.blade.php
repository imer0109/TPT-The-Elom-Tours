@extends('layouts.app')

@section('title', $destination->name . ' - The Elom Tours')

@section('content')
<div class="container mx-auto px-4 py-12 mt-52">
    <!-- Hero Section -->
    <div class="relative h-96 rounded-xl overflow-hidden mb-12">
        @if($destination->getFirstMediaUrl('images'))
        <img src="{{ $destination->getFirstMediaUrl('images') }}" alt="{{ $destination->name }}" class="w-full h-full object-cover">
        @else
        <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="{{ $destination->name }}" class="w-full h-full object-cover">
        @endif
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
        <div class="absolute bottom-0 left-0 p-8 text-white">
            <h1 class="text-4xl font-bold mb-2">{{ $destination->name }}</h1>
            <p class="text-xl">{{ $destination->country }}</p>
        </div>
    </div>
    
    <!-- Destination Info -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 mb-16">
        <div class="lg:col-span-2">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">À propos de {{ $destination->name }}</h2>
            <div class="prose max-w-none">
                {!! $destination->description !!}
            </div>
        </div>
        
        <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Informations</h3>
            <ul class="space-y-3">
                <li class="flex items-start">
                    <i class="fas fa-map-marker-alt text-green-600 mt-1 mr-3"></i>
                    <span>{{ $destination->city }}, {{ $destination->country }}</span>
                </li>
                @if($destination->circuits_count > 0)
                <li class="flex items-start">
                    <i class="fas fa-route text-green-600 mt-1 mr-3"></i>
                    <span>{{ $destination->circuits_count }} circuits disponibles</span>
                </li>
                @endif
                <li class="flex items-start">
                    <i class="fas fa-info-circle text-green-600 mt-1 mr-3"></i>
                    <span>Destination {{ $destination->is_popular ? 'populaire' : 'standard' }}</span>
                </li>
            </ul>
            
            <div class="mt-8">
                <a href="{{ route('circuits.index') }}?destination={{ $destination->id }}" class="block w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-md text-center transition duration-300">
                    Voir les circuits pour cette destination
                </a>
            </div>
        </div>
    </div>
    
    <!-- Related Circuits -->
    @if($relatedCircuits->count() > 0)
    <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Circuits à {{ $destination->name }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedCircuits as $circuit)
            <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:shadow-lg hover:-translate-y-1">
                <a href="{{ route('circuits.show', $circuit->slug) }}">
                    <div class="h-48 bg-gray-300 relative">
                        @if($circuit->getFirstMediaUrl('images'))
                        <img src="{{ $circuit->getFirstMediaUrl('images') }}" alt="{{ $circuit->titre }}" class="w-full h-full object-cover">
                        @else
                        <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="{{ $circuit->titre }}" class="w-full h-full object-cover">
                        @endif
                        @if($circuit->prix_promo)
                        <div class="absolute top-2 right-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded">
                            Promo
                        </div>
                        @endif
                        <div class="absolute bottom-0 left-0 p-4 text-white">
                            <h3 class="text-xl font-bold">{{ $circuit->titre }}</h3>
                            <div class="flex items-center mt-1">
                                <i class="fas fa-calendar-alt mr-1"></i>
                                <span class="text-sm">{{ $circuit->duree }} jours</span>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            @if($circuit->prix_promo)
                            <span class="text-lg font-bold text-green-600">{{ number_format($circuit->prix_promo, 0, ',', ' ') }} FCFA</span>
                            <span class="text-sm text-gray-500 line-through ml-2">{{ number_format($circuit->prix, 0, ',', ' ') }} FCFA</span>
                            @else
                            <span class="text-lg font-bold text-green-600">{{ number_format($circuit->prix, 0, ',', ' ') }} FCFA</span>
                            @endif
                        </div>
                        <div class="text-yellow-500">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $circuit->note_moyenne)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                    </div>
                    <a href="{{ route('circuits.show', $circuit->slug) }}" class="block w-full mt-4 bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md text-center transition duration-300">
                        Voir le circuit
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-8">
            <a href="{{ route('circuits.index') }}?destination={{ $destination->id }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                Voir tous les circuits pour {{ $destination->name }}
            </a>
        </div>
    </div>
    @endif
</div>
@endsection