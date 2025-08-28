@extends('layouts.admin')

@section('title', 'Circuits - The Elom Tours')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Gestion des circuits</h1>
        <a href="{{ route('admin.circuits.create') }}" class="btn-primary flex items-center">
            <i class="fas fa-plus mr-2"></i> Nouveau circuit
        </a>
    </div>
    
    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-4">
                <!-- Filtre par destination -->
                <div>
                    <label for="destination" class="block text-sm font-medium text-gray-700 mb-1">Destination</label>
                    <select id="destination" name="destination" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        <option value="">Toutes les destinations</option>
                        <option value="kpalime">Kpalimé</option>
                        <option value="fazao">Fazao</option>
                        <option value="lome">Lomé</option>
                    </select>
                </div>
                
                <!-- Filtre par difficulté -->
                <div>
                    <label for="difficulte" class="block text-sm font-medium text-gray-700 mb-1">Difficulté</label>
                    <select id="difficulte" name="difficulte" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        <option value="">Toutes les difficultés</option>
                        <option value="facile">Facile</option>
                        <option value="modere">Modéré</option>
                        <option value="difficile">Difficile</option>
                    </select>
                </div>
                
                <!-- Filtre par statut -->
                <div>
                    <label for="statut" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select id="statut" name="statut" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        <option value="">Tous les statuts</option>
                        <option value="1">Actif</option>
                        <option value="0">Inactif</option>
                    </select>
                </div>
            </div>
            
            <!-- Recherche -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full pl-10 p-2.5" placeholder="Rechercher un circuit...">
            </div>
        </div>
    </div>
    
    <!-- Grille des circuits -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Circuit 1 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover-effect">
            <div class="relative">
                <img src="/assets/images/circuits/kpalime.jpg" alt="Découverte de Kpalimé" class="w-full h-48 object-cover">
                <div class="absolute top-0 right-0 m-2">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Actif</span>
                </div>
            </div>
            <div class="p-4">
                <h3 class="text-lg font-semibold mb-2">Découverte de Kpalimé</h3>
                <div class="flex items-center text-sm text-gray-600 mb-2">
                    <i class="fas fa-map-marker-alt mr-2 text-primary"></i>
                    <span>Kpalimé, Togo</span>
                </div>
                <div class="flex items-center text-sm text-gray-600 mb-2">
                    <i class="fas fa-clock mr-2 text-primary"></i>
                    <span>3 jours</span>
                </div>
                <div class="flex items-center text-sm text-gray-600 mb-4">
                    <i class="fas fa-tag mr-2 text-primary"></i>
                    <span>450€ / personne</span>
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <span class="text-sm font-medium text-gray-700 mr-2">Difficulté:</span>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Facile</span>
                    </div>
                    <div class="flex space-x-2">
                        <a href="#" class="text-primary hover:text-green-700"><i class="fas fa-eye"></i></a>
                        <a href="#" class="text-blue-600 hover:text-blue-800"><i class="fas fa-edit"></i></a>
                        <a href="#" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Circuit 2 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover-effect">
            <div class="relative">
                <img src="/assets/images/circuits/fazao.jpg" alt="Safari à Fazao" class="w-full h-48 object-cover">
                <div class="absolute top-0 right-0 m-2">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Actif</span>
                </div>
            </div>
            <div class="p-4">
                <h3 class="text-lg font-semibold mb-2">Safari à Fazao</h3>
                <div class="flex items-center text-sm text-gray-600 mb-2">
                    <i class="fas fa-map-marker-alt mr-2 text-primary"></i>
                    <span>Parc de Fazao, Togo</span>
                </div>
                <div class="flex items-center text-sm text-gray-600 mb-2">
                    <i class="fas fa-clock mr-2 text-primary"></i>
                    <span>5 jours</span>
                </div>
                <div class="flex items-center text-sm text-gray-600 mb-4">
                    <i class="fas fa-tag mr-2 text-primary"></i>
                    <span>750€ / personne</span>
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <span class="text-sm font-medium text-gray-700 mr-2">Difficulté:</span>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Modéré</span>
                    </div>
                    <div class="flex space-x-2">
                        <a href="#" class="text-primary hover:text-green-700"><i class="fas fa-eye"></i></a>
                        <a href="#" class="text-blue-600 hover:text-blue-800"><i class="fas fa-edit"></i></a>
                        <a href="#" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Circuit 3 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover-effect">
            <div class="relative">
                <img src="/assets/images/circuits/lome.jpg" alt="Lomé Culturelle" class="w-full h-48 object-cover">
                <div class="absolute top-0 right-0 m-2">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Inactif</span>
                </div>
            </div>
            <div class="p-4">
                <h3 class="text-lg font-semibold mb-2">Lomé Culturelle</h3>
                <div class="flex items-center text-sm text-gray-600 mb-2">
                    <i class="fas fa-map-marker-alt mr-2 text-primary"></i>
                    <span>Lomé, Togo</span>
                </div>
                <div class="flex items-center text-sm text-gray-600 mb-2">
                    <i class="fas fa-clock mr-2 text-primary"></i>
                    <span>2 jours</span>
                </div>
                <div class="flex items-center text-sm text-gray-600 mb-4">
                    <i class="fas fa-tag mr-2 text-primary"></i>
                    <span>350€ / personne</span>
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <span class="text-sm font-medium text-gray-700 mr-2">Difficulté:</span>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Facile</span>
                    </div>
                    <div class="flex space-x-2">
                        <a href="#" class="text-primary hover:text-green-700"><i class="fas fa-eye"></i></a>
                        <a href="#" class="text-blue-600 hover:text-blue-800"><i class="fas fa-edit"></i></a>
                        <a href="#" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Circuit 4 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover-effect">
            <div class="relative">
                <img src="/assets/images/circuits/atakpame.jpg" alt="Aventure à Atakpamé" class="w-full h-48 object-cover">
                <div class="absolute top-0 right-0 m-2">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Actif</span>
                </div>
            </div>
            <div class="p-4">
                <h3 class="text-lg font-semibold mb-2">Aventure à Atakpamé</h3>
                <div class="flex items-center text-sm text-gray-600 mb-2">
                    <i class="fas fa-map-marker-alt mr-2 text-primary"></i>
                    <span>Atakpamé, Togo</span>
                </div>
                <div class="flex items-center text-sm text-gray-600 mb-2">
                    <i class="fas fa-clock mr-2 text-primary"></i>
                    <span>4 jours</span>
                </div>
                <div class="flex items-center text-sm text-gray-600 mb-4">
                    <i class="fas fa-tag mr-2 text-primary"></i>
                    <span>550€ / personne</span>
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <span class="text-sm font-medium text-gray-700 mr-2">Difficulté:</span>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Difficile</span>
                    </div>
                    <div class="flex space-x-2">
                        <a href="#" class="text-primary hover:text-green-700"><i class="fas fa-eye"></i></a>
                        <a href="#" class="text-blue-600 hover:text-blue-800"><i class="fas fa-edit"></i></a>
                        <a href="#" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Pagination -->
    <div class="mt-6 flex justify-center">
        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
            <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                <span class="sr-only">Précédent</span>
                <i class="fas fa-chevron-left"></i>
            </a>
            <a href="#" aria-current="page" class="z-10 bg-primary border-primary text-white relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                1
            </a>
            <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                2
            </a>
            <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                3
            </a>
            <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                <span class="sr-only">Suivant</span>
                <i class="fas fa-chevron-right"></i>
            </a>
        </nav>
    </div>
</div>
@endsection