@extends('layouts.admin')

@section('title', $blogPost->title . ' - THE ELOM TOURS')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">{{ $blogPost->title }}</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.blog.edit', $blogPost) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md transition duration-300">
                <i class="fas fa-edit mr-1"></i> Modifier
            </a>
            <a href="{{ route('admin.blog.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-md transition duration-300">
                <i class="fas fa-arrow-left mr-1"></i> Retour à la liste
            </a>
        </div>
    </div>
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- En-tête de l'article -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                <div>
                    <div class="flex items-center mb-2">
                        <span class="{{ $blogPost->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} px-2 py-1 rounded-full text-xs font-medium mr-2">
                            {{ $blogPost->is_active ? 'Actif' : 'Inactif' }}
                        </span>
                        <span class="{{ $blogPost->is_featured ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }} px-2 py-1 rounded-full text-xs font-medium">
                            {{ $blogPost->is_featured ? 'Mis en avant' : 'Standard' }}
                        </span>
                    </div>
                    <div class="text-sm text-gray-500">
                        <span><i class="fas fa-user mr-1"></i> {{ $blogPost->user->name ?? 'Inconnu' }}</span>
                        <span class="mx-2">|</span>
                        <span><i class="fas fa-folder mr-1"></i> {{ $blogPost->category->name ?? 'Non catégorisé' }}</span>
                        <span class="mx-2">|</span>
                        <span><i class="fas fa-calendar mr-1"></i> Créé le {{ $blogPost->created_at->format('d/m/Y H:i') }}</span>
                        @if($blogPost->published_at)
                            <span class="mx-2">|</span>
                            <span><i class="fas fa-clock mr-1"></i> Publié le {{ $blogPost->published_at->format('d/m/Y H:i') }}</span>
                        @endif
                    </div>
                </div>
                <div class="mt-4 md:mt-0">
                    <form action="{{ route('admin.blog.destroy', $blogPost) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md transition duration-300">
                            <i class="fas fa-trash mr-1"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Image à la une -->
        @if($blogPost->image)
            <div class="border-b border-gray-200">
                <img src="{{ Storage::url($blogPost->image->path) }}" alt="{{ $blogPost->title }}" class="w-full h-64 object-cover">
            </div>
        @endif
        
        <!-- Contenu de l'article -->
        <div class="p-6">
            @if($blogPost->excerpt)
                <div class="bg-gray-50 p-4 rounded-md mb-6 italic">
                    {{ $blogPost->excerpt }}
                </div>
            @endif
            
            <div class="prose max-w-none">
                {!! nl2br(e($blogPost->content)) !!}
            </div>
        </div>
        
        <!-- Informations SEO -->
        <div class="p-6 bg-gray-50 border-t border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Informations SEO</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-1">Meta Titre</h4>
                    <p class="text-sm text-gray-500">{{ $blogPost->meta_title ?: 'Non défini' }}</p>
                </div>
                
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-1">Meta Description</h4>
                    <p class="text-sm text-gray-500">{{ $blogPost->meta_description ?: 'Non définie' }}</p>
                </div>
                
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-1">Meta Mots-clés</h4>
                    <p class="text-sm text-gray-500">{{ $blogPost->meta_keywords ?: 'Non définis' }}</p>
                </div>
                
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-1">Slug</h4>
                    <p class="text-sm text-gray-500">{{ $blogPost->slug }}</p>
                </div>
            </div>
        </div>
        
        <!-- Commentaires -->
        <div class="p-6 border-t border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Commentaires ({{ $blogPost->comments->count() }})</h3>
            
            @if($blogPost->comments->count() > 0)
                <div class="space-y-4">
                    @foreach($blogPost->comments as $comment)
                        <div class="bg-gray-50 p-4 rounded-md">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">{{ $comment->name }}</h4>
                                    <p class="text-xs text-gray-500">{{ $comment->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div>
                                    <form action="#" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="mt-2">
                                <p class="text-sm text-gray-700">{{ $comment->content }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Aucun commentaire pour cet article.</p>
            @endif
        </div>
    </div>
</div>
@endsection