@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="relative">
        <div class="hero-image h-64 md:h-96 bg-cover bg-center bg-[#16a34a]" 
        {{-- style="background-image: url('{{ asset('assets/images/gallery-hero.jpg') }}')" --}}
        >
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="container mx-auto px-4 h-full flex items-center justify-center relative z-10">
                <div class="text-center text-white">
                    <h1 class="text-3xl md:text-5xl font-bold mb-2">Notre Galerie</h1>
                    <p class="text-lg md:text-xl">Découvrez la beauté du Togo à travers nos images</p>
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
                <span class="text-gray-800">Galerie</span>
            </div>
        </div>
    </div>

    <!-- Gallery Filter -->
    <section class="py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap justify-center mb-8">
                <button class="filter-btn active px-4 py-2 mx-2 mb-2 rounded-full bg-green-600 text-white hover:bg-green-700 transition duration-300" data-filter="all">Tous</button>
                <button class="filter-btn px-4 py-2 mx-2 mb-2 rounded-full bg-gray-200 text-gray-800 hover:bg-green-600 hover:text-white transition duration-300" data-filter="nature">Nature</button>
                <button class="filter-btn px-4 py-2 mx-2 mb-2 rounded-full bg-gray-200 text-gray-800 hover:bg-green-600 hover:text-white transition duration-300" data-filter="culture">Culture</button>
                <button class="filter-btn px-4 py-2 mx-2 mb-2 rounded-full bg-gray-200 text-gray-800 hover:bg-green-600 hover:text-white transition duration-300" data-filter="people">Personnes</button>
                <button class="filter-btn px-4 py-2 mx-2 mb-2 rounded-full bg-gray-200 text-gray-800 hover:bg-green-600 hover:text-white transition duration-300" data-filter="wildlife">Faune</button>
                <button class="filter-btn px-4 py-2 mx-2 mb-2 rounded-full bg-gray-200 text-gray-800 hover:bg-green-600 hover:text-white transition duration-300" data-filter="adventure">Aventure</button>
            </div>
        </div>
    </section>

    <!-- Gallery Grid -->
    <section class="pb-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <!-- Image 1 -->
                <div class="gallery-item nature" data-category="nature">
                    <div class="relative overflow-hidden rounded-lg group">
                        <img src="{{ asset('assets/images/gallery-1.jpg') }}" alt="Cascade de Kpimé" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <div class="text-center text-white p-4">
                                <h3 class="text-lg font-semibold mb-1">Cascade de Kpimé</h3>
                                <p class="text-sm">Région des Plateaux</p>
                                <a href="{{ asset('assets/images/gallery-1.jpg') }}" class="lightbox-trigger mt-3 inline-block bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full w-10 h-10 flex items-center justify-center">
                                    <i class="fas fa-search-plus text-white"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image 2 -->
                <div class="gallery-item culture" data-category="culture">
                    <div class="relative overflow-hidden rounded-lg group">
                        <img src="{{ asset('assets/images/gallery-2.jpg') }}" alt="Danse traditionnelle" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <div class="text-center text-white p-4">
                                <h3 class="text-lg font-semibold mb-1">Danse traditionnelle</h3>
                                <p class="text-sm">Festival Evala, Kara</p>
                                <a href="{{ asset('assets/images/gallery-2.jpg') }}" class="lightbox-trigger mt-3 inline-block bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full w-10 h-10 flex items-center justify-center">
                                    <i class="fas fa-search-plus text-white"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image 3 -->
                <div class="gallery-item people" data-category="people">
                    <div class="relative overflow-hidden rounded-lg group">
                        <img src="{{ asset('assets/images/gallery-3.jpg') }}" alt="Enfants togolais" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <div class="text-center text-white p-4">
                                <h3 class="text-lg font-semibold mb-1">Enfants togolais</h3>
                                <p class="text-sm">Village de Kpalimé</p>
                                <a href="{{ asset('assets/images/gallery-3.jpg') }}" class="lightbox-trigger mt-3 inline-block bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full w-10 h-10 flex items-center justify-center">
                                    <i class="fas fa-search-plus text-white"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image 4 -->
                <div class="gallery-item wildlife" data-category="wildlife">
                    <div class="relative overflow-hidden rounded-lg group">
                        <img src="{{ asset('assets/images/gallery-4.jpg') }}" alt="Éléphants dans la réserve de Fazao" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <div class="text-center text-white p-4">
                                <h3 class="text-lg font-semibold mb-1">Éléphants</h3>
                                <p class="text-sm">Réserve de Fazao-Malfakassa</p>
                                <a href="{{ asset('assets/images/gallery-4.jpg') }}" class="lightbox-trigger mt-3 inline-block bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full w-10 h-10 flex items-center justify-center">
                                    <i class="fas fa-search-plus text-white"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image 5 -->
                <div class="gallery-item adventure" data-category="adventure">
                    <div class="relative overflow-hidden rounded-lg group">
                        <img src="{{ asset('assets/images/gallery-5.jpg') }}" alt="Randonnée au Mont Agou" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <div class="text-center text-white p-4">
                                <h3 class="text-lg font-semibold mb-1">Randonnée</h3>
                                <p class="text-sm">Mont Agou</p>
                                <a href="{{ asset('assets/images/gallery-5.jpg') }}" class="lightbox-trigger mt-3 inline-block bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full w-10 h-10 flex items-center justify-center">
                                    <i class="fas fa-search-plus text-white"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image 6 -->
                <div class="gallery-item nature" data-category="nature">
                    <div class="relative overflow-hidden rounded-lg group">
                        <img src="{{ asset('assets/images/gallery-6.jpg') }}" alt="Plage de Lomé" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <div class="text-center text-white p-4">
                                <h3 class="text-lg font-semibold mb-1">Plage de Lomé</h3>
                                <p class="text-sm">Côte atlantique</p>
                                <a href="{{ asset('assets/images/gallery-6.jpg') }}" class="lightbox-trigger mt-3 inline-block bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full w-10 h-10 flex items-center justify-center">
                                    <i class="fas fa-search-plus text-white"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image 7 -->
                <div class="gallery-item culture" data-category="culture">
                    <div class="relative overflow-hidden rounded-lg group">
                        <img src="{{ asset('assets/images/gallery-7.jpg') }}" alt="Marché traditionnel" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <div class="text-center text-white p-4">
                                <h3 class="text-lg font-semibold mb-1">Marché traditionnel</h3>
                                <p class="text-sm">Lomé</p>
                                <a href="{{ asset('assets/images/gallery-7.jpg') }}" class="lightbox-trigger mt-3 inline-block bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full w-10 h-10 flex items-center justify-center">
                                    <i class="fas fa-search-plus text-white"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image 8 -->
                <div class="gallery-item people" data-category="people">
                    <div class="relative overflow-hidden rounded-lg group">
                        <img src="{{ asset('assets/images/gallery-8.jpg') }}" alt="Artisan togolais" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <div class="text-center text-white p-4">
                                <h3 class="text-lg font-semibold mb-1">Artisan togolais</h3>
                                <p class="text-sm">Village artisanal de Lomé</p>
                                <a href="{{ asset('assets/images/gallery-8.jpg') }}" class="lightbox-trigger mt-3 inline-block bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full w-10 h-10 flex items-center justify-center">
                                    <i class="fas fa-search-plus text-white"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image 9 -->
                <div class="gallery-item wildlife" data-category="wildlife">
                    <div class="relative overflow-hidden rounded-lg group">
                        <img src="{{ asset('assets/images/gallery-9.jpg') }}" alt="Oiseaux du Parc National de Fazao" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <div class="text-center text-white p-4">
                                <h3 class="text-lg font-semibold mb-1">Oiseaux tropicaux</h3>
                                <p class="text-sm">Parc National de Fazao</p>
                                <a href="{{ asset('assets/images/gallery-9.jpg') }}" class="lightbox-trigger mt-3 inline-block bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full w-10 h-10 flex items-center justify-center">
                                    <i class="fas fa-search-plus text-white"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image 10 -->
                <div class="gallery-item adventure" data-category="adventure">
                    <div class="relative overflow-hidden rounded-lg group">
                        <img src="{{ asset('assets/images/gallery-10.jpg') }}" alt="Kayak sur le lac Togo" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <div class="text-center text-white p-4">
                                <h3 class="text-lg font-semibold mb-1">Kayak</h3>
                                <p class="text-sm">Lac Togo</p>
                                <a href="{{ asset('assets/images/gallery-10.jpg') }}" class="lightbox-trigger mt-3 inline-block bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full w-10 h-10 flex items-center justify-center">
                                    <i class="fas fa-search-plus text-white"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image 11 -->
                <div class="gallery-item nature" data-category="nature">
                    <div class="relative overflow-hidden rounded-lg group">
                        <img src="{{ asset('assets/images/gallery-11.jpg') }}" alt="Forêt tropicale de Missahoé" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <div class="text-center text-white p-4">
                                <h3 class="text-lg font-semibold mb-1">Forêt tropicale</h3>
                                <p class="text-sm">Missahoé</p>
                                <a href="{{ asset('assets/images/gallery-11.jpg') }}" class="lightbox-trigger mt-3 inline-block bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full w-10 h-10 flex items-center justify-center">
                                    <i class="fas fa-search-plus text-white"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image 12 -->
                <div class="gallery-item culture" data-category="culture">
                    <div class="relative overflow-hidden rounded-lg group">
                        <img src="{{ asset('assets/images/gallery-12.jpg') }}" alt="Cérémonie vaudou" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <div class="text-center text-white p-4">
                                <h3 class="text-lg font-semibold mb-1">Cérémonie vaudou</h3>
                                <p class="text-sm">Togoville</p>
                                <a href="{{ asset('assets/images/gallery-12.jpg') }}" class="lightbox-trigger mt-3 inline-block bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full w-10 h-10 flex items-center justify-center">
                                    <i class="fas fa-search-plus text-white"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Load More Button -->
            <div class="text-center mt-10">
                <button id="load-more" class="bg-green-600 text-white px-6 py-3 rounded-md hover:bg-green-700 transition duration-300">
                    Charger plus d'images
                </button>
            </div>
        </div>
    </section>

    <!-- Lightbox Modal -->
    <div id="lightbox" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black bg-opacity-90 flex items-center justify-center p-4">
            <button id="lightbox-close" class="absolute top-6 right-6 text-white text-2xl hover:text-gray-300">
                <i class="fas fa-times"></i>
            </button>
            <button id="lightbox-prev" class="absolute left-6 top-1/2 transform -translate-y-1/2 text-white text-3xl hover:text-gray-300">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button id="lightbox-next" class="absolute right-6 top-1/2 transform -translate-y-1/2 text-white text-3xl hover:text-gray-300">
                <i class="fas fa-chevron-right"></i>
            </button>
            <div class="max-w-4xl max-h-full">
                <img id="lightbox-image" src="" alt="Lightbox image" class="max-w-full max-h-[80vh] mx-auto">
                <div class="text-white text-center mt-4">
                    <h3 id="lightbox-title" class="text-xl font-semibold"></h3>
                    <p id="lightbox-caption" class="text-gray-300"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Filter functionality
            const filterButtons = document.querySelectorAll('.filter-btn');
            const galleryItems = document.querySelectorAll('.gallery-item');
            
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const filterValue = this.getAttribute('data-filter');
                    
                    // Update active button
                    filterButtons.forEach(btn => {
                        btn.classList.remove('active', 'bg-green-600', 'text-white');
                        btn.classList.add('bg-gray-200', 'text-gray-800');
                    });
                    this.classList.add('active', 'bg-green-600', 'text-white');
                    this.classList.remove('bg-gray-200', 'text-gray-800');
                    
                    // Filter items
                    galleryItems.forEach(item => {
                        if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
            
            // Lightbox functionality
            const lightbox = document.getElementById('lightbox');
            const lightboxImage = document.getElementById('lightbox-image');
            const lightboxTitle = document.getElementById('lightbox-title');
            const lightboxCaption = document.getElementById('lightbox-caption');
            const lightboxClose = document.getElementById('lightbox-close');
            const lightboxPrev = document.getElementById('lightbox-prev');
            const lightboxNext = document.getElementById('lightbox-next');
            const lightboxTriggers = document.querySelectorAll('.lightbox-trigger');
            
            let currentImageIndex = 0;
            const galleryImages = [];
            
            // Collect all gallery images data
            lightboxTriggers.forEach((trigger, index) => {
                const imageUrl = trigger.getAttribute('href');
                const imageItem = trigger.closest('.gallery-item');
                const title = imageItem.querySelector('h3').textContent;
                const caption = imageItem.querySelector('p').textContent;
                
                galleryImages.push({
                    url: imageUrl,
                    title: title,
                    caption: caption
                });
                
                trigger.addEventListener('click', function(e) {
                    e.preventDefault();
                    openLightbox(index);
                });
            });
            
            function openLightbox(index) {
                currentImageIndex = index;
                updateLightboxContent();
                lightbox.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
            
            function updateLightboxContent() {
                const image = galleryImages[currentImageIndex];
                lightboxImage.src = image.url;
                lightboxTitle.textContent = image.title;
                lightboxCaption.textContent = image.caption;
            }
            
            function closeLightbox() {
                lightbox.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
            
            function nextImage() {
                currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
                updateLightboxContent();
            }
            
            function prevImage() {
                currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
                updateLightboxContent();
            }
            
            lightboxClose.addEventListener('click', closeLightbox);
            lightboxNext.addEventListener('click', nextImage);
            lightboxPrev.addEventListener('click', prevImage);
            
            // Close lightbox with escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeLightbox();
                } else if (e.key === 'ArrowRight') {
                    nextImage();
                } else if (e.key === 'ArrowLeft') {
                    prevImage();
                }
            });
            
            // Close lightbox when clicking outside the image
            lightbox.addEventListener('click', function(e) {
                if (e.target === lightbox) {
                    closeLightbox();
                }
            });
            
            // Load More functionality (simulation)
            const loadMoreBtn = document.getElementById('load-more');
            let clickCount = 0;
            
            loadMoreBtn.addEventListener('click', function() {
                clickCount++;
                if (clickCount >= 2) {
                    this.textContent = 'Toutes les images sont chargées';
                    this.disabled = true;
                    this.classList.add('bg-gray-400');
                    this.classList.remove('bg-green-600', 'hover:bg-green-700');
                } else {
                    this.textContent = 'Chargement...';
                    setTimeout(() => {
                        this.textContent = 'Charger plus d'images';
                        // Here you would normally append new images
                        // For this demo, we'll just show a message
                        alert('Dans une application réelle, de nouvelles images seraient chargées ici.');
                    }, 1500);
                }
            });
        });
    </script>
@endsection