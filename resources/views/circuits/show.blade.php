@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="relative">
        <div class="hero-image h-64 md:h-96 bg-cover bg-center bg-[#16a34a]" 
        {{-- style="background-image: url('{{ $circuit->image ? $circuit->image->url : asset('assets/images/circuit-detail-hero.jpg') }}')" --}}
        >
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="container mx-auto px-4 h-full flex items-center justify-center relative z-10">
                <div class="text-center text-white">
                    <h1 class="text-3xl md:text-5xl font-bold mb-2">{{ $circuit->title }}</h1>
                    <p class="text-lg md:text-xl">{{ $circuit->subtitle }}</p>
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
                <a href="{{ route('circuits.index') }}" class="text-gray-600 hover:text-green-600">Circuits</a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-gray-800">{{ $circuit->title }}</span>
            </div>
        </div>
    </div>

    <!-- Circuit Details -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Overview -->
                    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                        <h2 class="text-2xl font-bold mb-4">Aperçu du circuit</h2>
                        <p class="text-gray-700 mb-6">{{ $circuit->description }}</p>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                            <div class="text-center p-3 bg-gray-50 rounded-lg">
                                <div class="text-green-600 text-2xl mb-1">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <p class="text-sm text-gray-600">Durée</p>
                                <p class="font-semibold">{{ $circuit->duration }} jours</p>
                            </div>
                            <div class="text-center p-3 bg-gray-50 rounded-lg">
                                <div class="text-green-600 text-2xl mb-1">
                                    <i class="fas fa-users"></i>
                                </div>
                                <p class="text-sm text-gray-600">Taille du groupe</p>
                                <p class="font-semibold">{{ $circuit->group_size }}</p>
                            </div>
                            <div class="text-center p-3 bg-gray-50 rounded-lg">
                                <div class="text-green-600 text-2xl mb-1">
                                    <i class="fas fa-language"></i>
                                </div>
                                <p class="text-sm text-gray-600">Langues</p>
                                <p class="font-semibold">{{ $circuit->languages }}</p>
                            </div>
                            <div class="text-center p-3 bg-gray-50 rounded-lg">
                                <div class="text-green-600 text-2xl mb-1">
                                    <i class="fas fa-hiking"></i>
                                </div>
                                <p class="text-sm text-gray-600">Difficulté</p>
                                <p class="font-semibold">{{ $circuit->difficulty }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center mb-6">
                            <div class="text-yellow-500 mr-2">
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
                            <span class="text-gray-600">{{ number_format($rating, 1) }}/5 ({{ $circuit->reviews ? $circuit->reviews->count() : 0 }} avis)</span>
                        </div>
                        
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(',', $circuit->tags) as $tag)
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm">{{ trim($tag) }}</span>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Itinerary -->
                    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                        <h2 class="text-2xl font-bold mb-6">Itinéraire</h2>
                        
                        @forelse($circuit->etapes as $step)
                            <div class="mb-6 border-l-4 border-green-600 pl-4">
                                <h3 class="text-xl font-semibold mb-2">Jour {{ $step->jour }}: {{ $step->titre }}</h3>
                                <p class="text-gray-700 mb-4">{{ $step->description }}</p>
                                @if($step->lieu)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-bed mr-2"></i>
                                        <span>Hébergement: {{ $step->lieu }}</span>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <!-- Fallback itinerary if no steps are found -->
                            <div class="mb-6 border-l-4 border-green-600 pl-4">
                                <h3 class="text-xl font-semibold mb-2">Jour 1: Arrivée à Lomé</h3>
                                <p class="text-gray-700 mb-4">Accueil à l'aéroport international de Lomé et transfert vers votre hôtel. Selon l'heure d'arrivée, visite du Grand Marché de Lomé et dîner de bienvenue avec présentation du circuit.</p>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-bed mr-2"></i>
                                    <span>Hébergement: Hôtel 3* à Lomé</span>
                                </div>
                            </div>
                            
                            <div class="mb-6 border-l-4 border-green-600 pl-4">
                                <h3 class="text-xl font-semibold mb-2">Jour 2: Lomé - Togoville</h3>
                                <p class="text-gray-700 mb-4">Visite du Musée National et du village artisanal de Lomé. Après le déjeuner, départ pour Togoville en traversant le lac Togo en pirogue. Découverte de ce village historique et de son patrimoine vaudou.</p>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-bed mr-2"></i>
                                    <span>Hébergement: Auberge locale à Togoville</span>
                                </div>
                            </div>
                        @endforelse
                        
                        @if($circuit->etapes && $circuit->etapes->count() > 3)
                            <!-- Show More Button -->
                            <button id="showMoreBtn" class="text-green-600 hover:text-green-800 font-medium flex items-center">
                                Voir l'itinéraire complet
                                <i class="fas fa-chevron-down ml-1"></i>
                            </button>
                        @endif
                    </div>
                    
                    <!-- Included/Not Included -->
                    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                        <h2 class="text-2xl font-bold mb-6">Ce qui est inclus</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-semibold mb-3">Inclus dans le prix</h3>
                                <ul class="space-y-2">
                                    @forelse(explode('\n', $circuit->included ?? '') as $included)
                                        @if(trim($included))
                                            <li class="flex items-start">
                                                <i class="fas fa-check text-green-600 mt-1 mr-2"></i>
                                                <span>{{ trim($included) }}</span>
                                            </li>
                                        @endif
                                    @empty
                                        <li class="flex items-start">
                                            <i class="fas fa-check text-green-600 mt-1 mr-2"></i>
                                            <span>Tous les hébergements mentionnés</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-check text-green-600 mt-1 mr-2"></i>
                                            <span>Tous les transports terrestres</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-check text-green-600 mt-1 mr-2"></i>
                                            <span>Guide francophone pendant tout le circuit</span>
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-semibold mb-3">Non inclus dans le prix</h3>
                                <ul class="space-y-2">
                                    @forelse(explode('\n', $circuit->excluded ?? '') as $excluded)
                                        @if(trim($excluded))
                                            <li class="flex items-start">
                                                <i class="fas fa-times text-red-600 mt-1 mr-2"></i>
                                                <span>{{ trim($excluded) }}</span>
                                            </li>
                                        @endif
                                    @empty
                                        <li class="flex items-start">
                                            <i class="fas fa-times text-red-600 mt-1 mr-2"></i>
                                            <span>Vols internationaux</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-times text-red-600 mt-1 mr-2"></i>
                                            <span>Frais de visa</span>
                                        </li>
                                        <li class="flex items-start">
                                            <i class="fas fa-times text-red-600 mt-1 mr-2"></i>
                                            <span>Assurance voyage</span>
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                                        <i class="fas fa-times text-red-600 mt-1 mr-2"></i>
                                        <span>Dépenses personnelles</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-times text-red-600 mt-1 mr-2"></i>
                                        <span>Pourboires</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Gallery -->
                    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                        <h2 class="text-2xl font-bold mb-6">Galerie photos</h2>
                        
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @forelse($circuit->images as $image)
                                <img src="{{ $image->url }}" alt="{{ $circuit->titre }}" class="rounded-lg hover:opacity-90 transition duration-300 cursor-pointer">
                            @empty
                                <img src="{{ asset('assets/images/gallery-1.jpg') }}" alt="Photo du circuit" class="rounded-lg hover:opacity-90 transition duration-300 cursor-pointer">
                                <img src="{{ asset('assets/images/gallery-2.jpg') }}" alt="Photo du circuit" class="rounded-lg hover:opacity-90 transition duration-300 cursor-pointer">
                                <img src="{{ asset('assets/images/gallery-3.jpg') }}" alt="Photo du circuit" class="rounded-lg hover:opacity-90 transition duration-300 cursor-pointer">
                            @endforelse
                        </div>
                    </div>
                    
                    <!-- Reviews -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold mb-6">Avis des voyageurs</h2>
                        
                        <div class="mb-8">
                            <div class="flex items-center mb-4">
                                <div class="text-yellow-500 text-xl mr-2">
                                    @php
                                        $rating = $circuit->avis ? $circuit->avis->avg('rating') : 0;
                                        $fullStars = floor($rating);
                                        $halfStar = $rating - $fullStars >= 0.5;
                                        $reviewCount = $circuit->avis ? $circuit->avis->count() : 0;
                                        
                                        // Calculate percentages for each star rating
                                        $starCounts = [0, 0, 0, 0, 0, 0]; // Index 0 is unused, 1-5 for star counts
                                        if($circuit->avis) {
                                            foreach($circuit->avis as $review) {
                                                $starCounts[round($review->rating)]++;
                                            }
                                        }
                                        
                                        $starPercentages = [];
                                        for($i = 5; $i >= 1; $i--) {
                                            $starPercentages[$i] = $reviewCount > 0 ? round(($starCounts[$i] / $reviewCount) * 100) : 0;
                                        }
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
                                <span class="text-xl font-semibold">{{ number_format($rating, 1) }}/5</span>
                                <span class="text-gray-600 ml-2">({{ $reviewCount }} avis)</span>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex items-center">
                                    <span class="w-24 text-sm">5 étoiles</span>
                                    <div class="flex-1 h-2 bg-gray-200 rounded-full mx-2">
                                        <div class="h-2 bg-yellow-500 rounded-full" style="width: {{ $starPercentages[5] }}%"></div>
                                    </div>
                                    <span class="text-sm">{{ $starPercentages[5] }}%</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-24 text-sm">4 étoiles</span>
                                    <div class="flex-1 h-2 bg-gray-200 rounded-full mx-2">
                                        <div class="h-2 bg-yellow-500 rounded-full" style="width: {{ $starPercentages[4] }}%"></div>
                                    </div>
                                    <span class="text-sm">{{ $starPercentages[4] }}%</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-24 text-sm">3 étoiles</span>
                                    <div class="flex-1 h-2 bg-gray-200 rounded-full mx-2">
                                        <div class="h-2 bg-yellow-500 rounded-full" style="width: {{ $starPercentages[3] }}%"></div>
                                    </div>
                                    <span class="text-sm">{{ $starPercentages[3] }}%</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-24 text-sm">2 étoiles</span>
                                    <div class="flex-1 h-2 bg-gray-200 rounded-full mx-2">
                                        <div class="h-2 bg-yellow-500 rounded-full" style="width: {{ $starPercentages[2] }}%"></div>
                                    </div>
                                    <span class="text-sm">{{ $starPercentages[2] }}%</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-24 text-sm">1 étoile</span>
                                    <div class="flex-1 h-2 bg-gray-200 rounded-full mx-2">
                                        <div class="h-2 bg-yellow-500 rounded-full" style="width: {{ $starPercentages[1] }}%"></div>
                                    </div>
                                    <span class="text-sm">{{ $starPercentages[1] }}%</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Individual Reviews -->
                        <div class="space-y-6">
                            @forelse($circuit->avis->where('is_approved', true)->sortByDesc('created_at')->take(5) as $review)
                                <div class="border-b border-gray-200 pb-6">
                                    <div class="flex items-center mb-2">
                                        <img src="{{ $review->user && $review->user->avatar ? $review->user->avatar : asset('assets/images/avatar-default.jpg') }}" alt="Avatar" class="w-12 h-12 rounded-full mr-4">
                                        <div>
                                            <h4 class="font-semibold">{{ $review->user ? $review->user->name : $review->name }}</h4>
                                            <div class="flex items-center">
                                                <div class="text-yellow-500 mr-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->rating)
                                                            <i class="fas fa-star"></i>
                                                        @else
                                                            <i class="far fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <span class="text-gray-600 text-sm">{{ $review->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-700">"{{ $review->comment }}"</p>
                                </div>
                            @empty
                                <!-- Fallback reviews if no reviews are found -->
                                <div class="border-b border-gray-200 pb-6">
                                    <div class="flex items-center mb-2">
                                        <img src="{{ asset('assets/images/avatar-1.jpg') }}" alt="Avatar" class="w-12 h-12 rounded-full mr-4">
                                        <div>
                                            <h4 class="font-semibold">Sophie Martin</h4>
                                            <div class="flex items-center">
                                                <div class="text-yellow-500 mr-1">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                                <span class="text-gray-600 text-sm">il y a 2 mois</span>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-700">"Une expérience inoubliable ! Notre guide était extrêmement compétent et passionné. Les villages visités étaient authentiques et l'accueil des habitants chaleureux. Je recommande vivement ce circuit pour découvrir la vraie culture togolaise."</p>
                                </div>
                            @endforelse
                            
                            <!-- Review 3 -->
                            <div>
                                <div class="flex items-center mb-2">
                                    <img src="{{ asset('assets/images/avatar-3.jpg') }}" alt="Avatar" class="w-12 h-12 rounded-full mr-4">
                                    <div>
                                        <h4 class="font-semibold">Claire Lefèvre</h4>
                                        <div class="flex items-center">
                                            <div class="text-yellow-500 mr-1">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                            </div>
                                            <span class="text-gray-600 text-sm">il y a 1 mois</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-700">"J'ai adoré ce circuit qui nous a permis de découvrir un Togo authentique, loin des sentiers touristiques. Les rencontres avec les artisans locaux étaient particulièrement enrichissantes. L'hébergement était simple mais confortable et la nourriture délicieuse."</p>
                            </div>
                        </div>
                        
                        <!-- Show More Reviews Button -->
                        <button class="mt-6 text-green-600 hover:text-green-800 font-medium flex items-center">
                            Voir plus d'avis
                            <i class="fas fa-chevron-down ml-1"></i>
                        </button>
                        
                        <!-- Review Form -->
                        <div class="mt-8 border-t pt-8">
                            <h3 class="text-xl font-semibold mb-4">Laissez votre avis</h3>
                            
                            @if(session('success'))
                                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                                    <strong class="font-bold">Succès!</strong>
                                    <span class="block sm:inline">{{ session('success') }}</span>
                                </div>
                            @endif
                            
                            <form action="{{ route('circuits.review', $circuit->slug) }}" method="POST" class="space-y-6">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="name" class="block text-gray-700 text-sm font-medium mb-2">Nom complet *</label>
                                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('name') border-red-500 @enderror" required>
                                        @error('name')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email *</label>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('email') border-red-500 @enderror" required>
                                        @error('email')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 text-sm font-medium mb-2">Note *</label>
                                    <div class="flex items-center space-x-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <label for="rating-{{ $i }}" class="cursor-pointer text-2xl text-gray-300 hover:text-yellow-500 peer-checked:text-yellow-500">
                                                <input type="radio" id="rating-{{ $i }}" name="rating" value="{{ $i }}" class="sr-only peer" {{ old('rating') == $i ? 'checked' : '' }} required>
                                                <i class="fas fa-star"></i>
                                            </label>
                                        @endfor
                                    </div>
                                    @error('rating')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="comment" class="block text-gray-700 text-sm font-medium mb-2">Votre avis *</label>
                                    <textarea id="comment" name="comment" rows="4" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('comment') border-red-500 @enderror" required>{{ old('comment') }}</textarea>
                                    @error('comment')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-md transition duration-300">
                                        Soumettre mon avis
                                    </button>
                                </div>
                                <p class="text-sm text-gray-600">Votre avis sera publié après modération par notre équipe.</p>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div>
                    <!-- Booking Widget -->
                    <div class="bg-white rounded-lg shadow-md p-6 mb-8 sticky top-4">
                        <div class="text-center mb-6">
                            <span class="text-3xl font-bold text-green-600">850€</span>
                            <span class="text-gray-600">/ personne</span>
                        </div>
                        
                        <form action="{{ route('reservations.store', ['slug' => $circuit->slug]) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-medium mb-2" for="date_debut">Date de départ</label>
                                <input type="date" id="date_debut" name="date_debut" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('date_debut') border-red-500 @enderror" min="{{ date('Y-m-d') }}" required>
                                @error('date_debut')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-medium mb-2" for="nombre_personnes">Nombre de voyageurs</label>
                                <select id="nombre_personnes" name="nombre_personnes" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('nombre_personnes') border-red-500 @enderror" required>
                                    <option value="1">1 personne</option>
                                    <option value="2">2 personnes</option>
                                    <option value="3">3 personnes</option>
                                    <option value="4">4 personnes</option>
                                    <option value="5">5 personnes</option>
                                    <option value="6">6 personnes</option>
                                    <option value="7">7 personnes</option>
                                    <option value="8">8 personnes</option>
                                    <option value="9">9 personnes</option>
                                    <option value="10">10 personnes</option>
                                </select>
                                @error('nombre_personnes')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-medium mb-2" for="commentaire">Commentaire (optionnel)</label>
                                <textarea id="commentaire" name="commentaire" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                            </div>
                            
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-md transition duration-300 mb-4">
                                Réserver maintenant
                            </button>
                            
                            <a href="{{ route('contact.index') }}" class="block w-full text-center border border-green-600 text-green-600 hover:bg-green-50 font-bold py-3 px-4 rounded-md transition duration-300">
                                Demander plus d'informations
                            </a>
                        </form>
                        
                        <div class="mt-6 text-center text-sm text-gray-600">
                            <p>Paiement sécurisé</p>
                            <div class="flex justify-center mt-2 space-x-2">
                                <i class="fab fa-cc-visa text-2xl"></i>
                                <i class="fab fa-cc-mastercard text-2xl"></i>
                                <i class="fab fa-cc-paypal text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Need Help -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4">Besoin d'aide ?</h3>
                        <p class="text-gray-600 mb-4">Notre équipe est disponible pour répondre à toutes vos questions sur ce circuit.</p>
                        <div class="flex items-center mb-4">
                            <div class="bg-green-600 text-white p-2 rounded-full mr-3">
                                <i class="fas fa-phone"></i>
                            </div>
                            <span>+228 12 34 56 78</span>
                        </div>
                        <div class="flex items-center">
                            <div class="bg-green-600 text-white p-2 rounded-full mr-3">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <span>info@theelemtours.com</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Related Circuits -->
    <section class="py-12 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold mb-8">Circuits similaires</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Related Circuit 1 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition duration-300">
                    <div class="relative">
                        <img src="{{ asset('assets/images/related-1.jpg') }}" alt="Aventure nature au Togo et Bénin" class="w-full h-48 object-cover">
                        <div class="absolute top-4 right-4 bg-green-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                            10 jours
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-2">Aventure nature au Togo et Bénin</h3>
                        <div class="flex items-center mb-4">
                            <div class="text-yellow-500 mr-1">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="text-gray-600 text-sm">(18 avis)</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">1250€ / personne</span>
                            <a href="#" class="text-green-600 hover:text-green-800 font-medium">Détails</a>
                        </div>
                    </div>
                </div>
                
                <!-- Related Circuit 2 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition duration-300">
                    <div class="relative">
                        <img src="{{ asset('assets/images/related-2.jpg') }}" alt="Immersion villageoise au Togo" class="w-full h-48 object-cover">
                        <div class="absolute top-4 right-4 bg-green-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                            3 jours
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-2">Immersion villageoise au Togo</h3>
                        <div class="flex items-center mb-4">
                            <div class="text-yellow-500 mr-1">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="text-gray-600 text-sm">(9 avis)</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">350€ / personne</span>
                            <a href="#" class="text-green-600 hover:text-green-800 font-medium">Détails</a>
                        </div>
                    </div>
                </div>
                
                <!-- Related Circuit 3 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition duration-300">
                    <div class="relative">
                        <img src="{{ asset('assets/images/related-3.jpg') }}" alt="Route des esclaves au Bénin" class="w-full h-48 object-cover">
                        <div class="absolute top-4 right-4 bg-green-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                            4 jours
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-2">Route des esclaves au Bénin</h3>
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
                        <div class="flex justify-between items-center">
                            <span class="text-green-600 font-bold">550€ / personne</span>
                            <a href="#" class="text-green-600 hover:text-green-800 font-medium">Détails</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection