<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'ADMINISTRATION - THE ELOM\' TOURS ')</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Styles -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#16A34A', // Vert
                        secondary: '#1E40AF', // Bleu
                        dark: '#111827',
                        'dashboard-blue': '#1E3A8A'
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    @yield('styles')
</head>
<body class="bg-gray-100 font-sans">
    <div x-data="{ sidebarOpen: window.innerWidth >= 768 }" class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        @include('admin.partials.sidebar')
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Topbar -->
            @include('admin.partials.topbar')
            
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-3 sm:p-4 md:p-6 bg-gray-100">
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Notification Component -->
    @include('admin.components.notification')
    
    <!-- Confirmation Modal -->
    @include('admin.components.confirm-modal')
    
    <!-- Loading Overlay -->
    @include('admin.components.loading')
    
    <!-- Session Flash Messages -->
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showNotification("{{ session('success') }}", 'success');
        });
    </script>
    @endif
    
    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showNotification("{{ session('error') }}", 'error');
        });
    </script>
    @endif
    
    @if(session('warning'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showNotification("{{ session('warning') }}", 'warning');
        });
    </script>
    @endif
    
    @if(session('info'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showNotification("{{ session('info') }}", 'info');
        });
    </script>
    @endif
    
    <!-- Responsive Script -->
    <script>
        // Set sidebar state based on screen size
        window.addEventListener('resize', function() {
            if (window.innerWidth < 768) {
                Alpine.store('sidebar', { open: false });
            } else {
                Alpine.store('sidebar', { open: true });
            }
        });
    </script>
    
    @yield('scripts')
</body>
</html>