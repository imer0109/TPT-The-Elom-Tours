@extends('layouts.admin')

@section('title', 'GESTION DE LA GALERIE - THE ELOM TOURS')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Gestion de la galerie</h1>
        <a href="{{ route('admin.gallery.create') }}" class="bg-primary hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition duration-300">
            <i class="fas fa-plus mr-1"></i> Ajouter une image
        </a>
    </div>
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    
    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form action="{{ route('admin.gallery.index') }}" method="GET" class="flex flex-wrap gap-4">
            <div class="w-full md:w-auto">
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                <select id="category" name="category" class="w-full md:w-48 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Toutes</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="w-full md:w-auto">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                <select id="status" name="status" class="w-full md:w-48 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Tous</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actif</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactif</option>
                </select>
            </div>
            
            <div class="w-full md:w-auto">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
                <div class="relative">
                    <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Rechercher par titre..." class="w-full md:w-64 border border-gray-300 rounded-md pl-10 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>
            </div>
            
            <div class="w-full md:w-auto flex items-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition duration-300">
                    <i class="fas fa-filter mr-1"></i> Filtrer
                </button>
                <a href="{{ route('admin.gallery.index') }}" class="ml-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-md transition duration-300">
                    <i class="fas fa-times mr-1"></i> Réinitialiser
                </a>
            </div>
        </form>
    </div>
    
    <!-- Galerie -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        @if($galleryItems->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-6">
                @foreach($galleryItems as $item)
                    <div class="bg-gray-50 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition duration-300">
                        <div class="relative aspect-w-16 aspect-h-9 bg-gray-200">
                            @if($item->image)
                                <img src="{{ Storage::url($item->image->path) }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 flex items-center justify-center bg-gray-200 text-gray-400">
                                    <i class="fas fa-image text-4xl"></i>
                                </div>
                            @endif
                            
                            <div class="absolute top-2 right-2 flex space-x-1">
                                <span class="px-2 py-1 text-xs rounded-full {{ $item->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $item->is_active ? 'Actif' : 'Inactif' }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <h3 class="font-medium text-gray-900 truncate">{{ $item->title }}</h3>
                            <p class="text-sm text-gray-500 mt-1">Catégorie: {{ $item->category }}</p>
                            <p class="text-sm text-gray-500">Ordre: {{ $item->order }}</p>
                            
                            <div class="mt-4 flex justify-between items-center">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.gallery.show', $item) }}" class="text-blue-500 hover:text-blue-700" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.gallery.edit', $item) }}" class="text-yellow-500 hover:text-yellow-700" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.gallery.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                
                                <form action="{{ route('admin.gallery.toggle-active', $item) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-sm {{ $item->is_active ? 'text-red-500 hover:text-red-700' : 'text-green-500 hover:text-green-700' }}">
                                        {{ $item->is_active ? 'Désactiver' : 'Activer' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $galleryItems->appends(request()->query())->links() }}
            </div>
        @else
            <div class="p-6 text-center">
                <p class="text-gray-500">Aucun élément trouvé dans la galerie.</p>
                <a href="{{ route('admin.gallery.create') }}" class="mt-4 inline-block bg-primary hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition duration-300">
                    <i class="fas fa-plus mr-1"></i> Ajouter une image
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Script pour la réorganisation des éléments (à implémenter avec Sortable.js ou similaire)
    document.addEventListener('DOMContentLoaded', function() {
        // Code pour le drag and drop des images
    });
</script>
@endsection