@extends('layouts.admin')

@section('title', $blog->title . ' - The Elom Tours')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">{{ $blog->title }}</h1>
            <div class="flex space-x-2">
                <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn-secondary">
                    <i class="fas fa-edit mr-2"></i>Modifier
                </a>
                <a href="{{ route('admin.blogs.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>Retour
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6">
                <!-- Image à la une -->
                @if($blog->featured_image)
                <div class="mb-6">
                    <img src="{{ Storage::url($blog->featured_image) }}" alt="{{ $blog->title }}" 
                         class="w-full h-64 object-cover rounded-lg">
                </div>
                @endif

                <!-- Informations principales -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Informations générales</h3>
                        <dl class="space-y-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Statut</dt>
                                <dd>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $blog->status_color }}-100 text-{{ $blog->status_color }}-800">
                                        {{ $blog->status_label }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Catégorie</dt>
                                <dd class="text-sm text-gray-900">{{ $blog->category->name ?? 'Non catégorisé' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Auteur</dt>
                                <dd class="text-sm text-gray-900">{{ $blog->user->name ?? 'Non défini' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Date de création</dt>
                                <dd class="text-sm text-gray-900">{{ $blog->created_at->format('d/m/Y H:i') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Date de publication</dt>
                                <dd class="text-sm text-gray-900">{{ $blog->published_at ? $blog->published_at->format('d/m/Y H:i') : 'Non publié' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Mis en avant</dt>
                                <dd class="text-sm text-gray-900">{{ $blog->is_featured ? 'Oui' : 'Non' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">SEO</h3>
                        <dl class="space-y-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Titre SEO</dt>
                                <dd class="text-sm text-gray-900">{{ $blog->meta_title ?: 'Non défini' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Description SEO</dt>
                                <dd class="text-sm text-gray-900">{{ $blog->meta_description ?: 'Non définie' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Mots-clés SEO</dt>
                                <dd class="text-sm text-gray-900">{{ $blog->meta_keywords ?: 'Non définis' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Slug</dt>
                                <dd class="text-sm text-gray-900">{{ $blog->slug }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Extrait -->
                @if($blog->excerpt)
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Extrait</h3>
                    <div class="text-gray-700 bg-gray-50 p-4 rounded">
                        {{ $blog->excerpt }}
                    </div>
                </div>
                @endif

                <!-- Contenu -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Contenu</h3>
                    <div class="prose max-w-none">
                        {!! $blog->content !!}
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <form action="{{ route('admin.blogs.toggle-published', $blog) }}" method="POST" class="inline-block">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn-secondary">
                            @if($blog->is_published)
                            <i class="fas fa-eye-slash mr-2"></i>Dépublier
                            @else
                            <i class="fas fa-eye mr-2"></i>Publier
                            @endif
                        </button>
                    </form>

                    <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
                            <i class="fas fa-trash mr-2"></i>Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection