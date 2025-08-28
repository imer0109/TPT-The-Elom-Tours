@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="relative">
        <div class="hero-image h-64 md:h-96 bg-cover bg-center bg-[#16a34a]" 
        {{-- style="background-image: url('{{ asset('assets/images/blog-featured.jpg') }}')" --}}
        >
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="container mx-auto px-4 h-full flex items-center justify-center relative z-10">
                <div class="text-center text-white">
                    <h1 class="text-3xl md:text-5xl font-bold mb-2">Les meilleures périodes pour visiter le Togo</h1>
                    <div class="flex items-center justify-center text-sm mt-4">
                        <span class="mr-4">
                            <i class="far fa-calendar-alt mr-1"></i>
                            15 juin 2023
                        </span>
                        <span>
                            <i class="far fa-user mr-1"></i>
                            Par Elom Koudjo
                        </span>
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
                <span class="text-gray-800">Les meilleures périodes pour visiter le Togo</span>
            </div>
        </div>
    </div>

    <!-- Blog Content -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <!-- Article Content -->
                        <div class="prose max-w-none">
                            <p class="lead text-lg mb-6">Le Togo, petit pays d'Afrique de l'Ouest, offre une diversité de paysages et d'expériences culturelles tout au long de l'année. Cependant, certaines périodes sont plus propices que d'autres pour profiter pleinement de votre séjour. Dans cet article, nous vous guidons à travers les saisons togolaises pour vous aider à planifier votre voyage au meilleur moment.</p>
                            
                            <h2 class="text-2xl font-bold mt-8 mb-4">Les saisons au Togo</h2>
                            
                            <p>Le climat du Togo est tropical, avec deux saisons principales :</p>
                            
                            <ul class="list-disc pl-6 mb-6">
                                <li class="mb-2"><strong>La saison sèche</strong> : de novembre à mars, caractérisée par des températures élevées et peu de précipitations.</li>
                                <li class="mb-2"><strong>La saison des pluies</strong> : d'avril à octobre, avec des précipitations plus abondantes, particulièrement en juin et septembre.</li>
                            </ul>
                            
                            <p>Il est important de noter que le climat varie selon les régions du pays. Le sud, notamment la région côtière autour de Lomé, est généralement plus humide que le nord.</p>
                            
                            <div class="my-8">
                                <img src="{{ asset('assets/images/togo-seasons.jpg') }}" alt="Paysage togolais pendant la saison sèche" class="rounded-lg w-full">
                                <p class="text-sm text-gray-600 mt-2 text-center">Paysage de savane dans le nord du Togo pendant la saison sèche</p>
                            </div>
                            
                            <h2 class="text-2xl font-bold mt-8 mb-4">La meilleure période : novembre à février</h2>
                            
                            <p>La période de novembre à février est généralement considérée comme la plus agréable pour visiter le Togo. Voici pourquoi :</p>
                            
                            <ul class="list-disc pl-6 mb-6">
                                <li class="mb-2"><strong>Climat optimal</strong> : Les températures sont chaudes mais supportables (25-32°C) et l'humidité est plus faible.</li>
                                <li class="mb-2"><strong>Peu de pluie</strong> : Les précipitations sont rares, ce qui facilite les déplacements et les activités en plein air.</li>
                                <li class="mb-2"><strong>Harmattan</strong> : De décembre à février, l'harmattan (vent sec venant du Sahara) peut apporter de la poussière et réduire la visibilité, mais rend les températures nocturnes plus fraîches et agréables.</li>
                                <li class="mb-2"><strong>Festivals</strong> : Plusieurs célébrations traditionnelles ont lieu pendant cette période, notamment les fêtes de fin d'année et certaines cérémonies traditionnelles.</li>
                            </ul>
                            
                            <div class="bg-green-50 p-4 rounded-lg my-6">
                                <h3 class="text-lg font-semibold text-green-800 mb-2">Conseil de voyage</h3>
                                <p class="text-green-800">Si vous visitez le Togo pendant l'harmattan (décembre-février), prévoyez un foulard ou un masque léger pour vous protéger de la poussière, particulièrement si vous souffrez de problèmes respiratoires.</p>
                            </div>
                            
                            <h2 class="text-2xl font-bold mt-8 mb-4">Mars à mai : transition et chaleur</h2>
                            
                            <p>Cette période marque la transition entre la saison sèche et la saison des pluies :</p>
                            
                            <ul class="list-disc pl-6 mb-6">
                                <li class="mb-2"><strong>Températures élevées</strong> : C'est la période la plus chaude de l'année, avec des températures pouvant dépasser 35°C, particulièrement dans le nord.</li>
                                <li class="mb-2"><strong>Début des pluies</strong> : Les premières pluies commencent à tomber, rafraîchissant l'atmosphère mais pouvant être imprévisibles.</li>
                                <li class="mb-2"><strong>Paysages verdoyants</strong> : La végétation commence à reverdir, offrant des paysages plus colorés.</li>
                                <li class="mb-2"><strong>Moins de touristes</strong> : C'est une période moins fréquentée, ce qui peut être un avantage pour ceux qui préfèrent éviter la foule.</li>
                            </ul>
                            
                            <div class="my-8">
                                <img src="{{ asset('assets/images/togo-rainy.jpg') }}" alt="Paysage togolais pendant la saison des pluies" class="rounded-lg w-full">
                                <p class="text-sm text-gray-600 mt-2 text-center">La végétation luxuriante du Togo pendant la saison des pluies</p>
                            </div>
                            
                            <h2 class="text-2xl font-bold mt-8 mb-4">Juin à septembre : pleine saison des pluies</h2>
                            
                            <p>Cette période est caractérisée par des précipitations plus abondantes :</p>
                            
                            <ul class="list-disc pl-6 mb-6">
                                <li class="mb-2"><strong>Fortes pluies</strong> : Les précipitations sont fréquentes et parfois intenses, particulièrement en juin et septembre.</li>
                                <li class="mb-2"><strong>Difficultés de déplacement</strong> : Certaines routes, notamment dans les zones rurales, peuvent devenir difficiles d'accès.</li>
                                <li class="mb-2"><strong>Nature luxuriante</strong> : C'est la période où la végétation est la plus dense et verdoyante.</li>
                                <li class="mb-2"><strong>Activités limitées</strong> : Certaines activités touristiques peuvent être restreintes en raison des conditions météorologiques.</li>
                            </ul>
                            
                            <div class="bg-yellow-50 p-4 rounded-lg my-6">
                                <h3 class="text-lg font-semibold text-yellow-800 mb-2">À noter</h3>
                                <p class="text-yellow-800">Malgré les inconvénients, la saison des pluies offre des opportunités uniques pour les photographes et les amateurs de nature, avec des paysages verdoyants et des cascades plus impressionnantes, notamment dans la région de Kpalimé.</p>
                            </div>
                            
                            <h2 class="text-2xl font-bold mt-8 mb-4">Octobre : transition vers la saison sèche</h2>
                            
                            <p>Le mois d'octobre marque la fin progressive de la saison des pluies :</p>
                            
                            <ul class="list-disc pl-6 mb-6">
                                <li class="mb-2"><strong>Diminution des pluies</strong> : Les précipitations deviennent moins fréquentes et moins intenses.</li>
                                <li class="mb-2"><strong>Températures agréables</strong> : Le climat est généralement doux et agréable.</li>
                                <li class="mb-2"><strong>Paysages encore verts</strong> : La végétation reste verdoyante suite à la saison des pluies.</li>
                                <li class="mb-2"><strong>Bonne période intermédiaire</strong> : C'est une période intéressante pour ceux qui souhaitent éviter à la fois les fortes pluies et la chaleur intense de la saison sèche.</li>
                            </ul>
                            
                            <h2 class="text-2xl font-bold mt-8 mb-4">Événements et festivals à ne pas manquer</h2>
                            
                            <p>Voici quelques événements culturels majeurs qui peuvent influencer le choix de votre période de voyage :</p>
                            
                            <ul class="list-disc pl-6 mb-6">
                                <li class="mb-2"><strong>Festival des Divinités Noires</strong> (août) : Une célébration des traditions vaudou à Lomé.</li>
                                <li class="mb-2"><strong>Fête traditionnelle Evala</strong> (juillet) : Cérémonies d'initiation et luttes traditionnelles dans la région de Kara.</li>
                                <li class="mb-2"><strong>Fête de l'indépendance</strong> (27 avril) : Célébrations dans tout le pays.</li>
                                <li class="mb-2"><strong>Fête des ignames</strong> (septembre) : Célébrée dans plusieurs régions pour marquer la récolte des ignames.</li>
                            </ul>
                            
                            <div class="my-8">
                                <img src="{{ asset('assets/images/togo-festival.jpg') }}" alt="Festival traditionnel au Togo" class="rounded-lg w-full">
                                <p class="text-sm text-gray-600 mt-2 text-center">Danseurs lors d'un festival traditionnel togolais</p>
                            </div>
                            
                            <h2 class="text-2xl font-bold mt-8 mb-4">Recommandations selon vos intérêts</h2>
                            
                            <div class="space-y-4">
                                <div class="border-l-4 border-green-600 pl-4 py-2">
                                    <h3 class="font-semibold">Pour la découverte culturelle</h3>
                                    <p>La saison sèche (novembre-mars) est idéale pour visiter les villages traditionnels et participer aux cérémonies locales.</p>
                                </div>
                                
                                <div class="border-l-4 border-green-600 pl-4 py-2">
                                    <h3 class="font-semibold">Pour la randonnée et les activités nature</h3>
                                    <p>Début de la saison sèche (novembre-décembre) ou fin de la saison des pluies (octobre) pour profiter de paysages verdoyants avec un risque limité de précipitations.</p>
                                </div>
                                
                                <div class="border-l-4 border-green-600 pl-4 py-2">
                                    <h3 class="font-semibold">Pour les plages</h3>
                                    <p>La saison sèche (novembre-mars) offre les meilleures conditions pour profiter des plages de la côte togolaise.</p>
                                </div>
                                
                                <div class="border-l-4 border-green-600 pl-4 py-2">
                                    <h3 class="font-semibold">Pour la photographie</h3>
                                    <p>La fin de la saison des pluies (septembre-octobre) pour capturer des paysages luxuriants et des ciels dramatiques.</p>
                                </div>
                            </div>
                            
                            <h2 class="text-2xl font-bold mt-8 mb-4">Conclusion</h2>
                            
                            <p>Le Togo peut être visité tout au long de l'année, mais la période de novembre à février offre généralement les conditions les plus favorables pour la plupart des voyageurs. Cependant, le choix de la meilleure période dépend de vos intérêts spécifiques et des activités que vous souhaitez réaliser.</p>
                            
                            <p>Quelle que soit la saison choisie, le Togo vous accueillera avec la chaleur et l'hospitalité qui caractérisent ce pays d'Afrique de l'Ouest, riche en traditions et en découvertes culturelles.</p>
                            
                            <div class="bg-blue-50 p-4 rounded-lg my-6">
                                <h3 class="text-lg font-semibold text-blue-800 mb-2">Planifiez votre voyage</h3>
                                <p class="text-blue-800">Chez The Elom Tours, nous proposons des circuits adaptés à chaque saison. N'hésitez pas à nous contacter pour organiser votre séjour au Togo au moment qui vous convient le mieux.</p>
                            </div>
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
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <div class="flex items-center">
                                <img src="{{ asset('assets/images/author.jpg') }}" alt="Elom Koudjo" class="w-16 h-16 rounded-full mr-4">
                                <div>
                                    <h4 class="font-semibold text-lg">Elom Koudjo</h4>
                                    <p class="text-gray-600">Guide touristique et spécialiste du Togo avec plus de 15 ans d'expérience. Passionné par le partage de la culture et des traditions togolaises avec les voyageurs du monde entier.</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Comments -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <h3 class="text-xl font-bold mb-6">Commentaires (3)</h3>
                            
                            <div class="space-y-6">
                                <!-- Comment 1 -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex items-start">
                                        <img src="{{ asset('assets/images/comment-1.jpg') }}" alt="Commentaire" class="w-12 h-12 rounded-full mr-4">
                                        <div>
                                            <div class="flex items-center mb-1">
                                                <h4 class="font-semibold">Marie Dupont</h4>
                                                <span class="text-gray-500 text-sm ml-2">• il y a 2 jours</span>
                                            </div>
                                            <p class="text-gray-700">Merci pour cet article très complet ! Je prévois un voyage au Togo en janvier et ces informations me seront très utiles pour préparer mon séjour.</p>
                                            <button class="text-green-600 text-sm font-medium mt-2 hover:text-green-800">Répondre</button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Comment 2 -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex items-start">
                                        <img src="{{ asset('assets/images/comment-2.jpg') }}" alt="Commentaire" class="w-12 h-12 rounded-full mr-4">
                                        <div>
                                            <div class="flex items-center mb-1">
                                                <h4 class="font-semibold">Thomas Martin</h4>
                                                <span class="text-gray-500 text-sm ml-2">• il y a 5 jours</span>
                                            </div>
                                            <p class="text-gray-700">J'ai visité le Togo en octobre dernier et je confirme que c'est une excellente période ! La végétation était magnifique et nous avons eu très peu de pluie. Je recommande particulièrement la région de Kpalimé à cette période.</p>
                                            <button class="text-green-600 text-sm font-medium mt-2 hover:text-green-800">Répondre</button>
                                        </div>
                                    </div>
                                    
                                    <!-- Reply -->
                                    <div class="ml-16 mt-4">
                                        <div class="flex items-start">
                                            <img src="{{ asset('assets/images/author.jpg') }}" alt="Réponse" class="w-10 h-10 rounded-full mr-3">
                                            <div>
                                                <div class="flex items-center mb-1">
                                                    <h4 class="font-semibold">Elom Koudjo</h4>
                                                    <span class="text-gray-500 text-sm ml-2">• il y a 4 jours</span>
                                                </div>
                                                <p class="text-gray-700">Merci pour votre témoignage, Thomas ! La région de Kpalimé est effectivement splendide en octobre avec ses cascades et sa forêt luxuriante.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Comment 3 -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex items-start">
                                        <img src="{{ asset('assets/images/comment-3.jpg') }}" alt="Commentaire" class="w-12 h-12 rounded-full mr-4">
                                        <div>
                                            <div class="flex items-center mb-1">
                                                <h4 class="font-semibold">Sophie Leclerc</h4>
                                                <span class="text-gray-500 text-sm ml-2">• il y a 1 semaine</span>
                                            </div>
                                            <p class="text-gray-700">Est-ce que vous pourriez préciser quelles sont les températures moyennes en février ? J'hésite entre février et novembre pour mon voyage. Merci d'avance !</p>
                                            <button class="text-green-600 text-sm font-medium mt-2 hover:text-green-800">Répondre</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Comment Form -->
                            <div class="mt-8">
                                <h4 class="text-lg font-semibold mb-4">Laisser un commentaire</h4>
                                <form>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label for="name" class="block text-gray-700 text-sm font-medium mb-2">Nom *</label>
                                            <input type="text" id="name" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                                        </div>
                                        <div>
                                            <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email *</label>
                                            <input type="email" id="email" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="comment" class="block text-gray-700 text-sm font-medium mb-2">Commentaire *</label>
                                        <textarea id="comment" rows="5" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                                    </div>
                                    <div class="flex items-center mb-4">
                                        <input type="checkbox" id="save-info" class="mr-2">
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

                    <!-- Related Tours -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold mb-4">Circuits recommandés</h3>
                        <ul class="space-y-4">
                            <li class="border-b border-gray-100 pb-4">
                                <a href="{{ route('circuits.show', 1) }}" class="flex items-start hover:opacity-90 transition duration-300">
                                    <img src="{{ asset('assets/images/tour-1.jpg') }}" alt="Circuit recommandé" class="w-20 h-16 object-cover rounded mr-3">
                                    <div>
                                        <h4 class="font-medium text-gray-800">Circuit culturel au Togo</h4>
                                        <div class="flex items-center mt-1">
                                            <div class="text-yellow-500 text-xs mr-1">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                            </div>
                                            <span class="text-sm text-gray-600">7 jours</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="border-b border-gray-100 pb-4">
                                <a href="{{ route('circuits.show', 2) }}" class="flex items-start hover:opacity-90 transition duration-300">
                                    <img src="{{ asset('assets/images/tour-2.jpg') }}" alt="Circuit recommandé" class="w-20 h-16 object-cover rounded mr-3">
                                    <div>
                                        <h4 class="font-medium text-gray-800">Aventure nature au Togo</h4>
                                        <div class="flex items-center mt-1">
                                            <div class="text-yellow-500 text-xs mr-1">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <span class="text-sm text-gray-600">10 jours</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('circuits.show', 3) }}" class="flex items-start hover:opacity-90 transition duration-300">
                                    <img src="{{ asset('assets/images/tour-3.jpg') }}" alt="Circuit recommandé" class="w-20 h-16 object-cover rounded mr-3">
                                    <div>
                                        <h4 class="font-medium text-gray-800">Immersion villageoise au Togo</h4>
                                        <div class="flex items-center mt-1">
                                            <div class="text-yellow-500 text-xs mr-1">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            <span class="text-sm text-gray-600">3 jours</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <a href="{{ route('circuits.index') }}" class="block text-center mt-4 text-green-600 hover:text-green-800 font-medium">
                            Voir tous nos circuits
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection