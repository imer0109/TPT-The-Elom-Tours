@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 text-center">
            <div>
                <img class="mx-auto h-24 w-auto" src="{{ asset('assets/images/logo.png') }}" alt="The Elom Tours">
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Mode hors ligne
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Vous êtes actuellement hors ligne. Certaines fonctionnalités peuvent être limitées.
                </p>
            </div>
            <div class="mt-8">
                <img src="{{ asset('assets/images/offline-illustration.svg') }}" alt="Offline Illustration" class="mx-auto h-64">
            </div>
            <div class="mt-8 space-y-4">
                <p class="text-gray-600">
                    Voici ce que vous pouvez faire en mode hors ligne :
                </p>
                <ul class="text-left text-gray-600 pl-6 space-y-2">
                    <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Consulter les circuits déjà visités</li>
                    <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Voir les articles de blog mis en cache</li>
                    <li><i class="fas fa-check-circle text-green-500 mr-2"></i> Accéder aux informations de contact</li>
                </ul>
                <div class="pt-6">
                    <button onclick="window.location.reload()" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 md:py-2 md:text-lg md:px-6">
                        <i class="fas fa-sync-alt mr-2"></i> Réessayer la connexion
                    </button>
                </div>
                <div class="pt-4">
                    <p class="text-sm text-gray-500">
                        Reconnectez-vous à Internet pour accéder à toutes les fonctionnalités de The Elom Tours.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection