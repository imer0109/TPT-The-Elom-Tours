<header class="bg-white shadow-sm z-10 border-b border-gray-200">
    <div class="flex items-center justify-between h-16 px-4 sm:px-6">
        <!-- Hamburger menu (mobile) -->
        <button @click="sidebarOpen = !sidebarOpen" type="button" class="text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600 md:hidden">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </button>
        
        <!-- Search Bar -->
        <div class="hidden md:flex md:flex-1 md:mx-2 lg:mx-4">
            <div class="relative w-full max-w-md">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500" viewBox="0 0 24 24" fill="none">
                        <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full pl-10 p-2.5 w-32 sm:w-48 md:w-64" placeholder="Rechercher...">
            </div>
        </div>
        
        <!-- Right Side Icons -->
        <div class="flex items-center space-x-4">
            <!-- Notifications -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" type="button" class="relative p-1 text-gray-500 hover:text-gray-600 focus:outline-none">
                    <i class="fas fa-bell text-xl"></i>
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center h-5 w-5 rounded-full text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500">3</span>
                </button>
                
                <!-- Dropdown -->
                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                    <div class="py-1 divide-y divide-gray-100" role="none">
                        <div class="px-4 py-3">
                            <p class="text-sm font-medium text-gray-900">Notifications</p>
                        </div>
                        
                        <!-- Notification 1 -->
                        <a href="#" class="flex px-4 py-3 hover:bg-gray-50">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center">
                                    <i class="fas fa-exclamation-triangle text-red-500"></i>
                                </div>
                            </div>
                            <div class="ml-3 w-0 flex-1">
                                <p class="text-sm font-medium text-gray-900">Stock faible pour le circuit "Découverte de Kpalimé"</p>
                                <p class="text-sm text-gray-500">Il ne reste que 2 places disponibles</p>
                                <p class="text-xs text-gray-500 mt-1">Il y a 3 heures</p>
                            </div>
                        </a>
                        
                        <!-- Notification 2 -->
                        <a href="#" class="flex px-4 py-3 hover:bg-gray-50">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-envelope text-blue-500"></i>
                                </div>
                            </div>
                            <div class="ml-3 w-0 flex-1">
                                <p class="text-sm font-medium text-gray-900">Nouvelle demande de contact</p>
                                <p class="text-sm text-gray-500">Sophie Martin a envoyé une demande d'information</p>
                                <p class="text-xs text-gray-500 mt-1">Il y a 5 heures</p>
                            </div>
                        </a>
                        
                        <!-- Notification 3 -->
                        <a href="#" class="flex px-4 py-3 hover:bg-gray-50">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="fas fa-check-circle text-green-500"></i>
                                </div>
                            </div>
                            <div class="ml-3 w-0 flex-1">
                                <p class="text-sm font-medium text-gray-900">Paiement reçu</p>
                                <p class="text-sm text-gray-500">Le paiement de 1,250€ pour la réservation #12345 a été reçu</p>
                                <p class="text-xs text-gray-500 mt-1">Il y a 1 jour</p>
                            </div>
                        </a>
                        
                        <div class="px-4 py-3 text-center">
                            <a href="#" class="text-sm font-medium text-primary hover:text-green-700">Voir toutes les notifications</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Messages -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" type="button" class="relative p-1 text-gray-500 hover:text-gray-600 focus:outline-none">
                    <i class="fas fa-envelope text-xl"></i>
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center h-5 w-5 rounded-full text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500">2</span>
                </button>
                
                <!-- Dropdown -->
                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                    <div class="py-1 divide-y divide-gray-100" role="none">
                        <div class="px-4 py-3">
                            <p class="text-sm font-medium text-gray-900">Messages</p>
                        </div>
                        
                        <!-- Message 1 -->
                        <a href="#" class="flex px-4 py-3 hover:bg-gray-50">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name=Jean+Dupont&background=16A34A&color=fff" alt="Jean Dupont">
                            </div>
                            <div class="ml-3 w-0 flex-1">
                                <p class="text-sm font-medium text-gray-900">Jean Dupont</p>
                                <p class="text-sm text-gray-500 truncate">Bonjour, je souhaiterais avoir plus d'informations...</p>
                                <p class="text-xs text-gray-500 mt-1">Il y a 30 minutes</p>
                            </div>
                        </a>
                        
                        <!-- Message 2 -->
                        <a href="#" class="flex px-4 py-3 hover:bg-gray-50">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name=Marie+Lefebvre&background=1E40AF&color=fff" alt="Marie Lefebvre">
                            </div>
                            <div class="ml-3 w-0 flex-1">
                                <p class="text-sm font-medium text-gray-900">Marie Lefebvre</p>
                                <p class="text-sm text-gray-500 truncate">Est-ce que le circuit Safari à Fazao est disponible...</p>
                                <p class="text-xs text-gray-500 mt-1">Il y a 2 heures</p>
                            </div>
                        </a>
                        
                        <div class="px-4 py-3 text-center">
                            <a href="#" class="text-sm font-medium text-primary hover:text-green-700">Voir tous les messages</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- User Menu -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" type="button" class="flex items-center focus:outline-none" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                    <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name=Admin+User&background=16A34A&color=fff" alt="Admin User">
                    <span class="hidden md:flex md:items-center ml-2">
                        <span class="text-sm font-medium text-gray-700">Admin User</span>
                        <i class="fas fa-chevron-down ml-1 text-xs text-gray-400"></i>
                    </span>
                </button>
                
                <!-- Dropdown -->
                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                    <div class="py-1" role="none">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">Mon profil</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">Paramètres</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">Déconnexion</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Mobile Search (only visible on mobile) -->
    <div class="md:hidden px-6 pb-4">
        <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full pl-10 p-2.5" placeholder="Rechercher...">
        </div>
    </div>
</header>