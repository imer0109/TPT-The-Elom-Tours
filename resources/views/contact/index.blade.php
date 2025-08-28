@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="relative">
        <div class="hero-image h-64 md:h-96 bg-cover bg-[#16a34a] bg-center" 
        {{-- style="background-image: url('{{ asset('assets/images/contact-hero.jpg') }}')" --}}
        >
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="container mx-auto px-4 h-full flex items-center justify-center relative z-10">
                <div class="text-center text-white">
                    <h1 class="text-3xl md:text-5xl font-bold mb-2">Contactez-nous</h1>
                    <p class="text-lg md:text-xl">Nous sommes à votre écoute pour organiser votre voyage au Togo</p>
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
                <span class="text-gray-800">Contact</span>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Contact Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md p-6 md:p-8">
                        <h2 class="text-2xl font-bold mb-6">Envoyez-nous un message</h2>
                        
                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                                <strong class="font-bold">Succès!</strong>
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="name" class="block text-gray-700 text-sm font-medium mb-2">Nom complet *</label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full border @error('name') border-red-500 @else border-gray-300 @enderror rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email *</label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full border @error('email') border-red-500 @else border-gray-300 @enderror rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="phone" class="block text-gray-700 text-sm font-medium mb-2">Téléphone</label>
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="w-full border @error('phone') border-red-500 @else border-gray-300 @enderror rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                                    @error('phone')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="subject" class="block text-gray-700 text-sm font-medium mb-2">Sujet *</label>
                                    <select id="subject" name="subject" class="w-full border @error('subject') border-red-500 @else border-gray-300 @enderror rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
                                        <option value="" disabled {{ old('subject') ? '' : 'selected' }}>Sélectionnez un sujet</option>
                                        <option value="information" {{ old('subject') == 'information' ? 'selected' : '' }}>Demande d'information</option>
                                        <option value="reservation" {{ old('subject') == 'reservation' ? 'selected' : '' }}>Réservation de circuit</option>
                                        <option value="custom" {{ old('subject') == 'custom' ? 'selected' : '' }}>Circuit sur mesure</option>
                                        <option value="feedback" {{ old('subject') == 'feedback' ? 'selected' : '' }}>Commentaires</option>
                                        <option value="other" {{ old('subject') == 'other' ? 'selected' : '' }}>Autre</option>
                                    </select>
                                    @error('subject')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-6">
                                <label for="message" class="block text-gray-700 text-sm font-medium mb-2">Message *</label>
                                <textarea id="message" name="message" rows="6" class="w-full border @error('message') border-red-500 @else border-gray-300 @enderror rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex items-center mb-6">
                                <input type="checkbox" id="privacy" name="privacy" class="mr-2 @error('privacy') border-red-500 @enderror" required>
                                <label for="privacy" class="text-gray-700 text-sm">J'accepte que mes données soient traitées conformément à la <a href="#" class="text-green-600 hover:underline">politique de confidentialité</a> *</label>
                                @error('privacy')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <button type="submit" class="bg-green-600 text-white font-medium py-2 px-6 rounded-md hover:bg-green-700 transition duration-300">
                                Envoyer le message
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Contact Info -->
                <div>
                    <div class="bg-white rounded-lg shadow-md p-6 md:p-8 mb-8">
                        <h2 class="text-2xl font-bold mb-6">Nos coordonnées</h2>
                        
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="bg-green-100 rounded-full p-3 mr-4">
                                    <i class="fas fa-map-marker-alt text-green-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-lg mb-1">Adresse</h3>
                                    <p class="text-gray-600">Nyékonakpoè, à 100m de la pharmacie Pour Tous </p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="bg-green-100 rounded-full p-3 mr-4">
                                    <i class="fas fa-phone-alt text-green-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-lg mb-1">Téléphone</h3>
                                    <p class="text-gray-600">(228) 91 92 93 83 </p>
                                    <p class="text-gray-600">(228) 91 92 93 83  (WhatsApp)</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="bg-green-100 rounded-full p-3 mr-4">
                                    <i class="fas fa-envelope text-green-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-lg mb-1">Email</h3>
                                    <p class="text-gray-600">theelomtours@gmail.com </p>
                                    {{-- <p class="text-gray-600">reservations@theelomtours.com</p> --}}
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="bg-green-100 rounded-full p-3 mr-4">
                                    <i class="fas fa-clock text-green-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-lg mb-1">Heures d'ouverture</h3>
                                    <p class="text-gray-600">Lundi - Vendredi: 8h00 - 18h00</p>
                                    <p class="text-gray-600">Samedi: 9h00 - 15h00</p>
                                    <p class="text-gray-600">Dimanche: Fermé</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8">
                            <h3 class="font-semibold text-lg mb-3">Suivez-nous</h3>
                            <div class="flex space-x-3">
                                <a href="#" class="bg-blue-600 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-700">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="bg-blue-400 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-500">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="bg-pink-600 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-pink-700">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" class="bg-red-600 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-red-700">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-md p-6 md:p-8">
                        <h2 class="text-2xl font-bold mb-4">Besoin d'aide?</h2>
                        <p class="text-gray-600 mb-4">Vous avez des questions sur nos circuits ou vous souhaitez un devis personnalisé? Notre équipe est à votre disposition.</p>
                        <a href="tel:+22891929383" class="flex items-center justify-center bg-green-600 text-white font-medium py-3 px-6 rounded-md hover:bg-green-700 transition duration-300 mb-3">
                            <i class="fas fa-phone-alt mr-2"></i> Appelez-nous
                        </a>
                        <a href="https://wa.me/22891929383" class="flex items-center justify-center bg-green-500 text-white font-medium py-3 px-6 rounded-md hover:bg-green-600 transition duration-300">
                            <i class="fab fa-whatsapp mr-2"></i> WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="pb-16">
        <div class="container mx-auto px-4">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <h2 class="text-2xl font-bold p-6 border-b">Notre localisation</h2>
                <div class="h-96">
                    <!-- Replace with your Google Maps embed code -->
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63520.97421657724!2d1.1723196!3d6.1731784!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1023e1c113185419%3A0x3224b5422caf411d!2zTG9tw6k!5e0!3m2!1sfr!2stg!4v1623825273452!5m2!1sfr!2stg" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="pb-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold mb-2">Questions fréquentes</h2>
                <p class="text-gray-600">Trouvez rapidement des réponses à vos questions</p>
            </div>
            
            <div class="max-w-3xl mx-auto">
                <div class="space-y-4">
                    <!-- FAQ Item 1 -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <button class="faq-toggle w-full flex items-center justify-between bg-white p-4 focus:outline-none">
                            <span class="font-medium text-left">Comment réserver un circuit avec The Elom Tours?</span>
                            <i class="fas fa-chevron-down text-gray-500 transition-transform duration-300"></i>
                        </button>
                        <div class="faq-content bg-gray-50 px-4 py-3 hidden">
                            <p class="text-gray-600">Vous pouvez réserver un circuit de plusieurs façons: directement sur notre site web en utilisant notre formulaire de réservation, par email à reservations@theelomtours.com, par téléphone au +228 22 22 22 22, ou en nous rendant visite dans nos bureaux à Lomé. Nous vous recommandons de réserver au moins 2 semaines à l'avance pour garantir la disponibilité.</p>
                        </div>
                    </div>
                    
                    <!-- FAQ Item 2 -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <button class="faq-toggle w-full flex items-center justify-between bg-white p-4 focus:outline-none">
                            <span class="font-medium text-left">Quels documents sont nécessaires pour visiter le Togo?</span>
                            <i class="fas fa-chevron-down text-gray-500 transition-transform duration-300"></i>
                        </button>
                        <div class="faq-content bg-gray-50 px-4 py-3 hidden">
                            <p class="text-gray-600">Pour visiter le Togo, vous aurez besoin d'un passeport valide au moins 6 mois après la date de retour prévue. Un visa est également nécessaire pour la plupart des nationalités, que vous pouvez obtenir à l'ambassade du Togo dans votre pays ou en ligne via le système e-Visa. Nous vous recommandons également de vous munir d'un certificat international de vaccination contre la fièvre jaune, qui est obligatoire pour entrer au Togo.</p>
                        </div>
                    </div>
                    
                    <!-- FAQ Item 3 -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <button class="faq-toggle w-full flex items-center justify-between bg-white p-4 focus:outline-none">
                            <span class="font-medium text-left">Quelle est la meilleure période pour visiter le Togo?</span>
                            <i class="fas fa-chevron-down text-gray-500 transition-transform duration-300"></i>
                        </button>
                        <div class="faq-content bg-gray-50 px-4 py-3 hidden">
                            <p class="text-gray-600">La meilleure période pour visiter le Togo est pendant la saison sèche, de novembre à mars. Le climat est alors plus agréable avec des températures moyennes de 25-32°C et peu de précipitations. Cette période est idéale pour explorer les parcs nationaux, les villages traditionnels et les plages. La saison des pluies (avril à octobre) offre des paysages plus verdoyants mais peut rendre certaines routes difficiles d'accès, particulièrement dans les zones rurales.</p>
                        </div>
                    </div>
                    
                    <!-- FAQ Item 4 -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <button class="faq-toggle w-full flex items-center justify-between bg-white p-4 focus:outline-none">
                            <span class="font-medium text-left">Proposez-vous des circuits personnalisés?</span>
                            <i class="fas fa-chevron-down text-gray-500 transition-transform duration-300"></i>
                        </button>
                        <div class="faq-content bg-gray-50 px-4 py-3 hidden">
                            <p class="text-gray-600">Oui, nous proposons des circuits sur mesure adaptés à vos intérêts, votre budget et votre emploi du temps. Que vous soyez intéressé par la culture, l'aventure, la nature, la photographie ou une combinaison de ces éléments, nous pouvons créer un itinéraire personnalisé qui répond à vos attentes. Contactez-nous avec vos préférences et nous vous proposerons un circuit adapté à vos besoins.</p>
                        </div>
                    </div>
                    
                    <!-- FAQ Item 5 -->
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <button class="faq-toggle w-full flex items-center justify-between bg-white p-4 focus:outline-none">
                            <span class="font-medium text-left">Quelles sont les modalités de paiement?</span>
                            <i class="fas fa-chevron-down text-gray-500 transition-transform duration-300"></i>
                        </button>
                        <div class="faq-content bg-gray-50 px-4 py-3 hidden">
                            <p class="text-gray-600">Nous acceptons plusieurs modes de paiement: carte de crédit (Visa, MasterCard), virement bancaire, PayPal et paiement mobile (Flooz, T-Money). Pour confirmer votre réservation, un acompte de 30% est généralement requis, le solde devant être réglé au plus tard 30 jours avant le début du circuit. Pour les réservations effectuées moins de 30 jours avant le départ, le paiement intégral est demandé.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const faqToggles = document.querySelectorAll('.faq-toggle');
            
            faqToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const content = this.nextElementSibling;
                    const icon = this.querySelector('i');
                    
                    // Toggle the current FAQ item
                    content.classList.toggle('hidden');
                    icon.classList.toggle('rotate-180');
                    
                    // Close other FAQ items
                    faqToggles.forEach(otherToggle => {
                        if (otherToggle !== toggle) {
                            const otherContent = otherToggle.nextElementSibling;
                            const otherIcon = otherToggle.querySelector('i');
                            
                            otherContent.classList.add('hidden');
                            otherIcon.classList.remove('rotate-180');
                        }
                    });
                });
            });
        });
    </script>
@endsection