@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="relative">
        <div class="hero-image h-64 md:h-96 bg-cover bg-center bg-[#16a34a]">
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
                        </ul>
                    </div>

                    <!-- Recent Posts -->
                    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                        <h3 class="text-lg font-semibold mb-4">Articles récents</h3>
                        <ul class="space-y-4">
                            @php
                                $recentPosts = \App\Models\BlogPost::published()
                                    ->orderBy('published_at', 'desc')
                                    ->take(4)
                                    ->get();
                            @endphp
                            @forelse($recentPosts as $recentPost)
                                <li class="flex items-start">
                                    @if($recentPost->image)
                                        <img src="{{ $recentPost->image->getFileUrl() }}" alt="{{ $recentPost->title }}" class="w-16 h-16 object-cover rounded mr-3">
                                    @else
                                        <div class="w-16 h-16 bg-gray-200 flex items-center justify-center rounded mr-3">
                                            <span class="text-gray-500 text-xs">Aucune image</span>
                                        </div>
                                    @endif
                                    <div>
                                        <h4 class="font-medium">
                                            <a href="{{ route('blog.show', $recentPost->slug) }}" class="text-gray-800 hover:text-green-600">{{ $recentPost->title }}</a>
                                        </h4>
                                        <span class="text-sm text-gray-600">{{ $recentPost->published_at->format('d M Y') }}</span>
                                    </div>
                                </li>
                            @empty
                                <li class="text-gray-500 text-center">
                                    Aucun article récent disponible
                                </li>
                            @endforelse
                        </ul>
                    </div>

                    <!-- Tags -->
                    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                        <h3 class="text-lg font-semibold mb-4">Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @php
                                $tags = \App\Models\Tag::withCount('blogPosts')
                                    ->orderBy('blog_posts_count', 'desc')
                                    ->take(10)
                                    ->get();
                            @endphp
                            @forelse($tags as $tag)
                                <a href="{{ route('blog.tag', $tag->slug) }}" 
                                   class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm hover:bg-green-100 hover:text-green-800
                                   {{ request()->is('blog/tag/'.$tag->slug) ? 'bg-green-100 text-green-800' : '' }}">
                                    {{ $tag->name }}
                                </a>
                            @empty
                                <span class="text-gray-500">Aucun tag disponible</span>
                            @endforelse
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
