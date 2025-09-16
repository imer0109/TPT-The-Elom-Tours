@extends('layouts.admin')

@section('title', 'DÉTAILS DE L\'IMAGE - THE ELOM TOURS')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Détails de l'image</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.gallery.edit', $gallery->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition duration-300">
                <i class="fas fa-edit mr-1"></i> Modifier
            </a>
            <a href="{{ route('admin.gallery.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-md transition duration-300">
                <i class="fas fa-arrow-left mr-1"></i> Retour à la galerie
            </a>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Image -->
        <div class="md:col-span-2 bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-4">Image</h2>
                @if($gallery->image)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $gallery->image->path) }}" alt="{{ $gallery->title }}" class="w-full h-auto rounded-md">
                    </div>
                @else
                    <div class="bg-gray-100 p-4 rounded-md text-center">
                        <p class="text-gray-500 italic">Aucune image disponible</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Informations -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-4">Informations</h2>
                
                <div class="space-y-4">
                    <!-- Statut -->
                    <div class="flex items-center">
                        <span class="font-medium mr-2">Statut:</span>
                        @if($gallery->is_active)
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Actif</span>
                        @else
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Inactif</span>
                        @endif
                    </div>
                    
                    <!-- Titre -->
                    <div>
                        <span class="font-medium">Titre:</span>
                        <p class="mt-1">{{ $gallery->title }}</p>
                    </div>
                    
                    <!-- Catégorie -->
                    <div>
                        <span class="font-medium">Catégorie:</span>
                        <p class="mt-1">{{ $gallery->category }}</p>
                    </div>
                    
                    <!-- Ordre -->
                    <div>
                        <span class="font-medium">Ordre d'affichage:</span>
                        <p class="mt-1">{{ $gallery->order }}</p>
                    </div>
                    
                    <!-- Description -->
                    <div>
                        <span class="font-medium">Description:</span>
                        <p class="mt-1">{{ $gallery->description ?: 'Aucune description' }}</p>
                    </div>
                    
                    <!-- Dates -->
                    <div>
                        <span class="font-medium">Créé le:</span>
                        <p class="mt-1">{{ $gallery->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    
                    <div>
                        <span class="font-medium">Dernière modification:</span>
                        <p class="mt-1">{{ $gallery->updated_at->format('d/m/Y à H:i') }}</p>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="mt-6 border-t pt-4">
                    <h3 class="font-medium mb-3">Actions</h3>
                    <div class="flex flex-col space-y-2">
                        <a href="{{ route('admin.gallery.edit', $gallery->id) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                            <i class="fas fa-edit mr-1"></i> Modifier cette image
                        </a>
                        
                        <form action="{{ route('admin.gallery.toggle-active', $gallery->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex items-center text-{{ $gallery->is_active ? 'orange' : 'green' }}-600 hover:text-{{ $gallery->is_active ? 'orange' : 'green' }}-800">
                                <i class="fas fa-{{ $gallery->is_active ? 'eye-slash' : 'eye' }} mr-1"></i> 
                                {{ $gallery->is_active ? 'Désactiver' : 'Activer' }} cette image
                            </button>
                        </form>
                        
                        <form action="{{ route('admin.gallery.destroy', $gallery->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette image ? Cette action est irréversible.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center text-red-600 hover:text-red-800">
                                <i class="fas fa-trash-alt mr-1"></i> Supprimer cette image
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection