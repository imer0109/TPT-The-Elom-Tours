@extends('layouts.admin')

@section('title', 'Créer un article - The Elom Tours')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Créer un nouvel article</h1>
            <a href="{{ route('admin.blogs.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>

        <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg overflow-hidden">
            @csrf

            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div class="col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Titre</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}"
                            class="form-input w-full rounded-md shadow-sm @error('title') border py-2 border-red-500 @enderror"
                            required>
                        @error('title')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2">
                        <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">Extrait</label>
                        <textarea name="excerpt" id="excerpt" rows="3"
                            class="form-textarea w-full rounded-md shadow-sm @error('excerpt') border-red-500 @enderror"
                        >{{ old('excerpt') }}</textarea>
                        @error('excerpt')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2">
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Contenu</label>
                        <textarea name="content" id="content" rows="10"
                            class="form-textarea w-full rounded-md shadow-sm @error('content') border-red-500 @enderror"
                            required
                        >{{ old('content') }}</textarea>
                        @error('content')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
                        <select name="category_id" id="category_id"
                            class="form-select w-full rounded-md shadow-sm @error('category_id') border-red-500 @enderror"
                            required>
                            <option value="">Sélectionner une catégorie</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">Image à la une</label>
                        <input type="file" name="featured_image" id="featured_image"
                            class="form-input w-full rounded-md shadow-sm @error('featured_image') border-red-500 @enderror"
                            accept="image/*">
                        @error('featured_image')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">SEO</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">Titre SEO</label>
                                <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}"
                                    class="form-input w-full rounded-md shadow-sm @error('meta_title') border-red-500 @enderror">
                                @error('meta_title')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">Description SEO</label>
                                <textarea name="meta_description" id="meta_description" rows="2"
                                    class="form-textarea w-full rounded-md shadow-sm @error('meta_description') border-red-500 @enderror"
                                >{{ old('meta_description') }}</textarea>
                                @error('meta_description')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-2">Mots-clés SEO</label>
                                <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords') }}"
                                    class="form-input w-full rounded-md shadow-sm @error('meta_keywords') border-red-500 @enderror"
                                    placeholder="Séparez les mots-clés par des virgules">
                                @error('meta_keywords')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-span-2 space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1"
                                class="form-checkbox h-4 w-4 text-primary rounded border-gray-300"
                                {{ old('is_featured') ? 'checked' : '' }}>
                            <label for="is_featured" class="ml-2 text-sm text-gray-700">Article mis en avant</label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                class="form-checkbox h-4 w-4 text-primary rounded border-gray-300"
                                {{ old('is_active', true) ? 'checked' : '' }}>
                            <label for="is_active" class="ml-2 text-sm text-gray-700">Article actif</label>
                        </div>

                        <div>
                            <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">Date de publication</label>
                            <input type="datetime-local" name="published_at" id="published_at"
                                value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}"
                                class="form-input w-full rounded-md shadow-sm @error('published_at') border-red-500 @enderror">
                            @error('published_at')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                <button type="submit" name="action" value="draft" class="btn-secondary">
                    <i class="fas fa-save mr-2"></i>Enregistrer comme brouillon
                </button>
                <button type="submit" name="action" value="publish" class="btn-primary">
                    <i class="fas fa-paper-plane mr-2"></i>Publier
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.tiny.cloud/1/your-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#content',
        height: 500,
        menubar: true,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'undo redo | formatselect | bold italic backcolor | \
            alignleft aligncenter alignright alignjustify | \
            bullist numlist outdent indent | removeformat | help'
    });
</script>
@endpush

@endsection