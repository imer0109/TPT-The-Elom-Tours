@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 text-center">
            <div>
                <img class="mx-auto h-24 w-auto" src="{{ asset('assets/images/logo.png') }}" alt="The Elom Tours">
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    404
                </h2>
                <p class="mt-2 text-center text-3xl font-bold text-gray-900">
                    Page non trouvée
                </p>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Oups! La page que vous recherchez semble avoir pris un autre chemin.
                </p>
            </div>
            <div class="mt-8">
                <img src="{{ asset('assets/images/404-illustration.svg') }}" alt="404 Illustration" class="mx-auto h-64">
            </div>
            <div class="mt-8 space-y-4">
                <p class="text-gray-600">
                    Voici quelques liens qui pourraient vous aider :
                </p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 justify-center">
                    <a href="{{ route('home') }}" class="w-full sm:w-auto flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 md:py-2 md:text-lg md:px-6">
                        <i class="fas fa-home mr-2"></i> Accueil
                    </a>
                    <a href="{{ route('circuits.index') }}" class="w-full sm:w-auto flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200 md:py-2 md:text-lg md:px-6">
                        <i class="fas fa-map-marked-alt mr-2"></i> Nos circuits
                    </a>
                </div>
                <div class="pt-4">
                    <a href="{{ route('contact.index') }}" class="text-green-600 hover:text-green-800 font-medium">
                        <i class="fas fa-envelope mr-1"></i> Contactez-nous
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection