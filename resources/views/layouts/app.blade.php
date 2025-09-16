<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'THE ELOM\' TOURS')</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'Découvrez le Togo authentique avec The Elom Tours. Circuits touristiques, aventures culturelles et expériences inoubliables en Afrique de l\'Ouest.')">
    <meta name="keywords" content="@yield('meta_keywords', 'tourisme Togo, circuits Afrique, The Elom Tours, voyage Togo, tourisme Afrique de l\'Ouest, culture africaine')">
    <meta name="author" content="The Elom Tours">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', 'The Elom Tours - Découvrez l\'Afrique authentique')">
    <meta property="og:description" content="@yield('og_description', 'Découvrez le Togo authentique avec The Elom Tours. Circuits touristiques, aventures culturelles et expériences inoubliables en Afrique de l\'Ouest.')">
    <meta property="og:image" content="@yield('og_image', asset('assets/images/og-image.jpg'))">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('twitter_title', 'The Elom Tours - Découvrez l\'Afrique authentique')">
    <meta property="twitter:description" content="@yield('twitter_description', 'Découvrez le Togo authentique avec The Elom Tours. Circuits touristiques, aventures culturelles et expériences inoubliables en Afrique de l\'Ouest.')">
    <meta property="twitter:image" content="@yield('twitter_image', asset('assets/images/twitter-image.jpg'))">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('LogoUrl.jpg') }}" type="image/x-icon">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- PWA -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#16a34a">
    <link rel="apple-touch-icon" href="{{ asset('assets/icons/icon-192x192.png') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    
    <!-- CSRF Token for AJAX -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
        
        // Configure Fetch API with CSRF token
        document.addEventListener('DOMContentLoaded', function() {
            // Pour les requêtes fetch
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Intercepter les requêtes fetch pour ajouter le token CSRF
            const originalFetch = window.fetch;
            window.fetch = function(url, options = {}) {
                if (!options.headers) {
                    options.headers = {};
                }
                
                // Ajouter le token CSRF à l'en-tête
                options.headers['X-CSRF-TOKEN'] = csrfToken;
                
                return originalFetch(url, options);
            };
        });
    </script>
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
</head>
<body class="font-sans antialiased bg-gray-100">
    <!-- Header -->
    @include('layouts.partials.header')
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('layouts.partials.footer')
    
    <!-- Scripts -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/register-sw.js') }}"></script>
    <script>
        // Variable pour la clé VAPID publique (à remplacer par votre clé réelle)
        window.vapidPublicKey = '{{ config("services.webpush.public_key", "") }}';
    </script>
    
    @stack('scripts')
</body>
</html>