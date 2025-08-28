@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="relative">
        <div class="hero-image h-64 md:h-96 bg-cover bg-center bg-[#16a34a]" 
        {{-- style="background-image: url('{{ asset('assets/images/circuits-hero.jpg') }}')" --}}
        >
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="container mx-auto px-4 h-full flex items-center justify-center relative z-10">
                <div class="text-center text-white">
                    <h1 class="text-3xl md:text-5xl font-bold mb-2">Nos Circuits</h1>
                    <p class="text-lg md:text-xl">Découvrez nos itinéraires soigneusement conçus pour une expérience authentique</p>
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
                <span class="text-gray-800">Circuits</span>
            </div>
        </div>
    </div>

    <!-- Circuits List -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <!-- Filter Options -->
            <div class="mb-8 p-4 bg-white rounded-lg shadow-sm">
                <h3 class="text-lg font-semibold mb-4">Filtrer les circuits</h3>
                <form action="{{ route('circuits.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Destination</label>
                        <select name="destination" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Toutes les destinations</option>
                            @foreach($destinations as $destination)
                                <option value="{{ $destination->id }}" {{ request('destination') == $destination->id ? 'selected' : '' }}>
                                    {{ $destination->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Durée</label>
                        <select name="duration" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Toutes les durées</option>
                            <option value="1-3" {{ request('duration') == '1-3' ? 'selected' : '' }}>1-3 jours</option>
                            <option value="4-7" {{ request('duration') == '4-7' ? 'selected' : '' }}>4-7 jours</option>
                            <option value="8+" {{ request('duration') == '8+' ? 'selected' : '' }}>8+ jours</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Thème</label>
                        <select name="theme" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Tous les thèmes</option>
                            <option value="culture" {{ request('theme') == 'culture' ? 'selected' : '' }}>Culture</option>
                            <option value="nature" {{ request('theme') == 'nature' ? 'selected' : '' }}>Nature</option>
                            <option value="aventure" {{ request('theme') == 'aventure' ? 'selected' : '' }}>Aventure</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md w-full transition duration-300">
                            Appliquer les filtres
                        </button>
                    </div>
                </form>
            </div>

            <!-- Circuits Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($circuits as $circuit)
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition duration-300">
                        <div class="relative">
                            @if($circuit->image)
                                <img src="{{ asset('storage/' . $circuit->image) }}" alt="{{ $circuit->title }}" class="w-full h-64 object-cover">
                            @else
                                <img src="{{ asset('assets/images/circuit-placeholder.jpg') }}" alt="{{ $circuit->title }}" class="w-full h-64 object-cover">
                            @endif
                            <div class="absolute top-4 right-4 bg-green-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                                {{ $circuit->duration }} jours
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-2">{{ $circuit->title }}</h3>
                            <div class="flex items-center mb-4">
                                <div class="text-yellow-500 mr-1">
                                    @php
                                        $rating = $circuit->reviews ? $circuit->reviews->avg('rating') : 0;
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
                                <span class="text-gray-600 text-sm">({{ $circuit->reviews ? $circuit->reviews->count() : 0 }} avis)</span>
                            </div>
                            <p class="text-gray-600 mb-4">{{ Str::limit($circuit->description, 120) }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-green-600 font-bold text-xl">{{ $circuit->price }}€ / personne</span>
                                <a href="{{ route('circuits.show', $circuit->slug) }}" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition duration-300">
                                    Détails
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-8">
                        <p class="text-gray-500 text-lg">Aucun circuit ne correspond à vos critères de recherche.</p>
                        <a href="{{ route('circuits.index') }}" class="inline-block mt-4 text-green-600 hover:text-green-800 font-medium">
                            Voir tous les circuits
                        </a>
                    </div>
                @endforelse
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Safari photo au Ghana</h3>
                        <div class="flex items-center mb-4">
                            <div class="text-yellow-500 mr-1">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="text-gray-600 text-sm">(15 avis)</span>
                        </div>
                        <p class="text-gray-600 mb-4">Partez à la découverte de la faune sauvage ghanéenne dans les parcs nationaux de Mole et Kakum.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold text-xl">950€ / personne</span>
                            <a href="#" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition duration-300">
                                Détails
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Circuit 6 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition duration-300">
                    <div class="relative">
                        <img src="{{ asset('assets/images/circuit-6.jpg') }}" alt="Route des esclaves au Bénin" class="w-full h-64 object-cover">
                        <div class="absolute top-4 right-4 bg-green-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                            4 jours
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Route des esclaves au Bénin</h3>
                        <div class="flex items-center mb-4">
                            <div class="text-yellow-500 mr-1">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <span class="text-gray-600 text-sm">(11 avis)</span>
                        </div>
                        <p class="text-gray-600 mb-4">Un circuit historique sur les traces de la traite négrière, de Ouidah à Porto-Novo en passant par Abomey.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold text-xl">550€ / personne</span>
                            <a href="#" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition duration-300">
                                Détails
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                <nav class="inline-flex rounded-md shadow">
                    <a href="#" class="py-2 px-4 bg-white border border-gray-300 text-gray-500 hover:bg-gray-50 rounded-l-md">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <a href="#" class="py-2 px-4 bg-green-600 border border-green-600 text-white hover:bg-green-700">1</a>
                    <a href="#" class="py-2 px-4 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">2</a>
                    <a href="#" class="py-2 px-4 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">3</a>
                    <a href="#" class="py-2 px-4 bg-white border border-gray-300 text-gray-500 hover:bg-gray-50 rounded-r-md">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </nav>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-12 bg-green-600 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Vous ne trouvez pas le circuit idéal ?</h2>
            <p class="text-xl mb-8">Contactez-nous pour créer un circuit sur mesure adapté à vos envies et à votre budget</p>
            <a href="#" class="bg-white text-green-600 hover:bg-gray-100 font-bold py-3 px-8 rounded-full transition duration-300 ease-in-out transform hover:scale-105">
                Demander un devis personnalisé
            </a>
        </div>
    </section>
@endsection