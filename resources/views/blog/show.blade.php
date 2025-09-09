@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="relative">
        <div class="hero-image h-64 md:h-96 bg-cover bg-center bg-[#16a34a] mt-20" 
        @if($post->image)
        style="background-image: url('{{ $post->image->getFileUrl() }}')" 
        @endif
        >
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="container mx-auto px-4 h-full flex items-center justify-center relative z-10">
                <div class="text-center text-white">
                    <h1 class="text-3xl md:text-5xl font-bold mb-2">{{ $post->title }}</h1>
                    <div class="flex items-center justify-center text-sm mt-4">
                        <span class="mr-4">
                            <i class="far fa-calendar-alt mr-1"></i>
                            {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}
                        </span>
                        <!-- <span>
                            <i class="far fa-user mr-1"></i>
                            Par {{ $post->user ? $post->user->name : 'Admin' }}
                        </span> -->
                    </div>
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
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-gray-800">{{ $post->title }}</span>
            </div>
        </div>
    </div>
    
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 container mx-auto mt-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Fermer</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
        </span>
    </div>
    @endif

    <!-- Blog Content -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <!-- Article Content -->
                        <div class="prose max-w-none">
                            {!! $post->content !!}
                        </div>
                        
                        <!-- Tags -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <div class="flex flex-wrap gap-2">
                                <span class="text-gray-700 font-medium">Tags:</span>
                                <a href="#" class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm hover:bg-green-100 hover:text-green-800">Togo</a>
                                <a href="#" class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm hover:bg-green-100 hover:text-green-800">Saisons</a>
                                <a href="#" class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm hover:bg-green-100 hover:text-green-800">Voyage</a>
                                <a href="#" class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm hover:bg-green-100 hover:text-green-800">Conseils</a>
                                <a href="#" class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm hover:bg-green-100 hover:text-green-800">Climat</a>
                            </div>
                        </div>
                        
                        <!-- Share -->
                        <div class="mt-6">
                            <div class="flex items-center">
                                <span class="text-gray-700 font-medium mr-4">Partager:</span>
                                <div class="flex space-x-2">
                                    <a href="#" class="bg-blue-600 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-blue-700">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="#" class="bg-blue-400 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-blue-500">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="#" class="bg-red-600 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-red-700">
                                        <i class="fab fa-pinterest"></i>
                                    </a>
                                    <a href="#" class="bg-green-600 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-green-700">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Author Bio -->
                        <!-- <div class="mt-8 pt-6 border-t border-gray-200">
                            <div class="flex items-center">
                                <img src="{{ asset('assets/images/author.jpg') }}" alt="Elom Koudjo" class="w-16 h-16 rounded-full mr-4">
                                <div>
                                    <h4 class="font-semibold text-lg">Elom Koudjo</h4>
                                    <p class="text-gray-600">Guide touristique et spécialiste du Togo avec plus de 15 ans d'expérience. Passionné par le partage de la culture et des traditions togolaises avec les voyageurs du monde entier.</p>
                                </div>
                            </div>
                        </div> -->
                        
                        <!-- Comments -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <h3 class="text-xl font-bold mb-6">Commentaires ({{ $post->approvedComments->count() }})</h3>
                            
                            <div class="space-y-6">
                                @forelse($post->approvedComments as $comment)
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex items-start">
                                    <div
                                            class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center mr-4">
                                            <i class="fas fa-user text-gray-600 text-xl"></i>
                                        </div>
                                        
                                        <div>
                                            <div class="flex items-center mb-1">
                                                <h4 class="font-semibold">{{ $comment->name }}</h4>
                                                <span class="text-gray-500 text-sm ml-2">• {{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-gray-700">{{ $comment->comment }}</p>
                                            <button type="button" class="reply-button text-green-600 text-sm font-medium mt-2 hover:text-green-800" data-comment-id="{{ $comment->id }}" data-comment-name="{{ $comment->name }}">Répondre</button>
                                        </div>
                                    </div>
                                    
                                    <!-- Replies -->
                                    @if($comment->replies && $comment->replies->count() > 0)
                                    @foreach($comment->replies as $reply)
                                    <div class="ml-16 mt-4">
                                        <div class="flex items-start">
                                            <img src="{{ asset('assets/images/user-avatar.jpg') }}" alt="Réponse" class="w-10 h-10 rounded-full mr-3">
                                            <div>
                                                <div class="flex items-center mb-1">
                                                    <h4 class="font-semibold">{{ $reply->name }}</h4>
                                                    <span class="text-gray-500 text-sm ml-2">• {{ $reply->created_at->diffForHumans() }}</span>
                                                </div>
                                                <p class="text-gray-700">{{ $reply->comment }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                                @empty
                                <div class="bg-gray-50 p-4 rounded-lg text-center">
                                    <p class="text-gray-700">Aucun commentaire pour le moment. Soyez le premier à commenter !</p>
                                </div>
                                @endforelse
                            </div>
                            
                            <!-- Comment Form -->
                            <div class="mt-8">
                                <h4 class="text-lg font-semibold mb-4">Laisser un commentaire</h4>
                                <form action="{{ route('blog.comment', $post->slug) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="parent_id" id="parent_id" value="">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label for="name" class="block text-gray-700 text-sm font-medium mb-2">Nom *</label>
                                            <input type="text" id="name" name="name" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('name') border-red-500 @enderror" value="{{ old('name') }}" required>
                                            @error('name')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email *</label>
                                            <input type="email" id="email" name="email" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('email') border-red-500 @enderror" value="{{ old('email') }}" required>
                                            @error('email')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="comment" class="block text-gray-700 text-sm font-medium mb-2">Commentaire *</label>
                                        <textarea id="comment" name="comment" rows="5" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('comment') border-red-500 @enderror" required>{{ old('comment') }}</textarea>
                                        @error('comment')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="flex items-center mb-4">
                                        <input type="checkbox" id="save-info" name="save-info" class="mr-2">
                                        <label for="save-info" class="text-gray-700 text-sm">Enregistrer mon nom et mon email pour mes prochains commentaires</label>
                                    </div>
                                    <button type="submit" class="bg-green-600 text-white font-medium py-2 px-6 rounded-md hover:bg-green-700 transition duration-300">
                                        Publier le commentaire
                                    </button>
                                </form>
                            </div>
                        </div>
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
                                <a href="{{ route('blog.category', $category->slug) }}" class="flex items-center justify-between text-gray-700 hover:text-green-600">
                                    <span>{{ $category->nom }}</span>
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
                                    <span class="text-sm text-gray-600">{{ $recentPost->published_at ? $recentPost->published_at->format('d M Y') : $recentPost->created_at->format('d M Y') }}</span>
                                </div>
                            </li>
                            @empty
                            <li>Aucun article récent disponible</li>
                            @endforelse
                        </ul>
                    </div>

                    <!-- Tags -->
                    <!-- <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                        <h3 class="text-lg font-semibold mb-4">Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @if($post->tags && count($post->tags) > 0)
                                @foreach($post->tags as $tag)
                                <a href="{{ route('blog.tag', $tag->slug) }}" class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm hover:bg-green-100 hover:text-green-800">{{ $tag->name }}</a>
                                @endforeach
                            @else
                                <span class="text-gray-500">Aucun tag associé à cet article</span>
                            @endif
                        </div>
                    </div> -->

                    <!-- Related Tours -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold mb-4">Circuits recommandés</h3>
                        <ul class="space-y-4">
                            @forelse($relatedTours as $tour)
                            <li class="{{ !$loop->last ? 'border-b border-gray-100 pb-4' : '' }}">
                                <a href="{{ route('circuits.show', $tour->slug) }}" class="flex items-start hover:opacity-90 transition duration-300">
                                    @if($tour->image)
                                        <img src="{{ $tour->image->getFileUrl() }}" alt="{{ $tour->titre }}" class="w-20 h-16 object-cover rounded mr-3">
                                    @else
                                        <div class="w-20 h-16 bg-gray-200 flex items-center justify-center rounded mr-3">
                                            <span class="text-gray-500 text-xs">Aucune image</span>
                                        </div>
                                    @endif
                                    <div>
                                        <h4 class="font-medium text-gray-800">{{ $tour->titre }}</h4>
                                        <div class="flex items-center mt-1">
                                            <div class="text-yellow-500 text-xs mr-1">
                                                @php
                                                    $rating = $tour->rating ?? 4;
                                                @endphp
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $rating)
                                                        <i class="fas fa-star"></i>
                                                    @elseif($i - 0.5 <= $rating)
                                                        <i class="fas fa-star-half-alt"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="text-sm text-gray-600">{{ $tour->duree ?? '3-5' }} jours</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            @empty
                            <li class="text-center text-gray-500">
                                Aucun circuit recommandé disponible
                            </li>
                            @endforelse
                        </ul>
                        <a href="{{ route('circuits.index') }}" class="block text-center mt-4 text-green-600 hover:text-green-800 font-medium">
                            Voir tous nos circuits
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sélectionner tous les boutons de réponse
            const replyButtons = document.querySelectorAll('.reply-button');
            const commentForm = document.querySelector('form[action*="comment"]');
            const parentIdInput = document.getElementById('parent_id');
            const formTitle = document.querySelector('form[action*="comment"] h4');
            const originalTitle = formTitle.textContent;
            const submitButton = commentForm.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.textContent.trim();
            
            // Ajouter un bouton pour annuler la réponse
            const cancelButton = document.createElement('button');
            cancelButton.type = 'button';
            cancelButton.className = 'bg-gray-500 text-white font-medium py-2 px-6 rounded-md hover:bg-gray-600 transition duration-300 ml-2';
            cancelButton.textContent = 'Annuler';
            cancelButton.style.display = 'none';
            submitButton.parentNode.insertBefore(cancelButton, submitButton.nextSibling);
            
            // Fonction pour réinitialiser le formulaire
            function resetForm() {
                parentIdInput.value = '';
                formTitle.textContent = originalTitle;
                submitButton.textContent = originalButtonText;
                cancelButton.style.display = 'none';
                // Faire défiler vers le formulaire
                commentForm.scrollIntoView({ behavior: 'smooth' });
            }
            
            // Ajouter un gestionnaire d'événements pour chaque bouton de réponse
            replyButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const commentId = this.getAttribute('data-comment-id');
                    const commentName = this.getAttribute('data-comment-name');
                    
                    // Mettre à jour le champ parent_id
                    parentIdInput.value = commentId;
                    
                    // Mettre à jour le titre du formulaire
                    formTitle.textContent = `Répondre à ${commentName}`;
                    
                    // Mettre à jour le texte du bouton
                    submitButton.textContent = 'Publier la réponse';
                    
                    // Afficher le bouton d'annulation
                    cancelButton.style.display = 'inline-block';
                    
                    // Faire défiler vers le formulaire
                    commentForm.scrollIntoView({ behavior: 'smooth' });
                });
            });
            
            // Ajouter un gestionnaire d'événements pour le bouton d'annulation
            cancelButton.addEventListener('click', resetForm);
            
            // Réinitialiser le formulaire lors de la soumission
            commentForm.addEventListener('submit', function() {
                // Le formulaire sera réinitialisé après le rechargement de la page
            });
        });
    </script>
    @endpush
@endsection