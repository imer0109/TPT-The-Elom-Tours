@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    <div class="max-w-4xl mx-auto">
        <!-- Image principale -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8 mt-40">
            @if($gallery->image)
                <img src="{{ asset('storage/' . $gallery->image->path) }}" 
                     alt="{{ $gallery->title }}" 
                     class="w-full h-96 object-cover">
            @endif
            <div class="p-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $gallery->title }}</h1>
                @if($gallery->description)
                    <p class="text-gray-600">{{ $gallery->description }}</p>
                @endif
                <div class="mt-4 text-sm text-gray-500">
                    <p>Ajouté le {{ $gallery->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Images connexes -->
        @if($relatedGalleries->isNotEmpty())
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Images similaires</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach($relatedGalleries as $relatedGallery)
                        <a href="{{ route('gallery.show', $relatedGallery) }}" 
                           class="block bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:scale-105">
                            @if($relatedGallery->image)
                                <div class="aspect-w-4 aspect-h-3">
                                    <img src="{{ asset('storage/' . $relatedGallery->image->path) }}" 
                                         alt="{{ $relatedGallery->title }}" 
                                         class="w-full h-full object-cover">
                                </div>
                            @endif
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $relatedGallery->title }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Bouton retour -->
        <div class="mt-8 text-center">
            <a href="{{ route('gallery.index') }}" 
               class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <svg class="-ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Retour à la galerie
            </a>
        </div>
    </div>
</div>
@endsection