@extends('layouts.admin')

@section('title', 'Gestion des articles de blog - The Elom Tours')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Gestion des articles de blog</h1>
        <a href="{{ route('admin.blog.create') }}" 
           class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition duration-300">
            <i class="fas fa-plus mr-1"></i> Nouvel article
        </a>
    </div>
    
    {{-- Messages de succès ou d'erreur --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <span>{{ session('success') }}</span>
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <span>{{ session('error') }}</span>
        </div>
    @endif
    
    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form action="{{ route('admin.blog.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                <select id="category" name="category" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-600 focus:ring focus:ring-green-600 focus:ring-opacity-50">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                            {{ $category->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                <select id="status" name="status" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-600 focus:ring focus:ring-green-600 focus:ring-opacity-50">
                    <option value="">Tous les statuts</option>
                    <option value="active" @selected(request('status') == 'active')>Actif</option>
                    <option value="inactive" @selected(request('status') == 'inactive')>Inactif</option>
                </select>
            </div>
            
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}" 
                       placeholder="Rechercher par titre..." 
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-600 focus:ring focus:ring-green-600 focus:ring-opacity-50">
            </div>
            
            <div class="flex items-end">
                <button type="submit" 
                        class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition duration-300">
                    <i class="fas fa-search mr-1"></i> Filtrer
                </button>
                <a href="{{ route('admin.blog.index') }}" 
                   class="ml-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-md transition duration-300">
                    <i class="fas fa-times mr-1"></i> Réinitialiser
                </a>
            </div>
        </form>
    </div>
    
    <!-- Tableau des articles -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catégorie</th>
                    <!-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Auteur</th> -->
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date de publication</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mis en avant</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($blogPosts as $post)
                    <tr>
                        <td class="px-6 py-4 flex items-center">
                            @if($post->image)
                                <img class="h-10 w-10 rounded-md object-cover mr-3" 
                                     src="{{ Storage::url($post->image->path) }}"  
                                     alt="{{ $post->title }}">
                            @endif
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $post->title }}</div>
                                <div class="text-sm text-gray-500">
                                    {{ Str::limit($post->excerpt ?? Str::words(strip_tags($post->content), 10), 50) }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">{{ $post->category->nom ?? 'Non catégorisé' }}</td>
                        <!-- <td class="px-6 py-4">{{ $post->user->name ?? 'Inconnu' }}</td> -->
                        <td class="px-6 py-4">{{ $post->published_at ? $post->published_at->format('d/m/Y H:i') : 'Non publié' }}</td>
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.blog.toggle-active', $post) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="{{ $post->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} px-2 py-1 rounded-full text-xs font-medium"
                                        aria-label="Changer le statut">
                                    {{ $post->is_active ? 'Actif' : 'Inactif' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.blog.toggle-featured', $post) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="{{ $post->is_featured ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }} px-2 py-1 rounded-full text-xs font-medium"
                                        aria-label="Changer la mise en avant">
                                    {{ $post->is_featured ? 'Mis en avant' : 'Standard' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium flex space-x-2">
                            <a href="{{ route('admin.blog.show', $post) }}" class="text-blue-600 hover:text-blue-900" aria-label="Voir">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.blog.edit', $post) }}" class="text-indigo-600 hover:text-indigo-900" aria-label="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if(!$post->published_at)
                            <form action="{{ route('admin.blog.publish', $post) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-green-600 hover:text-green-900" aria-label="Publier">
                                    <i class="fas fa-upload"></i>
                                </button>
                            </form>
                            @else
                            <form action="{{ route('admin.blog.unpublish', $post) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-yellow-600 hover:text-yellow-900" aria-label="Dépublier">
                                    <i class="fas fa-download"></i>
                                </button>
                            </form>
                            @endif
                            <form action="{{ route('admin.blog.destroy', $post) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" aria-label="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Aucun article de blog trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="mt-6 flex justify-center">
        {{ $blogPosts->appends(request()->query())->links('pagination::tailwind') }}
    </div>
</div>
@endsection
