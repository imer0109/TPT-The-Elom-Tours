@php
    // Fonction helper pour vérifier si une route est active
    function isActiveRoute($routeName, $exact = false) {
        $currentRoute = request()->route()->getName();
        
        if ($exact) {
            return $currentRoute === $routeName;
        }
        
        // Pour les routes avec des patterns (ex: admin.reservations.*)
        if (str_contains($routeName, '*')) {
            $pattern = str_replace('*', '', $routeName);
            return str_starts_with($currentRoute, $pattern);
        }
        
        return $currentRoute === $routeName;
    }
    
    // Fonction helper pour vérifier si un groupe de routes est actif
    function isActiveGroup($routes) {
        $currentRoute = request()->route()->getName();
        foreach ($routes as $route) {
            if (str_contains($route, '*')) {
                $pattern = str_replace('*', '', $route);
                if (str_starts_with($currentRoute, $pattern)) {
                    return true;
                }
            } elseif ($currentRoute === $route) {
                return true;
            }
        }
        return false;
    }
@endphp

<div x-show="sidebarOpen" class="flex flex-col fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 shadow-lg transition-all duration-300 ease-in-out transform sm:translate-x-0 sm:static sm:inset-0">
    <!-- Logo -->
    <div class="flex items-center justify-center h-16 border-b border-gray-200">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center">
            <img src="/images/LogoElomTour.jpg" alt="The Elom Tours" class="h-12">
            <span class="ml-2 text-xl font-bold text-primary">THE ELOM TOURS</span>
        </a>
    </div>
    
    <!-- Navigation -->
    <div class="flex-1 overflow-y-auto py-4 px-3">
        <ul class="space-y-2">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 text-base font-medium rounded-lg {{ isActiveRoute('admin.dashboard') ? 'text-white bg-primary' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-tachometer-alt w-6 h-6 text-center"></i>
                    <span class="ml-3">Tableau de bord</span>
                </a>
            </li>
            
            <!-- Réservations -->
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base font-medium rounded-lg {{ isActiveGroup(['admin.reservations.*']) ? 'text-white bg-primary' : 'text-gray-700 hover:bg-gray-100' }} transition duration-75 group" aria-controls="dropdown-reservations" data-collapse-toggle="dropdown-reservations">
                    <i class="fas fa-calendar-check w-6 h-6 text-center"></i>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap">Réservations</span>
                    <i class="fas fa-chevron-down {{ isActiveGroup(['admin.reservations.*']) ? 'rotate-180' : '' }}"></i>
                </button>
                <ul id="dropdown-reservations" class="{{ isActiveGroup(['admin.reservations.*']) ? '' : 'hidden' }} py-2 space-y-2 pl-11">
                    <li>
                        <a href="{{ route('admin.reservations.dashboard') }}" class="flex items-center p-2 text-sm font-medium rounded-lg {{ isActiveRoute('admin.reservations.dashboard') ? 'text-white bg-primary' : 'text-gray-700 hover:bg-gray-100' }}">- Tableau de bord</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.reservations.index') }}" class="flex items-center p-2 text-sm font-medium rounded-lg {{ isActiveRoute('admin.reservations.index') ? 'text-white bg-primary' : 'text-gray-700 hover:bg-gray-100' }}">- Toutes les réservations</a>
                    </li>
                    <!-- <li>
                        <a href="{{ route('admin.reservations.create') }}" class="flex items-center p-2 text-sm font-medium rounded-lg {{ isActiveRoute('admin.reservations.create') ? 'text-white bg-primary' : 'text-gray-700 hover:bg-gray-100' }}">- Ajouter une réservation</a>
                    </li> -->
                </ul>
            </li>
            
            <!-- Circuits -->
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base font-medium rounded-lg {{ isActiveGroup(['admin.circuits.*']) ? 'text-white bg-primary' : 'text-gray-700 hover:bg-gray-100' }} transition duration-75 group" aria-controls="dropdown-circuits" data-collapse-toggle="dropdown-circuits">
                    <i class="fas fa-route w-6 h-6 text-center"></i>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap">Circuits</span>
                    <i class="fas fa-chevron-down {{ isActiveGroup(['admin.circuits.*']) ? 'rotate-180' : '' }}"></i>
                </button>
                <ul id="dropdown-circuits" class="{{ isActiveGroup(['admin.circuits.*']) ? '' : 'hidden' }} py-2 space-y-2 pl-11">
                    <li>
                        <a href="{{ route('admin.circuits.index') }}" class="flex items-center p-2 text-sm font-medium rounded-lg {{ isActiveRoute('admin.circuits.index') ? 'text-white bg-primary' : 'text-gray-700 hover:bg-gray-100' }}">- Tous les circuits</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.circuits.create') }}" class="flex items-center p-2 text-sm font-medium rounded-lg {{ isActiveRoute('admin.circuits.create') ? 'text-white bg-primary' : 'text-gray-700 hover:bg-gray-100' }}">- Ajouter un circuit</a>
                    </li>
                    <!-- <li>
                        <a href="#" class="flex items-center p-2 text-sm font-medium rounded-lg {{ isActiveRoute('admin.circuits.categories') ? 'text-white bg-primary' : 'text-gray-700 hover:bg-gray-100' }}">- Catégories</a>
                    </li> -->
                </ul>
            </li>
            
            <!-- Clients -->
            <!-- <li>
                <a href="{{ route('admin.clients.index') }}" class="flex items-center p-2 text-base font-medium rounded-lg text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-users w-6 h-6 text-center"></i>
                    <span class="ml-3">Clients</span>
                </a>
            </li> -->
            
            <!-- Blog -->
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base font-medium rounded-lg {{ isActiveGroup(['admin.blog.*', 'admin.categories.*']) ? 'text-white bg-primary' : 'text-gray-700 hover:bg-gray-100' }} transition duration-75 group" aria-controls="dropdown-blog" data-collapse-toggle="dropdown-blog">
                    <i class="fas fa-blog w-6 h-6 text-center"></i>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap">Blog</span>
                    <i class="fas fa-chevron-down {{ isActiveGroup(['admin.blog.*', 'admin.categories.*']) ? 'rotate-180' : '' }}"></i>
                </button>
                <ul id="dropdown-blog" class="{{ isActiveGroup(['admin.blog.*', 'admin.categories.*']) ? '' : 'hidden' }} py-2 space-y-2 pl-11">
                    <li>
                        <a href="{{ route('admin.blog.index') }}" class="flex items-center p-2 text-sm font-medium rounded-lg {{ isActiveRoute('admin.blog.index') ? 'text-white bg-primary' : 'text-gray-700 hover:bg-gray-100' }}">- Tous les articles</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.blog.create') }}" class="flex items-center p-2 text-sm font-medium rounded-lg {{ isActiveRoute('admin.blog.create') ? 'text-white bg-primary' : 'text-gray-700 hover:bg-gray-100' }}">- Ajouter un article</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.categories.index') }}" class="flex items-center p-2 text-sm font-medium rounded-lg {{ isActiveGroup(['admin.categories.*']) ? 'text-white bg-primary' : 'text-gray-700 hover:bg-gray-100' }}">- Catégories</a>
                    </li>
                </ul>
            </li>
            
            <!-- Galerie -->
            <li>
                <a href="{{ route('admin.gallery.index') }}" class="flex items-center p-2 text-base font-medium rounded-lg {{ isActiveGroup(['admin.gallery.*']) ? 'text-white bg-primary' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-images w-6 h-6 text-center"></i>
                    <span class="ml-3">Galerie</span>
                </a>
            </li>
            
            <!-- Messages -->
            <li>
                <a href="{{ route('admin.messages.index') }}" class="flex items-center p-2 text-base font-medium rounded-lg {{ isActiveGroup(['admin.messages.*']) ? 'text-white bg-primary' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-envelope w-6 h-6 text-center"></i>
                    <span class="ml-3">Messages</span>
                    <span class="inline-flex justify-center items-center p-1 ml-3 w-5 h-5 text-xs font-medium rounded-full text-white bg-red-500"></span>
                </a>
            </li>
            
            <!-- Commentaires -->
            <li>
                <a href="{{ route('admin.comments.index') }}" class="flex items-center p-2 text-base font-medium rounded-lg {{ isActiveGroup(['admin.comments.*']) ? 'text-white bg-primary' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-comments w-6 h-6 text-center"></i>
                    <span class="ml-3">Commentaires</span>
                    @php
                        $pendingCommentsCount = \App\Models\Comment::where('is_approved', false)->count();
                    @endphp
                    @if($pendingCommentsCount > 0)
                        <span class="inline-flex justify-center items-center p-1 ml-3 w-5 h-5 text-xs font-medium rounded-full text-white bg-yellow-500">{{ $pendingCommentsCount }}</span>
                    @endif
                </a>
            </li>
            
            <!-- Avis -->
            <li>
                <a href="{{ route('admin.reviews.index') }}" class="flex items-center p-2 text-base font-medium rounded-lg {{ isActiveGroup(['admin.reviews.*']) ? 'text-white bg-primary' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-star w-6 h-6 text-center"></i>
                    <span class="ml-3">Avis clients</span>
                    @php
                        $pendingReviewsCount = \App\Models\Review::where('is_approved', false)->count();
                    @endphp
                    @if($pendingReviewsCount > 0)
                        <span class="inline-flex justify-center items-center p-1 ml-3 w-5 h-5 text-xs font-medium rounded-full text-white bg-yellow-500">{{ $pendingReviewsCount }}</span>
                    @endif
                </a>
            </li>
            
            <!-- Destinations -->
            <li>
                <a href="{{ route('admin.destinations.index') }}" class="flex items-center p-2 text-base font-medium rounded-lg {{ isActiveGroup(['admin.destinations.*']) ? 'text-white bg-primary' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-map-marker-alt w-6 h-6 text-center"></i>
                    <span class="ml-3">Destinations</span>
                </a>
            </li>
            
            <!-- Paramètres -->
            <li>
                <a href="{{ route('admin.settings.index') }}" class="flex items-center p-2 text-base font-medium rounded-lg {{ isActiveGroup(['admin.settings.*']) ? 'text-white bg-primary' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-cog w-6 h-6 text-center"></i>
                    <span class="ml-3">Paramètres</span>
                </a>
            </li>
            @if(auth()->user()->hasRole('Super Administrateur'))
             <li>
                <a href="{{ route('admin.activity-logs.index') }}" class="flex items-center p-2 text-base font-medium rounded-lg {{ isActiveGroup(['admin.activity-logs.*']) ? 'text-white bg-primary' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-history w-6 h-6 text-center"></i>
                    <span class="ml-3">Journal d'activités</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.trash.index') }}" class="flex items-center p-2 text-base font-medium rounded-lg {{ isActiveGroup(['admin.trash.*']) ? 'text-white bg-primary' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-trash-alt w-6 h-6 text-center"></i>
                    <span class="ml-3">Corbeille</span>
                    @php
                        $trashCount = \App\Models\Circuit::onlyTrashed()->count() + 
                                     \App\Models\Destination::onlyTrashed()->count() + 
                                     \App\Models\BlogPost::onlyTrashed()->count() + 
                                     \App\Models\Reservation::onlyTrashed()->count() + 
                                     \App\Models\Client::onlyTrashed()->count() + 
                                     \App\Models\Comment::onlyTrashed()->count() + 
                                     \App\Models\Review::onlyTrashed()->count() + 
                                     \App\Models\Categorie::onlyTrashed()->count() + 
                                     \App\Models\Paiement::onlyTrashed()->count() + 
                                     \App\Models\Setting::onlyTrashed()->count() + 
                                     \App\Models\User::onlyTrashed()->count();
                    @endphp
                    @if($trashCount > 0)
                        <span class="inline-flex justify-center items-center p-1 ml-3 w-5 h-5 text-xs font-medium rounded-full text-white bg-red-500">{{ $trashCount }}</span>
                    @endif
                </a>
            </li>
            @endif
        </ul>
    </div>
    
    <!-- User Info -->
    <div class="p-4 border-t border-gray-200">
        @auth
        @php
            $user = auth()->user();
            $displayName = trim(($user->firstName ?? '').' '.($user->lastName ?? '')) ?: ($user->name ?? 'Utilisateur');
            $email = $user->email ?? '';
            $avatarUrl = 'https://ui-avatars.com/api/?name='.urlencode($displayName).'&background=16A34A&color=fff';
        @endphp
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <img class="h-10 w-10 rounded-full" src="{{ $avatarUrl }}" alt="{{ $displayName }}">
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-900">{{ $displayName }}</p>
                <p class="text-xs font-medium text-gray-500">{{ $email }}</p>
            </div>
            <div class="ml-auto">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-gray-500 hover:text-red-500" title="Se déconnecter">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
        @endauth
    </div>
</div>

<!-- Mobile sidebar backdrop -->
<div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="md:hidden fixed inset-0 z-40 bg-gray-600 bg-opacity-75" @click="sidebarOpen = false"></div>

<!-- Collapsed sidebar (mobile) -->
<div x-show="!sidebarOpen" class="fixed inset-y-0 left-0 flex flex-col z-40 w-14 hover:w-64 md:hidden bg-white shadow-lg overflow-y-auto transition-all duration-300 ease-in-out">
    <div class="flex items-center justify-center h-16 border-b border-gray-200">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-center">
            <img src="{{ asset('assets/images/logo.png') }}" alt="The Elom Tours" class="h-8">
            <span class="ml-2 text-xl font-bold text-primary hidden group-hover:block">Elom Tours</span>
        </a>
    </div>
    
    <div class="flex-1 overflow-y-auto py-4 px-3">
        <ul class="space-y-2">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 text-base font-medium rounded-lg {{ isActiveRoute('admin.dashboard') ? 'text-white bg-primary' : 'text-gray-700 hover:bg-gray-100' }} group">
                    <i class="fas fa-tachometer-alt w-6 h-6 text-center"></i>
                    <span class="ml-3 hidden group-hover:block">Tableau de bord</span>
                </a>
            </li>
            
            <!-- Réservations -->
            <li>
                <a href="{{ route('admin.reservations.index') }}" class="flex items-center p-2 text-base font-medium rounded-lg {{ isActiveGroup(['admin.reservations.*']) ? 'text-white bg-primary' : 'text-gray-700 hover:bg-gray-100' }} group">
                    <i class="fas fa-calendar-check w-6 h-6 text-center"></i>
                    <span class="ml-3 hidden group-hover:block">Réservations</span>
                </a>
            </li>
            
            <!-- Circuits -->
            <li>
                <a href="{{ route('admin.circuits.index') }}" class="flex items-center p-2 text-base font-medium rounded-lg {{ isActiveGroup(['admin.circuits.*']) ? 'text-white bg-primary' : 'text-gray-700 hover:bg-gray-100' }} group">
                    <i class="fas fa-route w-6 h-6 text-center"></i>
                    <span class="ml-3 hidden group-hover:block">Circuits</span>
                </a>
            </li>
            
            <!-- Clients -->
            <li>
                <a href="{{ route('admin.clients.index') }}" class="flex items-center p-2 text-base font-medium rounded-lg {{ isActiveGroup(['admin.clients.*']) ? 'text-white bg-primary' : 'text-gray-700 hover:bg-gray-100' }} group">
                    <i class="fas fa-users w-6 h-6 text-center"></i>
                    <span class="ml-3 hidden group-hover:block">Clients</span>
                </a>
            </li>
            
            <!-- Blog -->
            <li>
                <a href="{{ route('admin.blog.index') }}" class="flex items-center p-2 text-base font-medium rounded-lg {{ isActiveGroup(['admin.blog.*', 'admin.categories.*']) ? 'text-white bg-primary' : 'text-gray-700 hover:bg-gray-100' }} group">
                    <i class="fas fa-blog w-6 h-6 text-center"></i>
                    <span class="ml-3 hidden group-hover:block">Blog</span>
                </a>
            </li>
            
            <!-- Galerie -->
            <li>
                <a href="{{ route('admin.gallery.index') }}" class="flex items-center p-2 text-base font-medium rounded-lg {{ isActiveGroup(['admin.gallery.*']) ? 'text-white bg-primary' : 'text-gray-700 hover:bg-gray-100' }} group">
                    <i class="fas fa-images w-6 h-6 text-center"></i>
                    <span class="ml-3 hidden group-hover:block">Galerie</span>
                </a>
            </li>
            
            <!-- Messages -->
            <li>
                <a href="{{ route('admin.messages.index') }}" class="flex items-center p-2 text-base font-medium rounded-lg {{ isActiveGroup(['admin.messages.*']) ? 'text-white bg-primary' : 'text-gray-700 hover:bg-gray-100' }} group">
                    <i class="fas fa-envelope w-6 h-6 text-center"></i>
                    <span class="ml-3 hidden group-hover:block">Messages</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<script>
    // Gestion des menus déroulants
    document.addEventListener('DOMContentLoaded', function() {
        const dropdownButtons = document.querySelectorAll('[data-collapse-toggle]');
        
        dropdownButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-collapse-toggle');
                const targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    targetElement.classList.toggle('hidden');
                    
                    // Rotate chevron icon
                    const chevronIcon = this.querySelector('.fa-chevron-down');
                    if (chevronIcon) {
                        chevronIcon.classList.toggle('rotate-180');
                    }
                }
            });
        });
    });
</script>