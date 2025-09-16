@extends('layouts.admin')

@section('title', 'DASHBOARD - THE ELOM\' TOURS')

@section('content')
<div class="container mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Tableau de bord</h1>
        @auth
        <p class="text-sm text-gray-600 mt-1">Connecté en tant que <span class="font-medium">{{ auth()->user()->firstName ?? auth()->user()->name ?? 'Utilisateur' }}</span></p>
        @endauth
    </div>
    
    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Carte statistique 1 -->
        <div class="bg-[#16a34a] text-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium">Total Réservations</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['reservations'] ?? 0, 0, ',', ' ') }}</p>
                </div>
                <div class="bg-[#16a34a] rounded-full p-3">
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-sm"><span class="text-green-300"><i class="fas fa-arrow-up"></i> 12%</span> depuis le mois dernier</p>
            </div>
        </div>
        
        <!-- Carte statistique 2 -->
        <div class="bg-[#16a34a] text-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium">Revenus</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['revenue'] ?? 0, 0, ',', ' ') }} FCFA</p>
                </div>
                <div class="bg-[#16a34a] rounded-full p-3">
                    <i class="fas fa-money-bill-wave text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-sm"><span class="text-green-300"><i class="fas fa-arrow-up"></i> 8%</span> depuis le mois dernier</p>
            </div>
        </div>
        
        <!-- Carte statistique 3 -->
        <div class="bg-[#16a34a] text-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium">Nouveaux Clients</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['newClients'] ?? 0, 0, ',', ' ') }}</p>
                </div>
                <div class="bg-[#16a34a] rounded-full p-3">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-sm"><span class="text-green-300"><i class="fas fa-arrow-up"></i> 15%</span> depuis le mois dernier</p>
            </div>
        </div>
        
        <!-- Carte statistique 4 -->
        <div class="bg-[#16a34a] text-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium">Taux de Satisfaction</p>
                    <p class="text-3xl font-bold">{{ $stats['satisfaction'] ?? 0 }}%</p>
                </div>
                <div class="bg-[#16a34a] rounded-full p-3">
                    <i class="fas fa-smile text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-sm"><span class="text-green-300"><i class="fas fa-arrow-up"></i> 3%</span> depuis le mois dernier</p>
            </div>
        </div>
    </div>
    
    <!-- Graphiques -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Graphique 1 -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold mb-4">Réservations mensuelles</h2>
            <div class="h-80">
                <canvas id="reservationsChart"></canvas>
            </div>
        </div>
        
        <!-- Graphique 2 -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold mb-4">Circuits populaires</h2>
            <div class="h-80">
                <canvas id="circuitsChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Dernières réservations -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Dernières réservations</h2>
            <a href="#" class="text-primary hover:text-green-700 font-medium">Voir tout</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Circuit</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentReservationsData ?? [] as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-700 font-medium">{{ Str::of($item['client'])->explode(' ')->map(fn($p)=>Str::substr($p,0,1))->take(2)->implode('') }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $item['client'] }}</div>
                                    <div class="text-sm text-gray-500">{{ $item['email'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $item['circuit'] }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $item['date'] }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ number_format($item['amount'], 0, ',', ' ') }} FCFA</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php $status = $item['status']; @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $status === 'completed' ? 'bg-blue-100 text-blue-800' : '' }}
                            ">
                                {{ ucfirst($status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="#" class="text-primary hover:text-green-700 mr-3"><i class="fas fa-eye"></i></a>
                            <a href="#" class="text-blue-600 hover:text-blue-800 mr-3"><i class="fas fa-edit"></i></a>
                            <a href="#" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-6 text-center text-gray-500">Aucune réservation récente</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Alertes et notifications -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Alertes et notifications</h2>
            <a href="#" class="text-primary hover:text-green-700 font-medium">Voir tout</a>
        </div>
        <div class="space-y-4">
            @forelse(($notifications ?? []) as $n)
            <div class="flex items-start p-4 rounded-md border-l-4
                {{ ($n['type'] ?? 'info') === 'warning' ? 'bg-yellow-50 border-yellow-400' : '' }}
                {{ ($n['type'] ?? 'info') === 'info' ? 'bg-blue-50 border-blue-400' : '' }}
                {{ ($n['type'] ?? 'info') === 'success' ? 'bg-green-50 border-green-400' : '' }}
                {{ ($n['type'] ?? 'info') === 'error' ? 'bg-red-50 border-red-400' : '' }}
            ">
                <div class="flex-shrink-0 mr-3">
                    <i class="fas fa-{{ $n['icon'] ?? 'info-circle' }} {{ ($n['type'] ?? 'info') === 'warning' ? 'text-yellow-500' : '' }} {{ ($n['type'] ?? 'info') === 'info' ? 'text-blue-500' : '' }} {{ ($n['type'] ?? 'info') === 'success' ? 'text-green-500' : '' }} {{ ($n['type'] ?? 'info') === 'error' ? 'text-red-500' : '' }}"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">{{ $n['title'] ?? '' }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $n['message'] ?? '' }}</p>
                    <div class="mt-2">
                        <span class="text-xs text-gray-500">{{ $n['time'] ?? '' }}</span>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center text-gray-500 py-4">Aucune notification</div>
            @endforelse
        </div>
        </div>
    </div>
    
    <!-- Avis récents -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Avis clients récents</h2>
            <a href="{{ route('admin.reviews.index') }}" class="text-primary hover:text-green-700 font-medium">Voir tout</a>
        </div>
            @php
            $recentReviews = \App\Models\Review::with('circuit')->latest()->take(5)->get();
            @endphp
            @forelse($recentReviews as $review)
            <div class="border border-gray-100 rounded-lg p-4 mb-3">
                <div class="flex items-start justify-between">
                    <div class="flex items-start">
                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center mr-3">
                            <span class="text-gray-700 text-xs font-medium">{{ Str::of($review->name)->explode(' ')->map(fn($p) => Str::substr($p,0,1))->take(2)->implode('') }}</span>
                        </div>
                        <div>
                            <div class="flex items-center space-x-2">
                                <p class="text-sm font-semibold text-gray-900">{{ $review->name }}</p>
                                <span class="text-xs text-gray-500">• {{ $review->created_at->diffForHumans() }}</span>
                                <span class="px-2 py-0.5 text-[11px] rounded-full {{ $review->is_approved ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $review->is_approved ? 'Approuvé' : 'En attente' }}
                                </span>
                            </div>
                            <div class="text-xs text-gray-500">Circuit: <span class="text-gray-700 font-medium">{{ $review->circuit->titre ?? 'Circuit inconnu' }}</span></div>
                        </div>
                    </div>
                    <div class="text-yellow-500 ml-3">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fas fa-star text-xs"></i>
                                    @else
                                        <i class="far fa-star text-xs"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                <p class="text-sm text-gray-700 mt-2">{{ Str::limit($review->comment, 180) }}</p>
                <div class="mt-3 flex items-center justify-end space-x-3">
                                @if(!$review->is_approved)
                        <a href="{{ route('admin.reviews.approve', $review) }}" class="inline-flex items-center px-3 py-1.5 text-xs rounded-md bg-green-600 text-white hover:bg-green-700">
                            <i class="fas fa-check mr-1"></i> Approuver
                        </a>
                                @endif
                    <a href="{{ route('admin.reviews.edit', $review) }}" class="inline-flex items-center px-3 py-1.5 text-xs rounded-md bg-blue-600 text-white hover:bg-blue-700">
                        <i class="fas fa-edit mr-1"></i> Modifier
                    </a>
                </div>
                </div>
            @empty
                <div class="text-center py-4 text-gray-500">
                    <p>Aucun avis récent</p>
                </div>
            @endforelse
    </div>
@endsection

@section('scripts')
<script>
    // Graphique des réservations mensuelles
    const reservationsCtx = document.getElementById('reservationsChart').getContext('2d');
    const monthlyReservations = @json($chartData['monthlyReservations'] ?? []);
    const reservationsChart = new Chart(reservationsCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
            datasets: [{
                label: 'Réservations',
                data: monthlyReservations,
                backgroundColor: 'rgba(30, 64, 175, 0.2)',
                borderColor: 'rgba(30, 64, 175, 1)',
                borderWidth: 2,
                tension: 0.3,
                pointBackgroundColor: 'rgba(30, 64, 175, 1)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
    
    // Graphique des circuits populaires
    const circuitsCtx = document.getElementById('circuitsChart').getContext('2d');
    const popularLabels = @json($chartData['popularCircuits']['labels'] ?? []);
    const popularData = @json($chartData['popularCircuits']['data'] ?? []);
    const circuitsChart = new Chart(circuitsCtx, {
        type: 'bar',
        data: {
            labels: popularLabels,
            datasets: [{
                label: 'Réservations',
                data: popularData,
                backgroundColor: [
                    'rgba(22, 163, 74, 0.7)',
                    'rgba(30, 64, 175, 0.7)',
                    'rgba(249, 115, 22, 0.7)',
                    'rgba(217, 70, 239, 0.7)',
                    'rgba(234, 179, 8, 0.7)'
                ],
                borderColor: [
                    'rgba(22, 163, 74, 1)',
                    'rgba(30, 64, 175, 1)',
                    'rgba(249, 115, 22, 1)',
                    'rgba(217, 70, 239, 1)',
                    'rgba(234, 179, 8, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endsection