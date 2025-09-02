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
                    
                    <!-- Gallery -->
                   
                    
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

                <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
            <h2 class="text-2xl font-bold mb-6">Réserver ce circuit</h2>
            <form action="{{ route('reservations.store', $circuit->slug) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="date_debut" class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                    <input type="date" id="date_debut" name="date_debut" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                
                <div>
                    <label for="nombre_personnes" class="block text-sm font-medium text-gray-700 mb-1">Nombre de personnes</label>
                    <input type="number" id="nombre_personnes" name="nombre_personnes" min="1" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                    <input type="text" id="nom" name="nom" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                
                <div>
                    <label for="telephone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                    <input type="tel" id="telephone" name="telephone" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message (optionnel)</label>
                    <textarea id="message" name="message" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                </div>
                
                <div class="pt-4">
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-md transition duration-300">
                        Réserver maintenant
                    </button>
                </div>
            </form>
            
            <div class="mt-6 text-center text-sm text-gray-600">
                <p>Besoin d'aide pour réserver ?</p>
                <a href="{{ route('contact.index') }}" class="text-green-600 hover:text-green-800 font-medium">Contactez-nous</a>
            </div>
        </div>
    </div>
                
                <!-- Sidebar -->
               
            </div>
        </div>
    </section>
    
    <!-- Related Circuits -->
</div>