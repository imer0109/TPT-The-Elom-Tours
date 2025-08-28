@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="relative">
        <div class="hero-image h-64 md:h-96 bg-cover bg-center bg-[#16a34a]">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="container mx-auto px-4 h-full flex items-center justify-center relative z-10">
                <div class="text-center text-white">
                    <h1 class="text-3xl md:text-5xl font-bold mb-2">À propos de nous</h1>
                    <p class="text-lg md:text-xl">Découvrez l'histoire et les valeurs de The Elom Tours</p>
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
                <span class="text-gray-800">À propos</span>
            </div>
        </div>
    </div>

    <!-- About Content -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <!-- Notre histoire -->
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Notre histoire</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div>
                        <p class="text-gray-600 mb-4">
                            Fondée en 2020, The Elom Tours est née d'une passion profonde pour le Togo et sa richesse culturelle. Notre fondateur, Elom Kokou, originaire de la région des Plateaux, a grandi entouré des traditions et paysages magnifiques du pays.
                        </p>
                        <p class="text-gray-600 mb-4">
                            Après avoir travaillé pendant plus de 10 ans dans le secteur du tourisme international, Elom a décidé de revenir au Togo pour créer une agence qui mettrait en valeur les trésors cachés de son pays natal et offrirait aux voyageurs des expériences authentiques et respectueuses des communautés locales.
                        </p>
                        <p class="text-gray-600">
                            Aujourd'hui, The Elom Tours est fière de faire découvrir le Togo et l'Afrique de l'Ouest à des voyageurs du monde entier, tout en contribuant au développement durable des communautés locales.
                        </p>
                    </div>
                    <div class="rounded-lg overflow-hidden shadow-lg">
                        <img src="{{ asset('assets/images/about-history.svg') }}" alt="Notre histoire" class="w-full h-auto">
                    </div>
                </div>
            </div>
            
            <!-- Notre mission -->
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Notre mission</h2>
                <div class="bg-green-50 p-8 rounded-lg shadow-md">
                    <div class="flex flex-col md:flex-row items-center">
                        <div class="md:w-1/4 mb-6 md:mb-0 flex justify-center">
                            <div class="w-24 h-24 rounded-full bg-green-600 flex items-center justify-center">
                                <i class="fas fa-globe-africa text-white text-4xl"></i>
                            </div>
                        </div>
                        <div class="md:w-3/4 md:pl-8">
                            <p class="text-gray-700 text-lg">
                                Notre mission est de promouvoir un tourisme responsable et durable au Togo, en offrant des expériences de voyage authentiques qui respectent l'environnement et valorisent les cultures locales. Nous nous engageons à :
                            </p>
                            <ul class="mt-4 space-y-2">
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-600 mt-1 mr-2"></i>
                                    <span>Faire découvrir la richesse culturelle et naturelle du Togo</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-600 mt-1 mr-2"></i>
                                    <span>Soutenir les communautés locales à travers nos activités touristiques</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-600 mt-1 mr-2"></i>
                                    <span>Minimiser notre impact environnemental et promouvoir des pratiques écologiques</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-600 mt-1 mr-2"></i>
                                    <span>Offrir un service personnalisé et de qualité à nos clients</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Notre équipe -->
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Notre équipe</h2>
                <p class="text-gray-600 mb-8 max-w-3xl">
                    Notre équipe est composée de professionnels passionnés, tous experts dans leur domaine et profondément attachés au Togo. Nous partageons tous la même vision : faire vivre des expériences inoubliables à nos clients tout en contribuant positivement au développement local.
                </p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Membre 1 -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
                        <img src="{{ asset('assets/images/team-1.svg') }}" alt="Elom Kokou" class="w-full h-64 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-1">Elom Kokou</h3>
                            <p class="text-green-600 font-medium mb-3">Fondateur & Directeur</p>
                            <p class="text-gray-600 mb-4">
                                Passionné de voyage et d'écotourisme, Elom a plus de 15 ans d'expérience dans le secteur touristique.
                            </p>
                            <div class="flex space-x-3">
                                <a href="#" class="text-gray-400 hover:text-blue-500"><i class="fab fa-linkedin"></i></a>
                                <a href="#" class="text-gray-400 hover:text-blue-400"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="text-gray-400 hover:text-green-600"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Membre 2 -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
                        <img src="{{ asset('assets/images/team-2.svg') }}" alt="Ama Sika" class="w-full h-64 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-1">Ama Sika</h3>
                            <p class="text-green-600 font-medium mb-3">Responsable des circuits</p>
                            <p class="text-gray-600 mb-4">
                                Spécialiste des itinéraires et de la logistique, Ama connaît chaque recoin du Togo et des pays voisins.
                            </p>
                            <div class="flex space-x-3">
                                <a href="#" class="text-gray-400 hover:text-blue-500"><i class="fab fa-linkedin"></i></a>
                                <a href="#" class="text-gray-400 hover:text-blue-400"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="text-gray-400 hover:text-green-600"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Membre 3 -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
                        <img src="{{ asset('assets/images/team-3.svg') }}" alt="Kodjo Mensah" class="w-full h-64 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-1">Kodjo Mensah</h3>
                            <p class="text-green-600 font-medium mb-3">Guide touristique senior</p>
                            <p class="text-gray-600 mb-4">
                                Guide expérimenté et polyglotte, Kodjo est passionné par l'histoire et les traditions du Togo.
                            </p>
                            <div class="flex space-x-3">
                                <a href="#" class="text-gray-400 hover:text-blue-500"><i class="fab fa-linkedin"></i></a>
                                <a href="#" class="text-gray-400 hover:text-blue-400"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="text-gray-400 hover:text-green-600"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Nos valeurs -->
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Nos valeurs</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Valeur 1 -->
                    <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-green-600">
                        <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mb-4">
                            <i class="fas fa-handshake text-green-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Authenticité</h3>
                        <p class="text-gray-600">
                            Nous privilégions les expériences authentiques qui permettent une véritable immersion dans la culture togolaise.
                        </p>
                    </div>
                    
                    <!-- Valeur 2 -->
                    <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-green-600">
                        <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mb-4">
                            <i class="fas fa-leaf text-green-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Durabilité</h3>
                        <p class="text-gray-600">
                            Nous nous engageons à minimiser notre impact environnemental et à promouvoir des pratiques touristiques durables.
                        </p>
                    </div>
                    
                    <!-- Valeur 3 -->
                    <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-green-600">
                        <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mb-4">
                            <i class="fas fa-users text-green-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Communauté</h3>
                        <p class="text-gray-600">
                            Nous soutenons activement les communautés locales et veillons à ce que le tourisme leur soit bénéfique.
                        </p>
                    </div>
                    
                    <!-- Valeur 4 -->
                    <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-green-600">
                        <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mb-4">
                            <i class="fas fa-star text-green-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Excellence</h3>
                        <p class="text-gray-600">
                            Nous nous efforçons d'offrir un service de qualité exceptionnelle et une attention personnalisée à chaque client.
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Témoignages -->
            <div>
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Ce que disent nos clients</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Témoignage 1 -->
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="flex items-center mb-4">
                            <div class="text-yellow-400 flex mr-2">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="text-gray-600 text-sm">5.0</span>
                        </div>
                        <p class="text-gray-600 italic mb-4">
                            "Une expérience inoubliable ! The Elom Tours nous a fait découvrir un Togo authentique, loin des sentiers battus. Notre guide était exceptionnel et le circuit parfaitement organisé."
                        </p>
                        <div class="flex items-center">
                            <img src="{{ asset('assets/images/testimonial-1.svg') }}" alt="Sophie Martin" class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <h4 class="font-bold text-gray-800">Sophie Martin</h4>
                                <p class="text-gray-500 text-sm">France</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Témoignage 2 -->
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="flex items-center mb-4">
                            <div class="text-yellow-400 flex mr-2">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="text-gray-600 text-sm">5.0</span>
                        </div>
                        <p class="text-gray-600 italic mb-4">
                            "Je recommande vivement The Elom Tours pour leur professionnalisme et leur connaissance approfondie du pays. J'ai particulièrement apprécié les rencontres avec les artisans locaux."
                        </p>
                        <div class="flex items-center">
                            <img src="{{ asset('assets/images/testimonial-2.svg') }}" alt="John Smith" class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <h4 class="font-bold text-gray-800">John Smith</h4>
                                <p class="text-gray-500 text-sm">États-Unis</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Témoignage 3 -->
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="flex items-center mb-4">
                            <div class="text-yellow-400 flex mr-2">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="text-gray-600 text-sm">4.5</span>
                        </div>
                        <p class="text-gray-600 italic mb-4">
                            "Un voyage enrichissant qui m'a permis de découvrir la culture togolaise dans toute sa diversité. L'équipe de The Elom Tours est attentionnée et très professionnelle."
                        </p>
                        <div class="flex items-center">
                            <img src="{{ asset('assets/images/testimonial-3.svg') }}" alt="Maria Rodriguez" class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <h4 class="font-bold text-gray-800">Maria Rodriguez</h4>
                                <p class="text-gray-500 text-sm">Espagne</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Call to Action -->
    <section class="py-16 bg-green-600">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Prêt à découvrir le Togo avec nous ?</h2>
            <p class="text-white text-lg mb-8 max-w-3xl mx-auto">
                Contactez-nous dès aujourd'hui pour planifier votre prochain voyage et vivre une expérience authentique au cœur de l'Afrique de l'Ouest.
            </p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('circuits.index') }}" class="bg-white text-green-600 hover:bg-gray-100 font-bold py-3 px-8 rounded-full transition duration-300">
                    Découvrir nos circuits
                </a>
                <a href="{{ route('contact.index') }}" class="bg-transparent text-white hover:bg-green-700 border-2 border-white font-bold py-3 px-8 rounded-full transition duration-300">
                    Nous contacter
                </a>
            </div>
        </div>
    </section>
@endsection