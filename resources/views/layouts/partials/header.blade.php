

<!-- Header (FIXE) -->
<header class="fixed top-0 left-0 w-full bg-white shadow-md z-50">
<!-- Bandeau vert (NON FIXE) -->
<div class="w-full bg-[#16a34a] text-white">
    <div class="container mx-auto px-4 py-2 flex justify-center items-center">
        <p class="text-sm md:text-base font-medium">
            OFFREZ-VOUS LA MEILLEURE EXPÉRIENCE DE VOYAGE
        </p>
    </div>
</div>
    <div class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center">
    <a href="{{ route('home') }}" class="flex items-center space-x-2">
        <img src="/images/LogoElomTour.jpg" alt="The Elom Tours" class="h-[4.5rem] w-auto">
        {{-- <span class="text-yellow-500 text-2xl font-bold">The Elom</span> --}}
        <span class="text-green-700 text-2xl font-bold">The Elom' Tours</span>
    </a>
</div>


            
            <!-- Navigation -->
            <nav class="hidden md:flex space-x-8">
                <a href="/" class="text-gray-700 hover:text-green-600 font-medium">Accueil</a>
                <a href="/circuits" class="text-gray-700 hover:text-green-600 font-medium">Nos Circuits</a>
                <a href="/galerie" class="text-gray-700 hover:text-green-600 font-medium">Galerie</a>
                <a href="/blog" class="text-gray-700 hover:text-green-600 font-medium">Blog</a>
                <a href="{{ route('about.index') }}" class="text-gray-700 hover:text-green-600 font-medium">À propos</a>
                <a href="/contact" class="text-gray-700 hover:text-green-600 font-medium">Contact</a>
            </nav>
            
            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button type="button" class="text-gray-700 hover:text-green-600 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu (Hidden by default) -->
    <div class="hidden md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="/" class="block px-3 py-2 text-gray-700 hover:text-green-600 font-medium">Accueil</a>
            <a href="/circuits" class="block px-3 py-2 text-gray-700 hover:text-green-600 font-medium">Circuits</a>
            <a href="/galerie" class="block px-3 py-2 text-gray-700 hover:text-green-600 font-medium">Galerie</a>
            <a href="/blog" class="block px-3 py-2 text-gray-700 hover:text-green-600 font-medium">Blog</a>
            <a href="{{ route('about.index') }}" class="block px-3 py-2 text-gray-700 hover:text-green-600 font-medium">À propos</a>
            <a href="/contact" class="block px-3 py-2 text-gray-700 hover:text-green-600 font-medium">Contact</a>
        </div>
    </div>
</header>
