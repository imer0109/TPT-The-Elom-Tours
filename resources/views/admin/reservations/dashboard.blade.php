@extends('admin.layouts.app')

@section('title', 'Tableau de bord des réservations')

@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700">
        Tableau de bord des réservations
    </h2>

    <!-- Breadcrumb -->
    <div class="flex text-sm text-gray-600 mb-4">
        <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800">
            Dashboard
        </a>
        <span class="mx-2">/</span>
        <a href="{{ route('admin.reservations.index') }}" class="text-blue-600 hover:text-blue-800">
            Réservations
        </a>
        <span class="mx-2">/</span>
        <span>Tableau de bord</span>
    </div>

    <!-- Cartes statistiques -->
    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
        <!-- Réservations totales -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-md">
            <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">
                    Réservations totales
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    {{ $stats['total'] }}
                </p>
            </div>
        </div>
        
        <!-- Réservations en attente -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-md">
            <div class="p-3 mr-4 text-yellow-500 bg-yellow-100 rounded-full">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14a6 6 0 110-12 6 6 0 010 12z"></path>
                    <path d="M10 6a1 1 0 011 1v3a1 1 0 01-1 1 1 1 0 01-1-1V7a1 1 0 011-1zm0 8a1 1 0 100-2 1 1 0 000 2z"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">
                    En attente
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    {{ $stats['pending'] }}
                </p>
            </div>
        </div>
        
        <!-- Réservations confirmées -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-md">
            <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">
                    Confirmées
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    {{ $stats['confirmed'] }}
                </p>
            </div>
        </div>
        
        <!-- Montant total -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-md">
            <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">
                    Montant total
                </p>
                <p class="text-lg font-semibold text-gray-700">
                    {{ number_format($stats['montant_total'], 2, ',', ' ') }} €
                </p>
            </div>
        </div>
    </div>

    <!-- Graphiques et tableaux -->
    <div class="grid gap-6 mb-8 md:grid-cols-2">
        <!-- Graphique des réservations par mois -->
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-md">
            <h4 class="mb-4 font-semibold text-gray-800">
                Réservations par mois ({{ date('Y') }})
            </h4>
            <canvas id="reservationsChart"></canvas>
        </div>
        
        <!-- Circuits les plus réservés -->
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-md">
            <h4 class="mb-4 font-semibold text-gray-800">
                Circuits les plus réservés
            </h4>
            <div class="w-full overflow-hidden rounded-lg">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                <th class="px-4 py-3">Circuit</th>
                                <th class="px-4 py-3">Réservations</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y">
                            @forelse($top_circuits as $circuit)
                                <tr class="text-gray-700">
                                    <td class="px-4 py-3 text-sm">
                                        {{ $circuit->titre }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ $circuit->count }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-4 py-3 text-sm text-center text-gray-500">
                                        Aucune donnée disponible
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Réservations récentes -->
    <div class="min-w-0 p-4 bg-white rounded-lg shadow-md mb-8">
        <h4 class="mb-4 font-semibold text-gray-800">
            Réservations récentes
        </h4>
        <div class="w-full overflow-hidden rounded-lg">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                            <th class="px-4 py-3">ID</th>
                            <th class="px-4 py-3">Client</th>
                            <th class="px-4 py-3">Circuit</th>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Montant</th>
                            <th class="px-4 py-3">Statut</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        @forelse($recent_reservations as $reservation)
                            <tr class="text-gray-700">
                                <td class="px-4 py-3 text-sm">
                                    #{{ $reservation->id }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $reservation->client->nom }} {{ $reservation->client->prenom }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $reservation->circuit->titre }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ \Carbon\Carbon::parse($reservation->date_debut)->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ number_format($reservation->montant_total, 2, ',', ' ') }} €
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if($reservation->status == 'pending')
                                        <span class="px-2 py-1 text-xs font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full">
                                            En attente
                                        </span>
                                    @elseif($reservation->status == 'confirmed')
                                        <span class="px-2 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                                            Confirmée
                                        </span>
                                    @elseif($reservation->status == 'cancelled')
                                        <span class="px-2 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded-full">
                                            Annulée
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <a href="{{ route('admin.reservations.show', $reservation) }}" class="text-blue-600 hover:text-blue-900">
                                        Voir
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-3 text-sm text-center text-gray-500">
                                    Aucune réservation récente
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Données pour le graphique des réservations par mois
        const reservationsData = @json($reservations_by_month);
        
        // Noms des mois en français
        const monthNames = [
            'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
            'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
        ];
        
        // Préparer les données pour Chart.js
        const labels = [];
        const data = [];
        
        for (let i = 1; i <= 12; i++) {
            labels.push(monthNames[i-1]);
            data.push(reservationsData[i] || 0);
        }
        
        // Créer le graphique
        const ctx = document.getElementById('reservationsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Nombre de réservations',
                    data: data,
                    backgroundColor: 'rgba(66, 153, 225, 0.5)',
                    borderColor: 'rgba(66, 153, 225, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    });
</script>
@endsection