@extends('layouts.admin')

@section('title', 'DETAILS DU MESSAGE - THE ELOM TOURS')

@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700">
        Détails du message
    </h2>
    
    <!-- Carte de détails du message -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- En-tête avec informations de l'expéditeur -->
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">{{ $message->subject }}</h3>
                    <div class="mt-1 flex items-center">
                        <span class="text-sm text-gray-600">De: <strong>{{ $message->name }}</strong> &lt;{{ $message->email }}&gt;</span>
                        @if($message->phone)
                            <span class="ml-4 text-sm text-gray-600">Tél: {{ $message->phone }}</span>
                        @endif
                    </div>
                    <div class="mt-1 text-sm text-gray-500">
                        Reçu le {{ $message->created_at->format('d/m/Y à H:i') }}
                    </div>
                </div>
                <div class="mt-4 md:mt-0 flex space-x-2">
                    <form action="{{ route('admin.messages.toggle-archived', $message) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="px-3 py-2 text-sm font-medium rounded-md {{ $message->is_archived ? 'bg-blue-100 text-blue-800 hover:bg-blue-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                            <i class="fas {{ $message->is_archived ? 'fa-box-open' : 'fa-archive' }} mr-1"></i>
                            {{ $message->is_archived ? 'Désarchiver' : 'Archiver' }}
                        </button>
                    </form>
                    <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-2 text-sm font-medium rounded-md bg-red-100 text-red-800 hover:bg-red-200">
                            <i class="fas fa-trash mr-1"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Corps du message -->
        <div class="px-6 py-4">
            <div class="prose max-w-none">
                {!! nl2br(e($message->message)) !!}
            </div>
        </div>
        
        <!-- Formulaire de réponse -->
        <div class="border-t border-gray-200 px-6 py-4 bg-gray-50">
            <h4 class="text-lg font-medium text-gray-900 mb-4">Répondre</h4>
            <form action="{{ route('admin.messages.reply', $message) }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="reply_content" class="block text-sm font-medium text-gray-700 mb-1">Votre réponse</label>
                    <textarea id="reply_content" name="reply_content" rows="6" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 @error('reply_content') border-red-500 @enderror" placeholder="Écrivez votre réponse ici...">{{ old('reply_content') }}</textarea>
                    @error('reply_content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex justify-end">
                    <a href="{{ route('admin.messages.index') }}" class="px-4 py-2 mr-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Annuler
                    </a>
                    <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Envoyer la réponse
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Bouton de retour -->
    <div class="mt-6">
        <a href="{{ route('admin.messages.index') }}" class="flex items-center text-sm text-gray-600 hover:text-gray-900">
            <i class="fas fa-arrow-left mr-2"></i> Retour à la liste des messages
        </a>
    </div>
</div>
@endsection