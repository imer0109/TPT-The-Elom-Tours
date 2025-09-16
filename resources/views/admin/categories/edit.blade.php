@extends('layouts.admin')

@section('title', 'MODIFIER UNE CATÉGORIE - THE ELOM TOURS')

@section('content')
<div class="container mx-auto py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Modifier une catégorie</h1>
        <a href="{{ route('admin.categories.index') }}" class="btn-secondary flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Retour à la liste
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="nom" 
                           name="nom" 
                           value="{{ old('nom', $category->nom) }}" 
                           class="form-input w-full rounded-md shadow-sm @error('nom') border-red-500 @enderror" 
                           required>
                    @error('nom')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                    <input type="text" 
                           id="slug" 
                           name="slug" 
                           value="{{ old('slug', $category->slug) }}" 
                           class="form-input w-full rounded-md shadow-sm @error('slug') border-red-500 @enderror">
                    <p class="mt-1 text-sm text-gray-500">Laissez vide pour générer automatiquement à partir du nom.</p>
                    @error('slug')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea id="description" 
                              name="description" 
                              rows="4" 
                              class="form-textarea w-full rounded-md shadow-sm @error('description') border-red-500 @enderror">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="inline-flex items-center">
                        <input type="checkbox" 
                               class="form-checkbox rounded text-blue-600" 
                               name="est_actif" 
                               value="1" 
                               {{ old('est_actif', $category->est_actif) ? 'checked' : '' }}>
                        <span class="ml-2">Actif</span>
                    </label>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save mr-2"></i> Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-génération du slug à partir du nom si le slug est vide
    document.getElementById('nom').addEventListener('input', function() {
        const slugField = document.getElementById('slug');
        if (slugField.value === '') {
            const nom = this.value;
            const slug = nom.toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/(^-|-$)/g, '');
            slugField.value = slug;
        }
    });
</script>
@endpush

@endsection