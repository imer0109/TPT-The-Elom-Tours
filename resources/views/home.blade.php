@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="relative">
        <div class="hero-image h-screen bg-cover bg-center" style="background-image: url('{{ asset('assets/images/termite.jpg') }}');">
            <div class="absolute inset-0 opacity-50"></div>
            <div class="container mx-auto px-4 h-full flex items-center justify-center relative z-10">
                <div class="text-center text-white mt-20">
                    <h1 class="text-4xl md:text-6xl font-bold mb-4">DÉCOUVREZ LE TOGO AUTHENTIQUE</h1>
                    <p class="text-xl md:text-2xl mb-8">Explorez les merveilles naturelles et culturelles du Togo avec nos circuits écotouristiques uniques</p>
                    <a href="{{ route('circuits.index') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold mt-5 py-3 px-8 rounded-full transition duration-300 ease-in-out transform hover:scale-105">
                        Réserver maintenant
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Pourquoi choisir The Elom Tours ?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="text-center p-6 border border-gray-200 rounded-lg hover:shadow-lg transition duration-300">
                    <div class="text-green-600 text-4xl mb-4">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Circuits Authentiques</h3>
                    <p class="text-gray-600">Découvrez des itinéraires uniques conçus par des experts locaux pour une immersion totale dans la culture africaine.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="text-center p-6 border border-gray-200 rounded-lg hover:shadow-lg transition duration-300">
                    <div class="text-green-600 text-4xl mb-4">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Guides Expérimentés</h3>
                    <p class="text-gray-600">Nos guides locaux passionnés vous feront découvrir les trésors cachés et partageront leur connaissance approfondie.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="text-center p-6 border border-gray-200 rounded-lg hover:shadow-lg transition duration-300">
                    <div class="text-green-600 text-4xl mb-4">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Tourisme Responsable</h3>
                    <p class="text-gray-600">Nous nous engageons pour un tourisme durable qui respecte l'environnement et soutient les communautés locales.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Destinations -->
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Nos destinations populaires</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Destinations statiques -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition duration-300">
                    <img src="{{ asset('assets/images/lome.jpg') }}" alt="Lomé" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Lomé, Togo</h3>
                        <p class="text-gray-600 mb-4">Découvrez la vibrante capitale du Togo avec ses marchés colorés et son riche patrimoine culturel.</p>
                        <a href="#" class="text-green-600 hover:text-green-800 font-medium">Découvrir <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition duration-300">
                    <img src="{{ asset('assets/images/kpalime.jpg') }}" alt="Kpalimé" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Kpalimé, Togo</h3>
                        <p class="text-gray-600 mb-4">Explorez les magnifiques paysages montagneux et les cascades spectaculaires de cette région verdoyante.</p>
                        <a href="#" class="text-green-600 hover:text-green-800 font-medium">Découvrir <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition duration-300">
                    <img src="{{ asset('assets/images/ouidah.jpg') }}" alt="Ouidah" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Ouidah, Bénin</h3>
                        <p class="text-gray-600 mb-4">Visitez ce haut lieu historique du vaudou et découvrez la Route des Esclaves, site du patrimoine mondial.</p>
                        <a href="#" class="text-green-600 hover:text-green-800 font-medium">Découvrir <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('destinations.index') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-full transition duration-300 ease-in-out transform hover:scale-105">
                    Voir toutes nos destinations
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Ce que disent nos voyageurs</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Témoignages statiques -->
                <div class="bg-gray-50 p-6 rounded-lg shadow">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-full mr-4 bg-green-100 flex items-center justify-center text-green-600">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold">Sophie Martin</h4>
                            <div class="text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"Une expérience inoubliable avec The Elom Tours. Les guides étaient exceptionnels et nous ont fait découvrir des lieux magnifiques hors des sentiers battus."</p>
                </div>
                
                <div class="bg-gray-50 p-6 rounded-lg shadow">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-full mr-4 bg-green-100 flex items-center justify-center text-green-600">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold">Jean Dupont</h4>
                            <div class="text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"Voyage extraordinaire au Togo avec The Elom Tours. Organisation parfaite, guides compétents et paysages à couper le souffle. Je recommande vivement !"</p>
                </div>
                
                <div class="bg-gray-50 p-6 rounded-lg shadow">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-full mr-4 bg-green-100 flex items-center justify-center text-green-600">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold">Marie Leclerc</h4>
                            <div class="text-yellow-500">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"Merci à toute l'équipe pour ce circuit exceptionnel. La découverte des villages traditionnels et des cérémonies locales restera gravée dans ma mémoire pour toujours."</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Circuits en vedette -->
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Nos circuits en vedette</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($featuredCircuits as $circuit)
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition duration-300">
                        <div class="relative">
                            @if($circuit->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $circuit->images->first()->url) }}" 
                                     alt="{{ $circuit->images->first()->alt ?? $circuit->titre }}" 
                                     class="w-full h-64 object-cover">
                            @else
                                <img src="{{ asset('assets/images/circuit-placeholder.jpg') }}" 
                                     alt="{{ $circuit->titre }}" 
                                     class="w-full h-64 object-cover">
                            @endif

                            <div class="absolute top-4 right-4 bg-green-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                                {{ $circuit->duree }} jours
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-2">{{ $circuit->titre }}</h3>
                            <div class="flex items-center mb-4">
                                <div class="text-yellow-500 mr-1">
                                    @php
                                        $rating = $circuit->avis ? $circuit->avis->avg('rating') : 0;
                                        $fullStars = floor($rating);
                                        $halfStar = $rating - $fullStars >= 0.5;
                                    @endphp
                                    
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $fullStars)
                                            <i class="fas fa-star"></i>
                                        @elseif($i == $fullStars + 1 && $halfStar)
                                            <i class="fas fa-star-half-alt"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-gray-600 text-sm">({{ $circuit->avis ? $circuit->avis->count() : 0 }} avis)</span>
                            </div>
                            <p class="text-gray-600 mb-4">{{ Str::limit($circuit->description, 100) }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-green-600 font-bold">{{ number_format($circuit->prix, 0, ',', ' ') }} FCFA</span>
                                <a href="{{ route('circuits.show', $circuit->slug) }}" class="text-green-600 hover:text-green-800 font-medium">Découvrir <i class="fas fa-arrow-right ml-1"></i></a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-8">
                        <p class="text-gray-600">Aucun circuit en vedette disponible pour le moment.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('circuits.index') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-full transition duration-300 ease-in-out transform hover:scale-105">
                    Voir tous nos circuits
                </a>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-16 bg-green-600 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Prêt à vivre une aventure inoubliable ?</h2>
            <p class="text-xl mb-8">Contactez-nous dès aujourd'hui pour planifier votre prochain voyage en Afrique de l'Ouest</p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('contact.index') }}" class="bg-white text-green-600 hover:bg-gray-100 font-bold py-3 px-8 rounded-full transition duration-300 ease-in-out transform hover:scale-105">
                    Nous contacter
                </a>
                <a href="{{ route('circuits.index') }}" class="bg-transparent hover:bg-green-700 border-2 border-white font-bold py-3 px-8 rounded-full transition duration-300 ease-in-out transform hover:scale-105">
                    Voir nos circuits
                </a>
            </div>
        </div>
    </section>
@endsection