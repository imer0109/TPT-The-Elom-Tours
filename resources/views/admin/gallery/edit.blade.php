@extends('layouts.admin')

@section('title', 'MODIFIER UNE IMAGE DE LA GALERIE - THE ELOM TOURS')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Modifier une image de la galerie</h1>
        <a href="{{ route('admin.gallery.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-md transition duration-300">
            <i class="fas fa-arrow-left mr-1"></i> Retour à la galerie
        </a>
    </div>
    
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <form action="{{ route('admin.gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Titre -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titre <span class="text-red-500">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title', $gallery->title) }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <!-- Catégorie -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Catégorie <span class="text-red-500">*</span></label>
                    <input type="text" id="category" name="category" value="{{ old('category', $gallery->category) }}" required list="category-list" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <datalist id="category-list">
                        @foreach($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </datalist>
                </div>
                
                <!-- Ordre -->
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Ordre <span class="text-red-500">*</span></label>
                    <input type="number" id="order" name="order" value="{{ old('order', $gallery->order) }}" required min="1" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-sm text-gray-500 mt-1">Position d'affichage dans la galerie (1 = premier)</p>
                </div>
                
                <!-- Statut -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <div class="flex items-center mt-2">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $gallery->is_active) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">Activer</label>
                    </div>
                </div>
                
                <!-- Image actuelle -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Image actuelle</label>
                    @if($gallery->image)
                        <div class="mt-2 mb-4">
                            <img src="{{ asset('storage/' . $gallery->image->path) }}" alt="{{ $gallery->title }}" class="h-48 object-cover rounded-md">
                        </div>
                    @else
                        <p class="text-gray-500 italic">Aucune image</p>
                    @endif
                </div>
                
                <!-- Nouvelle image -->
                <div class="md:col-span-2">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Nouvelle image</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <div id="preview" class="hidden mb-3">
                                <img id="preview-image" src="#" alt="Aperçu de l'image" class="mx-auto h-32 object-cover">
                            </div>
                            <div class="flex text-sm text-gray-600">
                                <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                    <span>Télécharger un fichier</span>
                                    <input id="image" name="image" type="file" accept="image/*" class="sr-only" onchange="previewImage()">
                                </label>
                                <p class="pl-1">ou glisser-déposer</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF jusqu'à 5MB</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Laissez vide pour conserver l'image actuelle</p>
                </div>
                
                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea id="description" name="description" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $gallery->description) }}</textarea>
                </div>
            </div>
            
            <div class="mt-6 flex justify-end">
                <button type="button" onclick="window.history.back()" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-md transition duration-300 mr-2">
                    Annuler
                </button>
                <button type="submit" class="bg-primary hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition duration-300">
                    <i class="fas fa-save mr-1"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function previewImage() {
        const preview = document.getElementById('preview');
        const previewImage = document.getElementById('preview-image');
        const file = document.getElementById('image').files[0];
        const reader = new FileReader();
        
        reader.onloadend = function() {
            previewImage.src = reader.result;
            preview.classList.remove('hidden');
        }
        
        if (file) {
            reader.readAsDataURL(file);
        } else {
            previewImage.src = '';
            preview.classList.add('hidden');
        }
    }
</script>
@endsection