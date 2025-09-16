<!-- Header (FIXE) -->
<header class="fixed top-0 left-0 w-full bg-white shadow-md z-50">
    <!-- Bandeau vert -->
    <div class="w-full bg-[#16a34a] text-white">
        <div class="container mx-auto px-4 py-2 flex justify-center items-center">
            <p class="text-sm md:text-base font-medium">
                OFFREZ-VOUS LA MEILLEURE EXPÉRIENCE DE VOYAGE
            </p>
        </div>
    </div>

    <div x-data="{ open:false }" class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <img src="/images/LogoElomTour.jpg" alt="The Elom Tours" class="h-[4.5rem] w-auto">
                    <span class="text-green-700 text-2xl font-bold">The Elom' Tours</span>
                </a>
            </div>

            <!-- Navigation (Desktop) -->
            <nav class="hidden md:flex space-x-8">
                <a href="/" class="{{ request()->is('/') ? 'text-green-600 font-bold' : 'text-gray-700 hover:text-green-600 font-medium' }}">Accueil</a>
                <a href="/circuits" class="{{ request()->is('circuits') ? 'text-green-600 font-bold' : 'text-gray-700 hover:text-green-600 font-medium' }}">Nos Circuits</a>
                <a href="/galerie" class="{{ request()->is('galerie') ? 'text-green-600 font-bold' : 'text-gray-700 hover:text-green-600 font-medium' }}">Galerie</a>
                <a href="/blog" class="{{ request()->is('blog') ? 'text-green-600 font-bold' : 'text-gray-700 hover:text-green-600 font-medium' }}">Blog</a>
                <a href="{{ route('about.index') }}" class="{{ request()->routeIs('about.index') ? 'text-green-600 font-bold' : 'text-gray-700 hover:text-green-600 font-medium' }}">À propos</a>
                <a href="/contact" class="{{ request()->is('contact') ? 'text-green-600 font-bold' : 'text-gray-700 hover:text-green-600 font-medium' }}">Contact</a>
            </nav>

            <!-- Bouton Menu Mobile -->
            <div class="md:hidden">
                <button 
                    @click="open = !open" 
                    :aria-expanded="open.toString()" 
                    aria-controls="mobile-menu" 
                    type="button" 
                    class="text-gray-700 hover:text-green-600 focus:outline-none" 
                    aria-label="Ouvrir le menu">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Menu Mobile -->
    <div 
        id="mobile-menu" 
        class="md:hidden" 
        x-show="open" 
        x-transition:enter="transition ease-out duration-200" 
        x-transition:enter-start="opacity-0 transform -translate-y-2" 
        x-transition:enter-end="opacity-100 transform translate-y-0" 
        x-transition:leave="transition ease-in duration-150" 
        x-transition:leave-start="opacity-100 transform translate-y-0" 
        x-transition:leave-end="opacity-0 transform -translate-y-2"
    >
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t border-gray-100 shadow-md">
            <a @click="open=false" href="/" class="block px-3 py-2 {{ request()->is('/') ? 'text-green-600 font-bold' : 'text-gray-700 hover:text-green-600 font-medium' }}">Accueil</a>
            <a @click="open=false" href="/circuits" class="block px-3 py-2 {{ request()->is('circuits') ? 'text-green-600 font-bold' : 'text-gray-700 hover:text-green-600 font-medium' }}">Circuits</a>
            <a @click="open=false" href="/galerie" class="block px-3 py-2 {{ request()->is('galerie') ? 'text-green-600 font-bold' : 'text-gray-700 hover:text-green-600 font-medium' }}">Galerie</a>
            <a @click="open=false" href="/blog" class="block px-3 py-2 {{ request()->is('blog') ? 'text-green-600 font-bold' : 'text-gray-700 hover:text-green-600 font-medium' }}">Blog</a>
            <a @click="open=false" href="{{ route('about.index') }}" class="block px-3 py-2 {{ request()->routeIs('about.index') ? 'text-green-600 font-bold' : 'text-gray-700 hover:text-green-600 font-medium' }}">À propos</a>
            <a @click="open=false" href="/contact" class="block px-3 py-2 {{ request()->is('contact') ? 'text-green-600 font-bold' : 'text-gray-700 hover:text-green-600 font-medium' }}">Contact</a>
        </div>
    </div>
</header>
