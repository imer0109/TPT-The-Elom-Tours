@extends('layouts.admin')

@section('title', 'MODIFIER UN AVIS - THE ELOM TOURS')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Modifier un avis</h1>
        <a href="{{ route('admin.reviews.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition duration-300">
            <i class="fas fa-arrow-left mr-1"></i> Retour à la liste
        </a>
    </div>
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    
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
        <div class="mb-4">
            <p class="text-gray-600 mb-2"><strong>Circuit :</strong> {{ $review->circuit->titre ?? 'Circuit inconnu' }}</p>
            <p class="text-gray-600"><strong>Date de soumission :</strong> {{ $review->created_at->format('d/m/Y H:i') }}</p>
        </div>
        
        <form action="{{ route('admin.reviews.update', $review) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $review->name) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $review->email) }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Note</label>
                <div class="flex items-center space-x-2">
                    @for($i = 1; $i <= 5; $i++)
                        <div class="flex items-center">
                            <input type="radio" id="rating-{{ $i }}" name="rating" value="{{ $i }}" {{ old('rating', $review->rating) == $i ? 'checked' : '' }} class="mr-1">
                            <label for="rating-{{ $i }}" class="text-yellow-500 cursor-pointer">
                                <i class="fas fa-star"></i>
                                @if($i > 1)
                                    <span class="ml-1 text-gray-700">{{ $i }}</span>
                                @endif
                            </label>
                        </div>
                    @endfor
                </div>
            </div>
            
            <div class="mb-6">
                <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Commentaire</label>
                <textarea id="comment" name="comment" rows="5" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('comment', $review->comment) }}</textarea>
            </div>
            
            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_approved" value="1" {{ old('is_approved', $review->is_approved) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <span class="ml-2 text-sm text-gray-700">Approuver cet avis (visible publiquement)</span>
                </label>
            </div>
            
            <div class="flex justify-between">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md transition duration-300">
                    <i class="fas fa-save mr-1"></i> Enregistrer les modifications
                </button>
                
                <button type="button" onclick="confirmDeleteReview()" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-6 rounded-md transition duration-300">
                    <i class="fas fa-trash mr-1"></i> Supprimer
                </button>
                
                <form id="delete-review-form" action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    function confirmDeleteReview() {
        showConfirmModal({
            title: 'Supprimer l\'avis',
            message: 'Êtes-vous sûr de vouloir supprimer cet avis ? Cette action est irréversible.',
            confirmText: 'Oui, supprimer',
            cancelText: 'Annuler',
            action: function() {
                document.getElementById('delete-review-form').submit();
            }
        });
    }
</script>
@endsection
@endsection