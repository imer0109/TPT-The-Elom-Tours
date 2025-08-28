@extends('layouts.app')

@section('title', 'Nos destinations - The Elom Tours')

@section('content')
<div class="container mx-auto px-4 py-12">
    <!-- Hero Section -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Nos destinations</h1>
        <p class="text-lg text-gray-600 max-w-3xl mx-auto">Découvrez nos destinations de voyage soigneusement sélectionnées pour vous offrir des expériences inoubliables au Togo et en Afrique de l'Ouest.</p>
    </div>
    
    <!-- Popular Destinations -->
    @if($popularDestinations->count() > 0)
    <div class="mb-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Destinations populaires</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($popularDestinations as $destination)
            <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:shadow-lg hover:-translate-y-1">
                <a href="{{ route('destinations.show', $destination->slug) }}">
                    <div class="h-48 bg-gray-300 relative">
                        @if($destination->getFirstMediaUrl('images'))
                        <img src="{{ $destination->getFirstMediaUrl('images') }}" alt="{{ $destination->name }}" class="w-full h-full object-cover">
                        @else
                        <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="{{ $destination->name }}" class="w-full h-full object-cover">
                        @endif
                        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                        <div class="absolute bottom-0 left-0 p-4 text-white">
                            <h3 class="text-xl font-bold">{{ $destination->name }}</h3>
                            <p class="text-sm">{{ $destination->country }}</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    
    <!-- All Destinations -->
    <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Toutes nos destinations</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($destinations as $destination)
            <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:shadow-lg hover:-translate-y-1">
                <a href="{{ route('destinations.show', $destination->slug) }}">
                    <div class="h-48 bg-gray-300 relative">
                        @if($destination->getFirstMediaUrl('images'))
                        <img src="{{ $destination->getFirstMediaUrl('images') }}" alt="{{ $destination->name }}" class="w-full h-full object-cover">
                        @else
                        <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="{{ $destination->name }}" class="w-full h-full object-cover">
                        @endif
                        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                        <div class="absolute bottom-0 left-0 p-4 text-white">
                            <h3 class="text-xl font-bold">{{ $destination->name }}</h3>
                            <p class="text-sm">{{ $destination->country }}</p>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-span-full text-center py-8">
                <p class="text-gray-500">Aucune destination disponible pour le moment.</p>
            </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
            {{ $destinations->links() }}
        </div>
    </div>
</div>
@endsection