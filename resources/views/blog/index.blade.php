@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="relative">
        <div class="hero-image h-64 md:h-96 bg-cover bg-center bg-[#16a34a]"
         {{-- style="background-image: url('{{ asset('assets/images/blog-hero.jpg') }}')" --}}
         >
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="container mx-auto px-4 h-full flex items-center justify-center relative z-10">
                <div class="text-center text-white">
                    <h1 class="text-3xl md:text-5xl font-bold mb-2">Notre Blog</h1>
                    <p class="text-lg md:text-xl">Découvrez nos récits de voyage et conseils</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Breadcrumb -->
    <div class="bg-gray-100 py-2">
        <div class="container mx-auto px-4">
            <div class="flex items-center text-sm">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-green-600">Accueil</a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-gray-800">Blog</span>
            </div>
        </div>
    </div>

    <!-- Blog Content -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Featured Post -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                        <img src="{{ asset('assets/images/blog-featured.jpg') }}" alt="Les meilleures périodes pour visiter le Togo" class="w-full h-80 object-cover">
                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-600 mb-3">
                                <span class="mr-4">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    15 juin 2023
                                </span>
                                <span>
                                    <i class="far fa-user mr-1"></i>
                                    Par Elom Koudjo
                                </span>
                            </div>
                            <h2 class="text-2xl font-bold mb-3">
                                <a href="{{ route('blog.show', 1) }}" class="text-gray-800 hover:text-green-600">Les meilleures périodes pour visiter le Togo</a>
                            </h2>
                            <p class="text-gray-700 mb-4">Le Togo, petit pays d'Afrique de l'Ouest, offre une diversité de paysages et d'expériences culturelles tout au long de l'année. Cependant, certaines périodes sont plus propices que d'autres pour profiter pleinement de votre séjour. Dans cet article, nous vous guidons à travers les saisons togolaises pour vous aider à planifier votre voyage au meilleur moment.</p>
                            <a href="{{ route('blog.show', 1) }}" class="inline-block text-green-600 font-semibold hover:text-green-800">
                                Lire la suite
                                <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Blog Posts Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Post 1 -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <img src="{{ asset('assets/images/blog-1.jpg') }}" alt="10 plats togolais à découvrir" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <div class="flex items-center text-sm text-gray-600 mb-3">
                                    <span class="mr-4">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        2 juin 2023
                                    </span>
                                    <span>
                                        <i class="far fa-user mr-1"></i>
                                        Par Ama Sika
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold mb-3">
                                    <a href="{{ route('blog.show', 2) }}" class="text-gray-800 hover:text-green-600">10 plats togolais à découvrir absolument</a>
                                </h3>
                                <p class="text-gray-700 mb-4">La cuisine togolaise est un véritable trésor de saveurs et de traditions. Découvrez les plats incontournables qui raviront vos papilles lors de votre séjour au Togo.</p>
                                <a href="{{ route('blog.show', 2) }}" class="inline-block text-green-600 font-semibold hover:text-green-800">
                                    Lire la suite
                                    <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Post 2 -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <img src="{{ asset('assets/images/blog-2.jpg') }}" alt="Guide des marchés traditionnels" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <div class="flex items-center text-sm text-gray-600 mb-3">
                                    <span class="mr-4">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        20 mai 2023
                                    </span>
                                    <span>
                                        <i class="far fa-user mr-1"></i>
                                        Par Kofi Mensah
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold mb-3">
                                    <a href="{{ route('blog.show', 3) }}" class="text-gray-800 hover:text-green-600">Guide des marchés traditionnels au Togo</a>
                                </h3>
                                <p class="text-gray-700 mb-4">Les marchés togolais sont de véritables institutions culturelles où se mêlent commerce, traditions et vie sociale. Voici notre guide pour explorer ces lieux fascinants.</p>
                                <a href="{{ route('blog.show', 3) }}" class="inline-block text-green-600 font-semibold hover:text-green-800">
                                    Lire la suite
                                    <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Post 3 -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <img src="{{ asset('assets/images/blog-3.jpg') }}" alt="Artisanat togolais" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <div class="flex items-center text-sm text-gray-600 mb-3">
                                    <span class="mr-4">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        5 mai 2023
                                    </span>
                                    <span>
                                        <i class="far fa-user mr-1"></i>
                                        Par Elom Koudjo
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold mb-3">
                                    <a href="{{ route('blog.show', 4) }}" class="text-gray-800 hover:text-green-600">L'artisanat togolais : traditions et savoir-faire</a>
                                </h3>
                                <p class="text-gray-700 mb-4">Le Togo est riche d'un patrimoine artisanal exceptionnel. Découvrez les techniques ancestrales et les artisans qui perpétuent ces traditions séculaires.</p>
                                <a href="{{ route('blog.show', 4) }}" class="inline-block text-green-600 font-semibold hover:text-green-800">
                                    Lire la suite
                                    <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Post 4 -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <img src="{{ asset('assets/images/blog-4.jpg') }}" alt="Festivals au Togo" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <div class="flex items-center text-sm text-gray-600 mb-3">
                                    <span class="mr-4">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        18 avril 2023
                                    </span>
                                    <span>
                                        <i class="far fa-user mr-1"></i>
                                        Par Ama Sika
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold mb-3">
                                    <a href="{{ route('blog.show', 5) }}" class="text-gray-800 hover:text-green-600">Calendrier des festivals et célébrations au Togo</a>
                                </h3>
                                <p class="text-gray-700 mb-4">Le Togo vibre au rythme de nombreuses fêtes et célébrations tout au long de l'année. Voici un calendrier pour ne manquer aucun de ces événements culturels majeurs.</p>
                                <a href="{{ route('blog.show', 5) }}" class="inline-block text-green-600 font-semibold hover:text-green-800">
                                    Lire la suite
                                    <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Post 5 -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <img src="{{ asset('assets/images/blog-5.jpg') }}" alt="Conseils pour voyager au Togo" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <div class="flex items-center text-sm text-gray-600 mb-3">
                                    <span class="mr-4">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        2 avril 2023
                                    </span>
                                    <span>
                                        <i class="far fa-user mr-1"></i>
                                        Par Kofi Mensah
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold mb-3">
                                    <a href="{{ route('blog.show', 6) }}" class="text-gray-800 hover:text-green-600">Conseils pratiques pour voyager au Togo</a>
                                </h3>
                                <p class="text-gray-700 mb-4">Préparez votre voyage au Togo avec nos conseils pratiques sur les visas, la santé, les transports locaux et les coutumes à respecter pour un séjour réussi.</p>
                                <a href="{{ route('blog.show', 6) }}" class="inline-block text-green-600 font-semibold hover:text-green-800">
                                    Lire la suite
                                    <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Post 6 -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <img src="{{ asset('assets/images/blog-6.jpg') }}" alt="Hébergements insolites au Togo" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <div class="flex items-center text-sm text-gray-600 mb-3">
                                    <span class="mr-4">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        15 mars 2023
                                    </span>
                                    <span>
                                        <i class="far fa-user mr-1"></i>
                                        Par Elom Koudjo
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold mb-3">
                                    <a href="{{ route('blog.show', 7) }}" class="text-gray-800 hover:text-green-600">5 hébergements insolites à découvrir au Togo</a>
                                </h3>
                                <p class="text-gray-700 mb-4">Du lodge dans les arbres aux cases traditionnelles rénovées, découvrez notre sélection d'hébergements originaux pour une expérience inoubliable au Togo.</p>
                                <a href="{{ route('blog.show', 7) }}" class="inline-block text-green-600 font-semibold hover:text-green-800">
                                    Lire la suite
                                    <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8 flex justify-center">
                        <nav class="inline-flex rounded-md shadow">
                            <a href="#" class="py-2 px-4 bg-white border border-gray-300 rounded-l-md text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                            <a href="#" class="py-2 px-4 bg-green-600 border border-green-600 text-white">
                                1
                            </a>
                            <a href="#" class="py-2 px-4 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">
                                2
                            </a>
                            <a href="#" class="py-2 px-4 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">
                                3
                            </a>
                            <a href="#" class="py-2 px-4 bg-white border border-gray-300 rounded-r-md text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Sidebar -->
                <div>
                    <!-- Search -->
                    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                        <h3 class="text-lg font-semibold mb-4">Rechercher</h3>
                        <form>
                            <div class="flex">
                                <input type="text" placeholder="Rechercher..." class="flex-1 border border-gray-300 rounded-l-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-r-md hover:bg-green-700">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Categories -->
                    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                        <h3 class="text-lg font-semibold mb-4">Catégories</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="#" class="flex items-center justify-between text-gray-700 hover:text-green-600">
                                    <span>Culture & Traditions</span>
                                    <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs">8</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-between text-gray-700 hover:text-green-600">
                                    <span>Gastronomie</span>
                                    <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs">5</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-between text-gray-700 hover:text-green-600">
                                    <span>Conseils de voyage</span>
                                    <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs">12</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-between text-gray-700 hover:text-green-600">
                                    <span>Nature & Paysages</span>
                                    <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs">7</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-between text-gray-700 hover:text-green-600">
                                    <span>Festivals & Événements</span>
                                    <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs">4</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-between text-gray-700 hover:text-green-600">
                                    <span>Artisanat</span>
                                    <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs">6</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Recent Posts -->
                    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                        <h3 class="text-lg font-semibold mb-4">Articles récents</h3>
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <img src="{{ asset('assets/images/recent-1.jpg') }}" alt="Article récent" class="w-16 h-16 object-cover rounded mr-3">
                                <div>
                                    <h4 class="font-medium">
                                        <a href="{{ route('blog.show', 1) }}" class="text-gray-800 hover:text-green-600">Les meilleures périodes pour visiter le Togo</a>
                                    </h4>
                                    <span class="text-sm text-gray-600">15 juin 2023</span>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <img src="{{ asset('assets/images/recent-2.jpg') }}" alt="Article récent" class="w-16 h-16 object-cover rounded mr-3">
                                <div>
                                    <h4 class="font-medium">
                                        <a href="{{ route('blog.show', 2) }}" class="text-gray-800 hover:text-green-600">10 plats togolais à découvrir absolument</a>
                                    </h4>
                                    <span class="text-sm text-gray-600">2 juin 2023</span>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <img src="{{ asset('assets/images/recent-3.jpg') }}" alt="Article récent" class="w-16 h-16 object-cover rounded mr-3">
                                <div>
                                    <h4 class="font-medium">
                                        <a href="{{ route('blog.show', 3) }}" class="text-gray-800 hover:text-green-600">Guide des marchés traditionnels au Togo</a>
                                    </h4>
                                    <span class="text-sm text-gray-600">20 mai 2023</span>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <img src="{{ asset('assets/images/recent-4.jpg') }}" alt="Article récent" class="w-16 h-16 object-cover rounded mr-3">
                                <div>
                                    <h4 class="font-medium">
                                        <a href="{{ route('blog.show', 4) }}" class="text-gray-800 hover:text-green-600">L'artisanat togolais : traditions et savoir-faire</a>
                                    </h4>
                                    <span class="text-sm text-gray-600">5 mai 2023</span>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <!-- Tags -->
                    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                        <h3 class="text-lg font-semibold mb-4">Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            <a href="#" class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm hover:bg-green-100 hover:text-green-800">Togo</a>
                            <a href="#" class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm hover:bg-green-100 hover:text-green-800">Voyage</a>
                            <a href="#" class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm hover:bg-green-100 hover:text-green-800">Culture</a>
                            <a href="#" class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm hover:bg-green-100 hover:text-green-800">Gastronomie</a>
                            <a href="#" class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm hover:bg-green-100 hover:text-green-800">Artisanat</a>
                            <a href="#" class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm hover:bg-green-100 hover:text-green-800">Traditions</a>
                            <a href="#" class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm hover:bg-green-100 hover:text-green-800">Conseils</a>
                            <a href="#" class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm hover:bg-green-100 hover:text-green-800">Festivals</a>
                            <a href="#" class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm hover:bg-green-100 hover:text-green-800">Nature</a>
                            <a href="#" class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm hover:bg-green-100 hover:text-green-800">Hébergement</a>
                        </div>
                    </div>

                    <!-- Newsletter -->
                    <div class="bg-green-50 rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold mb-4">Newsletter</h3>
                        <p class="text-gray-700 mb-4">Abonnez-vous à notre newsletter pour recevoir nos derniers articles et conseils de voyage.</p>
                        <form>
                            <div class="mb-3">
                                <input type="email" placeholder="Votre adresse email" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                            </div>
                            <button type="submit" class="w-full bg-green-600 text-white font-medium py-2 px-4 rounded-md hover:bg-green-700 transition duration-300">
                                S'abonner
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection