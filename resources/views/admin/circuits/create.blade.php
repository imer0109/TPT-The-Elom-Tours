@extends('layouts.admin')

@section('title', 'Créer un circuit - The Elom Tours')

@section('content')
<div class="container mx-auto">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.circuits.index') }}" class="text-gray-600 hover:text-gray-900 mr-2">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold">Créer un nouveau circuit</h1>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.circuits.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Informations générales -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4 pb-2 border-b">Informations générales</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Titre -->
                    <div>
                        <label for="titre" class="block text-sm font-medium text-gray-700 mb-1">Titre du circuit <span class="text-red-500">*</span></label>
                        <input type="text" id="titre" name="titre" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5" required>
                    </div>
                    
                    <!-- Slug -->
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug (URL) <span class="text-red-500">*</span></label>
                        <input type="text" id="slug" name="slug" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5" required>
                        <p class="mt-1 text-xs text-gray-500">Sera généré automatiquement à partir du titre</p>
                    </div>
                    
                    <!-- Destination -->
                    <div>
                        <label for="destination" class="block text-sm font-medium text-gray-700 mb-1">Destination <span class="text-red-500">*</span></label>
                        <input type="text" id="destination" name="destination" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5" required>
                    </div>
                    
                    <!-- Durée -->
                    <div>
                        <label for="duree" class="block text-sm font-medium text-gray-700 mb-1">Durée (jours) <span class="text-red-500">*</span></label>
                        <input type="number" id="duree" name="duree" min="1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5" required>
                    </div>
                    
                    <!-- Prix -->
                    <div>
                        <label for="prix" class="block text-sm font-medium text-gray-700 mb-1">Prix par personne (€) <span class="text-red-500">*</span></label>
                        <input type="number" id="prix" name="prix" min="0" step="0.01" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5" required>
                    </div>
                    
                    <!-- Difficulté -->
                    <div>
                        <label for="difficulte" class="block text-sm font-medium text-gray-700 mb-1">Difficulté <span class="text-red-500">*</span></label>
                        <select id="difficulte" name="difficulte" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5" required>
                            <option value="">Sélectionner une difficulté</option>
                            <option value="facile">Facile</option>
                            <option value="modere">Modéré</option>
                            <option value="difficile">Difficile</option>
                        </select>
                    </div>
                    
                    <!-- Taille du groupe -->
                    <div>
                        <label for="taille_groupe" class="block text-sm font-medium text-gray-700 mb-1">Taille max. du groupe <span class="text-red-500">*</span></label>
                        <input type="number" id="taille_groupe" name="taille_groupe" min="1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5" required>
                    </div>
                    
                    <!-- Langues -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Langues disponibles <span class="text-red-500">*</span></label>
                        <div class="flex flex-wrap gap-4">
                            <div class="flex items-center">
                                <input type="checkbox" id="langue_fr" name="langues[]" value="fr" class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary">
                                <label for="langue_fr" class="ml-2 text-sm font-medium text-gray-900">Français</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="langue_en" name="langues[]" value="en" class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary">
                                <label for="langue_en" class="ml-2 text-sm font-medium text-gray-900">Anglais</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="langue_es" name="langues[]" value="es" class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary">
                                <label for="langue_es" class="ml-2 text-sm font-medium text-gray-900">Espagnol</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="langue_de" name="langues[]" value="de" class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary">
                                <label for="langue_de" class="ml-2 text-sm font-medium text-gray-900">Allemand</label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Statut -->
                    <div>
                        <label for="est_actif" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                        <div class="flex items-center">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="est_actif" name="est_actif" value="1" class="sr-only peer" checked>
                                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/50 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                <span class="ml-3 text-sm font-medium text-gray-900">Actif</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Description -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4 pb-2 border-b">Description</h2>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description détaillée <span class="text-red-500">*</span></label>
                    <textarea id="description" name="description" rows="6" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5" required></textarea>
                </div>
            </div>
            
            <!-- Image principale -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4 pb-2 border-b">Image principale</h2>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Image de couverture <span class="text-red-500">*</span></label>
                    <div class="flex items-center justify-center w-full">
                        <label for="image" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-500 mb-3"></i>
                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Cliquez pour télécharger</span> ou glissez-déposez</p>
                                <p class="text-xs text-gray-500">PNG, JPG ou WEBP (Max. 2MB)</p>
                            </div>
                            <input id="image" name="image" type="file" class="hidden" accept="image/*" required />
                        </label>
                    </div>
                    <div id="image-preview" class="mt-3 hidden">
                        <div class="relative">
                            <img id="preview-img" src="#" alt="Aperçu de l'image" class="max-h-64 rounded-lg">
                            <button type="button" id="remove-image" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Boutons d'action -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.circuits.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition-colors">
                    Annuler
                </a>
                <button type="submit" class="px-4 py-2 bg-primary hover:bg-green-700 text-white rounded-lg transition-colors">
                    Créer le circuit
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Génération automatique du slug à partir du titre
        const titreInput = document.getElementById('titre');
        const slugInput = document.getElementById('slug');
        
        titreInput.addEventListener('input', function() {
            const slug = this.value
                .toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');
            slugInput.value = slug;
        });
        
        // Prévisualisation de l'image
        const imageInput = document.getElementById('image');
        const previewContainer = document.getElementById('image-preview');
        const previewImage = document.getElementById('preview-img');
        const removeButton = document.getElementById('remove-image');
        
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                
                reader.addEventListener('load', function() {
                    previewImage.setAttribute('src', this.result);
                    previewContainer.classList.remove('hidden');
                });
                
                reader.readAsDataURL(file);
            }
        });
        
        removeButton.addEventListener('click', function() {
            imageInput.value = '';
            previewContainer.classList.add('hidden');
            previewImage.setAttribute('src', '#');
        });
    });
</script>
@endsection