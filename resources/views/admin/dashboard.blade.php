@extends('layouts.admin')

@section('title', 'DASHBOARD - THE ELOM\' TOURS')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6">Tableau de bord</h1>
    
    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Carte statistique 1 -->
        <div class="bg-[#16a34a] text-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium">Total Réservations</p>
                    <p class="text-3xl font-bold">124</p>
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
                    <p class="text-3xl font-bold">8,540€</p>
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
                    <p class="text-3xl font-bold">45</p>
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
                    <p class="text-3xl font-bold">92%</p>
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
                    <!-- Ligne 1 -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-700 font-medium">JD</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">Jean Dupont</div>
                                    <div class="text-sm text-gray-500">jean.dupont@example.com</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">Découverte de Kpalimé</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">15/06/2023</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">1,250€</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Confirmé</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="#" class="text-primary hover:text-green-700 mr-3"><i class="fas fa-eye"></i></a>
                            <a href="#" class="text-blue-600 hover:text-blue-800 mr-3"><i class="fas fa-edit"></i></a>
                            <a href="#" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <!-- Ligne 2 -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-700 font-medium">ML</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">Marie Lefebvre</div>
                                    <div class="text-sm text-gray-500">marie.lefebvre@example.com</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">Safari à Fazao</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">12/06/2023</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">2,100€</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">En attente</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="#" class="text-primary hover:text-green-700 mr-3"><i class="fas fa-eye"></i></a>
                            <a href="#" class="text-blue-600 hover:text-blue-800 mr-3"><i class="fas fa-edit"></i></a>
                            <a href="#" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <!-- Ligne 3 -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-700 font-medium">PT</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">Pierre Thomas</div>
                                    <div class="text-sm text-gray-500">pierre.thomas@example.com</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">Lomé Culturelle</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">10/06/2023</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">950€</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Confirmé</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="#" class="text-primary hover:text-green-700 mr-3"><i class="fas fa-eye"></i></a>
                            <a href="#" class="text-blue-600 hover:text-blue-800 mr-3"><i class="fas fa-edit"></i></a>
                            <a href="#" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
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
            <!-- Notification 1 -->
            <div class="flex items-start p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded-md">
                <div class="flex-shrink-0 mr-3">
                    <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">Stock faible pour le circuit "Découverte de Kpalimé"</p>
                    <p class="text-sm text-gray-500 mt-1">Il ne reste que 2 places disponibles pour la date du 20/07/2023</p>
                    <div class="mt-2">
                        <span class="text-xs text-gray-500">Il y a 3 heures</span>
                    </div>
                </div>
            </div>
            <!-- Notification 2 -->
            <div class="flex items-start p-4 bg-blue-50 border-l-4 border-blue-400 rounded-md">
                <div class="flex-shrink-0 mr-3">
                    <i class="fas fa-info-circle text-blue-500"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">Nouvelle demande de contact</p>
                    <p class="text-sm text-gray-500 mt-1">Sophie Martin a envoyé une demande d'information concernant le circuit "Safari à Fazao"</p>
                    <div class="mt-2">
                        <span class="text-xs text-gray-500">Il y a 5 heures</span>
                    </div>
                </div>
            </div>
            <!-- Notification 3 -->
            <div class="flex items-start p-4 bg-green-50 border-l-4 border-green-400 rounded-md">
                <div class="flex-shrink-0 mr-3">
                    <i class="fas fa-check-circle text-green-500"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">Paiement reçu</p>
                    <p class="text-sm text-gray-500 mt-1">Le paiement de 1,250€ pour la réservation #12345 a été reçu</p>
                    <div class="mt-2">
                        <span class="text-xs text-gray-500">Il y a 1 jour</span>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    
    <!-- Avis récents -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Avis clients récents</h2>
            <a href="{{ route('admin.reviews.index') }}" class="text-primary hover:text-green-700 font-medium">Voir tout</a>
        </div>
        <div class="space-y-4">
            @php
                $recentReviews = \App\Models\Review::with('circuit')->latest()->take(3)->get();
            @endphp
            
            @forelse($recentReviews as $review)
                <div class="flex items-start p-4 {{ $review->is_approved ? 'bg-green-50 border-l-4 border-green-400' : 'bg-yellow-50 border-l-4 border-yellow-400' }} rounded-md">
                    <div class="flex-shrink-0 mr-3">
                        <i class="fas {{ $review->is_approved ? 'fa-check-circle text-green-500' : 'fa-clock text-yellow-500' }}"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between">
                            <p class="text-sm font-medium text-gray-900">{{ $review->name }} <span class="text-gray-500 text-xs">pour</span> {{ $review->circuit->titre ?? 'Circuit inconnu' }}</p>
                            <div class="text-yellow-500">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fas fa-star text-xs"></i>
                                    @else
                                        <i class="far fa-star text-xs"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">{{ Str::limit($review->comment, 100) }}</p>
                        <div class="mt-2 flex justify-between">
                            <span class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                            <div>
                                @if(!$review->is_approved)
                                    <a href="{{ route('admin.reviews.approve', $review) }}" class="text-xs text-green-600 hover:text-green-800 mr-2">Approuver</a>
                                @endif
                                <a href="{{ route('admin.reviews.edit', $review) }}" class="text-xs text-blue-600 hover:text-blue-800">Modifier</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-4 text-gray-500">
                    <p>Aucun avis récent</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Graphique des réservations mensuelles
    const reservationsCtx = document.getElementById('reservationsChart').getContext('2d');
    const reservationsChart = new Chart(reservationsCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
            datasets: [{
                label: 'Réservations',
                data: [15, 20, 25, 30, 35, 40, 45, 50, 45, 40, 35, 30],
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
    const circuitsChart = new Chart(circuitsCtx, {
        type: 'bar',
        data: {
            labels: ['Découverte de Kpalimé', 'Safari à Fazao', 'Lomé Culturelle', 'Plages de Togoville', 'Montagnes de Kara'],
            datasets: [{
                label: 'Réservations',
                data: [45, 38, 32, 28, 22],
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