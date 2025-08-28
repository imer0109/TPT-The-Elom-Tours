@extends('layouts.admin')

@section('title', 'Modifier un article de blog - The Elom Tours')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Modifier un article de blog</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.blog.show', $blogPost) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-300">
                <i class="fas fa-eye mr-1"></i> Voir
            </a>
            <a href="{{ route('admin.blog.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-md transition duration-300">
                <i class="fas fa-arrow-left mr-1"></i> Retour à la liste
            </a>
        </div>
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
        <form action="{{ route('admin.blog.update', $blogPost) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Titre -->
                <div class="col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titre <span class="text-red-500">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title', $blogPost->title) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                </div>
                
                <!-- Catégorie -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Catégorie <span class="text-red-500">*</span></label>
                    <select id="category_id" name="category_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        <option value="">Sélectionner une catégorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $blogPost->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Date de publication -->
                <div>
                    <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">Date de publication</label>
                    <input type="datetime-local" id="published_at" name="published_at" value="{{ old('published_at', $blogPost->published_at ? $blogPost->published_at->format('Y-m-d\TH:i') : '') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    <p class="text-sm text-gray-500 mt-1">Laissez vide pour enregistrer comme brouillon</p>
                </div>
                
                <!-- Image -->
                <div class="col-span-2">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image à la une</label>
                    @if($blogPost->image)
                        <div class="mb-2">
                            <img src="{{ Storage::url($blogPost->image->path) }}" alt="{{ $blogPost->title }}" class="h-32 w-auto object-cover rounded-md">
                            <p class="text-sm text-gray-500 mt-1">Image actuelle</p>
                        </div>
                    @endif
                    <input type="file" id="image" name="image" accept="image/*" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    <p class="text-sm text-gray-500 mt-1">Télécharger une nouvelle image pour remplacer l'actuelle</p>
                </div>
                
                <!-- Extrait -->
                <div class="col-span-2">
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-1">Extrait</label>
                    <textarea id="excerpt" name="excerpt" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">{{ old('excerpt', $blogPost->excerpt) }}</textarea>
                    <p class="text-sm text-gray-500 mt-1">Un court résumé de l'article (max 500 caractères)</p>
                </div>
                
                <!-- Contenu -->
                <div class="col-span-2">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Contenu <span class="text-red-500">*</span></label>
                    <textarea id="content" name="content" rows="10" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">{{ old('content', $blogPost->content) }}</textarea>
                </div>
                
                <!-- SEO -->
                <div class="col-span-2 mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">SEO</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">Meta Titre</label>
                            <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $blogPost->meta_title) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        </div>
                        
                        <div class="col-span-2">
                            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                            <textarea id="meta_description" name="meta_description" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">{{ old('meta_description', $blogPost->meta_description) }}</textarea>
                        </div>
                        
                        <div class="col-span-2">
                            <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-1">Meta Mots-clés</label>
                            <input type="text" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $blogPost->meta_keywords) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            <p class="text-sm text-gray-500 mt-1">Séparez les mots-clés par des virgules</p>
                        </div>
                    </div>
                </div>
                
                <!-- Options -->
                <div class="col-span-2 mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Options</h3>
                    
                    <div class="flex flex-col space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $blogPost->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-primary focus:ring-primary">
                            <label for="is_active" class="ml-2 text-sm text-gray-700">Activer l'article</label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $blogPost->is_featured) ? 'checked' : '' }} class="rounded border-gray-300 text-primary focus:ring-primary">
                            <label for="is_featured" class="ml-2 text-sm text-gray-700">Mettre en avant sur la page d'accueil</label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-primary hover:bg-green-700 text-white font-medium py-2 px-6 rounded-md transition duration-300">
                    <i class="fas fa-save mr-1"></i> Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Initialiser l'éditeur de texte riche pour le contenu
    document.addEventListener('DOMContentLoaded', function() {
        // Vous pouvez ajouter ici l'initialisation d'un éditeur WYSIWYG comme TinyMCE, CKEditor, etc.
        // Exemple avec TinyMCE (nécessite d'inclure la bibliothèque) :
        // tinymce.init({
        //     selector: '#content',
        //     plugins: 'link image code table lists',
        //     toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code'
        // });
    });
</script>
@endpush