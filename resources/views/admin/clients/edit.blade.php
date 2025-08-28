@extends('layouts.admin')

@section('title', 'Modifier un client - The Elom Tours')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Modifier le client</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.clients.show', $client) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition duration-300">
                <i class="fas fa-eye mr-1"></i> Voir détails
            </a>
            <a href="{{ route('admin.clients.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition duration-300">
                <i class="fas fa-arrow-left mr-1"></i> Retour à la liste
            </a>
        </div>
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
        <form action="{{ route('admin.clients.update', $client) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informations personnelles -->
                <div class="col-span-2">
                    <h2 class="text-lg font-medium mb-4 pb-2 border-b">Informations personnelles</h2>
                </div>
                
                <!-- Prénom -->
                <div>
                    <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom <span class="text-red-500">*</span></label>
                    <input type="text" id="prenom" name="prenom" value="{{ old('prenom', $client->prenom) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5" required>
                </div>
                
                <!-- Nom -->
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom <span class="text-red-500">*</span></label>
                    <input type="text" id="nom" name="nom" value="{{ old('nom', $client->nom) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5" required>
                </div>
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email', $client->email) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5" required>
                </div>
                
                <!-- Téléphone -->
                <div>
                    <label for="telephone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone <span class="text-red-500">*</span></label>
                    <input type="tel" id="telephone" name="telephone" value="{{ old('telephone', $client->telephone) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5" required>
                </div>
                
                <!-- Date de naissance -->
                <div>
                    <label for="date_naissance" class="block text-sm font-medium text-gray-700 mb-1">Date de naissance</label>
                    <input type="date" id="date_naissance" name="date_naissance" value="{{ old('date_naissance', $client->date_naissance ? $client->date_naissance->format('Y-m-d') : '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                </div>
                
                <!-- Photo -->
                <div>
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Photo</label>
                    <input type="file" id="photo" name="photo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                    <p class="text-xs text-gray-500 mt-1">Formats acceptés : JPG, PNG. Max 2Mo.</p>
                    
                    @if($client->file)
                        <div class="mt-2 flex items-center">
                            <img src="{{ asset('storage/' . $client->file->path) }}" alt="Photo de {{ $client->nom_complet }}" class="h-16 w-16 object-cover rounded-full">
                            <div class="ml-2">
                                <p class="text-sm">Photo actuelle</p>
                                <div class="flex items-center mt-1">
                                    <input type="checkbox" id="delete_photo" name="delete_photo" class="mr-2">
                                    <label for="delete_photo" class="text-xs text-red-600">Supprimer la photo</label>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Adresse -->
                <div class="col-span-2">
                    <h2 class="text-lg font-medium mb-4 pb-2 border-b mt-4">Adresse</h2>
                </div>
                
                <!-- Adresse -->
                <div class="col-span-2">
                    <label for="adresse" class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                    <input type="text" id="adresse" name="adresse" value="{{ old('adresse', $client->adresse) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                </div>
                
                <!-- Ville -->
                <div>
                    <label for="ville" class="block text-sm font-medium text-gray-700 mb-1">Ville</label>
                    <input type="text" id="ville" name="ville" value="{{ old('ville', $client->ville) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                </div>
                
                <!-- Code postal -->
                <div>
                    <label for="code_postal" class="block text-sm font-medium text-gray-700 mb-1">Code postal</label>
                    <input type="text" id="code_postal" name="code_postal" value="{{ old('code_postal', $client->code_postal) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                </div>
                
                <!-- Pays -->
                <div class="col-span-2">
                    <label for="pays" class="block text-sm font-medium text-gray-700 mb-1">Pays</label>
                    <select id="pays" name="pays" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        <option value="">Sélectionner un pays</option>
                        <option value="FR" {{ old('pays', $client->pays) == 'FR' ? 'selected' : '' }}>France</option>
                        <option value="BE" {{ old('pays', $client->pays) == 'BE' ? 'selected' : '' }}>Belgique</option>
                        <option value="CH" {{ old('pays', $client->pays) == 'CH' ? 'selected' : '' }}>Suisse</option>
                        <option value="CA" {{ old('pays', $client->pays) == 'CA' ? 'selected' : '' }}>Canada</option>
                        <option value="TG" {{ old('pays', $client->pays) == 'TG' ? 'selected' : '' }}>Togo</option>
                        <option value="US" {{ old('pays', $client->pays) == 'US' ? 'selected' : '' }}>États-Unis</option>
                    </select>
                </div>
                
                @if($client->user_id)
                <!-- Compte utilisateur -->
                <div class="col-span-2">
                    <h2 class="text-lg font-medium mb-4 pb-2 border-b mt-4">Compte utilisateur</h2>
                    <p class="text-sm text-gray-600">Ce client possède un compte utilisateur associé. Pour modifier les informations du compte, veuillez accéder à la gestion des utilisateurs.</p>
                </div>
                @else
                <!-- Compte utilisateur -->
                <div class="col-span-2">
                    <h2 class="text-lg font-medium mb-4 pb-2 border-b mt-4">Compte utilisateur</h2>
                </div>
                
                <!-- Créer un compte -->
                <div class="col-span-2">
                    <div class="flex items-center">
                        <input id="create_account" name="create_account" type="checkbox" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                        <label for="create_account" class="ml-2 block text-sm text-gray-900">Créer un compte utilisateur pour ce client</label>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Un email sera envoyé au client avec ses identifiants de connexion.</p>
                </div>
                
                <!-- Mot de passe -->
                <div class="password-fields hidden col-span-2 md:col-span-1">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                    <input type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                </div>
                
                <!-- Confirmation mot de passe -->
                <div class="password-fields hidden col-span-2 md:col-span-1">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                </div>
                @endif
            </div>
            
            <!-- Boutons -->
            <div class="mt-8 flex justify-end">
                <button type="reset" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition duration-300 mr-2">
                    Réinitialiser
                </button>
                <button type="submit" class="bg-primary hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition duration-300">
                    <i class="fas fa-save mr-2"></i> Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const createAccountCheckbox = document.getElementById('create_account');
        if (createAccountCheckbox) {
            const passwordFields = document.querySelectorAll('.password-fields');
            
            createAccountCheckbox.addEventListener('change', function() {
                passwordFields.forEach(field => {
                    if (this.checked) {
                        field.classList.remove('hidden');
                    } else {
                        field.classList.add('hidden');
                    }
                });
            });
        }
    });
</script>
@endpush