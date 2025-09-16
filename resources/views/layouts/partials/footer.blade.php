<footer class="bg-gray-800 text-white py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- About -->
            <div>
                <h3 class="text-xl font-semibold mb-4">The Elom Tours</h3>
                <p class="text-gray-300 mb-4">Spécialiste des voyages authentiques en Afrique de l'Ouest. Découvrez le Togo et ses pays voisins avec nos guides locaux expérimentés.</p>
                <div class="flex space-x-4">
                    <a href="https://www.facebook.com/TheElomTour?mibextid=ZbWKwL" class="text-gray-300 hover:text-white" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://x.com/TheElomTours" class="text-gray-300 hover:text-white" target="_blank"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.instagram.com/theelomtours/?next=%2F" class="text-gray-300 hover:text-white" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.linkedin.com/company/the-elom-tour/" class="text-gray-300 hover:text-white" target="_blank"><i class="fab fa-linkedin"></i></a>
                    <a href="https://www.tiktok.com/@the.elom.tours?_r=1&_d=el7838ea2647db&sec_uid=MS4wLjABAAAAUznXkTlzlOSWU2DD8aJynYIbgBTA3w6UuajFprZkL67rbtwoNdY7h1i8NX82QhKm&share_author_id=7253058242740536326&sharer_language=fr&source=h5_m&u_code=e8m6c2ad0khhdc&timestamp=1757928672&user_id=7253058242740536326&sec_user_id=MS4wLjABAAAAUznXkTlzlOSWU2DD8aJynYIbgBTA3w6UuajFprZkL67rbtwoNdY7h1i8NX82QhKm&item_author_type=1&utm_source=copy&utm_campaign=client_share&utm_medium=android&share_iid=7549234641825679110&share_link_id=d3c1e50b-890e-4135-a2bc-dceaa80785aa&share_app_id=1233&ugbiz_name=ACCOUNT&ug_btm=b8727%2Cb7360&social_share_type=5&enable_checksum=1" class="text-gray-300 hover:text-white" target="_blank"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h3 class="text-xl font-semibold mb-4">Liens rapides</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white">Accueil</a></li>
                    <li><a href="{{ route('destinations.index') }}" class="text-gray-300 hover:text-white">Destinations</a></li>
                    <li><a href="{{ route('circuits.index') }}" class="text-gray-300 hover:text-white">Circuits</a></li>
                    <li><a href="{{ route('about.index') }}" class="text-gray-300 hover:text-white">À propos</a></li>
                    <li><a href="{{ route('contact.index') }}" class="text-gray-300 hover:text-white">Contact</a></li>
                </ul>
            </div>
            
            <!-- Contact Info -->
            <div>
                <h3 class="text-xl font-semibold mb-4">Contact</h3>
                <ul class="space-y-2">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt mt-1 mr-2"></i>
                        <span>Nyékonakpoè, à 100m de la pharmacie Pour Tous </span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-phone-alt mt-1 mr-2"></i>
                        <span>(+228) 91 92 93 83 </span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-envelope mt-1 mr-2"></i>
                        <span>	theelomtours@gmail.com </span>
                    </li>
                </ul>
            </div>
            
            <!-- Newsletter -->
            <div>
                <h3 class="text-xl font-semibold mb-4">Newsletter</h3>
                <p class="text-gray-300 mb-4">Inscrivez-vous pour recevoir nos offres spéciales et actualités.</p>
                <form>
                    <div class="flex">
                        <input type="email" placeholder="Votre email" class="px-4 py-2 w-full focus:outline-none text-gray-900 rounded-l">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-r">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
       <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-300">
    <p>
        &copy; {{ date('Y') }} The Elom' Tours. Tous droits réservés. 
        Développé par 
        <a href="https://tpt-international.com/" target="_blank" class="text-green-500 hover:text-green-400 font-semibold">
            TPT INTERNATIONAL
        </a>
    </p>
</div>

    </div>
</footer>