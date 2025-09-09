@extends('layouts.admin')

@section('title', 'Ajouter une destination - The Elom Tours')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Ajouter une destination</h1>
        <a href="{{ route('admin.destinations.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition duration-300">
            <i class="fas fa-arrow-left mr-1"></i> Retour à la liste
        </a>
    </div>
    
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.destinations.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <p class="text-xs text-gray-500 mt-1">Le slug sera généré automatiquement à partir du nom.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Pays <span class="text-red-500">*</span></label>
                        <input type="text" id="country" name="country" value="{{ old('country') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Ville <span class="text-red-500">*</span></label>
                        <input type="text" id="city" name="city" value="{{ old('city') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                </div>
            </div>
            
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-red-500">*</span></label>
                <textarea id="description" name="description" rows="5" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('description') }}</textarea>
            </div>
            
            <!-- Ajouter ceci après la section description -->
            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image de la destination</label>
                <input type="file" id="image" name="image" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p class="text-xs text-gray-500 mt-1">Format recommandé : JPG, PNG. Taille max : 2MB</p>
            </div>
            
            <div class="mb-6">
                <div class="flex space-x-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">Activer cette destination</span>
                    </label>
                    
                    <label class="flex items-center">
                        <input type="checkbox" name="is_popular" value="1" {{ old('is_popular') ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">Marquer comme destination populaire</span>
                    </label>
                </div>
            </div>
            
            <div class="border-t border-gray-200 pt-4 mt-4">
                <h3 class="text-lg font-medium mb-4">SEO</h3>
                
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">Meta Titre</label>
                        <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Laissez vide pour utiliser le nom de la destination.</p>
                    </div>
                    
                    <div>
                        <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                        <textarea id="meta_description" name="meta_description" rows="2" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('meta_description') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Laissez vide pour utiliser un extrait de la description.</p>
                    </div>
                    
                    <div>
                        <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-1">Meta Mots-clés</label>
                        <input type="text" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Séparez les mots-clés par des virgules.</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-6">
                <button type="submit" class="bg-primary hover:bg-green-700 text-white font-medium py-2 px-6 rounded-md transition duration-300">
                    <i class="fas fa-save mr-1"></i> Enregistrer la destination
                </button>
            </div>
        </form>
    </div>
</div>
@endsection