@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="relative">
        <div class="hero-image h-64 md:h-96 bg-cover bg-center bg-[#16a34a]"
         {{-- style="background-image: url('{{ asset('assets/images/blog-hero.jpg') }}')" --}}
         >
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="container mx-auto px-4 h-full flex items-center justify-center relative z-10 mt-20">
                <div class="text-center text-white">
                    <h1 class="text-3xl md:text-5xl font-bold mb-2">{{ $title ?? 'Notre Blog' }}</h1>
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
                <a href="{{ route('blog.index') }}" class="text-gray-600 hover:text-green-600">Blog</a>
                @if(isset($currentCategory))
                    <span class="mx-2 text-gray-400">/</span>
                    <span class="text-gray-800">{{ $currentCategory->name }}</span>
                @elseif(isset($currentTag))
                    <span class="mx-2 text-gray-400">/</span>
                    <span class="text-gray-800">{{ $currentTag->name }}</span>
                @endif
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
                    @if($featuredPosts->isNotEmpty())
                    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                        @if($featuredPosts[0]->image)
                            <img src="{{ $featuredPosts[0]->image->getFileUrl() }}" alt="{{ $featuredPosts[0]->title }}" class="w-full h-80 object-cover">
                        @else
                            <div class="w-full h-80 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500">Aucune image disponible</span>
                            </div>
                        @endif
                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-600 mb-3">
                                <span class="mr-4">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    {{ $featuredPosts[0]->published_at->format('d M Y') }}
                                </span>
                                <span>
                                    <i class="far fa-user mr-1"></i>
                                    Par {{ $featuredPosts[0]->user->name ?? 'Admin' }}
                                </span>
                            </div>
                            <h2 class="text-2xl font-bold mb-3">
                                <a href="{{ route('blog.show', $featuredPosts[0]->slug) }}" class="text-gray-800 hover:text-green-600">{{ $featuredPosts[0]->title }}</a>
                            </h2>
                            <p class="text-gray-700 mb-4">{{ $featuredPosts[0]->excerpt }}</p>
                            <a href="{{ route('blog.show', $featuredPosts[0]->slug) }}" class="inline-block text-green-600 font-semibold hover:text-green-800">
                                Lire la suite
                                <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- Blog Posts Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @forelse($posts as $post)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            @if($post->image)
                                <img src="{{ $post->image->getFileUrl() }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500">Aucune image disponible</span>
                                </div>
                            @endif
                            <div class="p-6">
                                <div class="flex items-center text-sm text-gray-600 mb-3">
                                    <span class="mr-4">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        {{ $post->published_at->format('d M Y') }}
                                    </span>
                                    <span>
                                        <i class="far fa-user mr-1"></i>
                                        Par {{ $post->user->name ?? 'Admin' }}
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold mb-3">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="text-gray-800 hover:text-green-600">{{ $post->title }}</a>
                                </h3>
                                <p class="text-gray-700 mb-4">{{ $post->excerpt }}</p>
                                <a href="{{ route('blog.show', $post->slug) }}" class="inline-block text-green-600 font-semibold hover:text-green-800">
                                    Lire la suite
                                    <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-2 text-center py-8">
                            <p class="text-gray-600">Aucun article de blog disponible pour le moment.</p>
                        </div>
                        @endforelse
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $posts->links() }}
                    </div>
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
                            @forelse($categories as $category)
                            <li>
                                <a href="{{ route('blog.category', $category->slug) }}" class="flex items-center justify-between text-gray-700 hover:text-green-600 {{ isset($currentCategory) && $currentCategory->id === $category->id ? 'text-green-600 font-semibold' : '' }}">
                                    <span>{{ $category->name }}</span>
                                    <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs">{{ $category->blog_posts_count }}</span>
                                </a>
                            </li>
                            @empty
                            <li class="text-gray-500">Aucune catégorie disponible</li>
                            @endforelse
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