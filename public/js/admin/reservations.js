/**
 * Script pour la gestion des réservations dans l'administration
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialisation des éléments de l'interface
    initDatepickers();
    initCalculMontant();
    initFilterForm();
    initStatusToggle();
    initDeleteConfirmation();
    
    // Si on est sur la page dashboard, initialiser les graphiques
    if (document.getElementById('reservationsChart')) {
        initReservationsChart();
    }
});

/**
 * Initialise les sélecteurs de date
 */
function initDatepickers() {
    const dateInputs = document.querySelectorAll('.datepicker');
    
    if (dateInputs.length > 0) {
        dateInputs.forEach(input => {
            // Utilisation de flatpickr ou autre librairie de datepicker
            flatpickr(input, {
                dateFormat: "Y-m-d",
                locale: "fr",
                allowInput: true
            });
        });
    }
    
    // Validation des dates (date_fin >= date_debut)
    const dateDebut = document.getElementById('date_debut');
    const dateFin = document.getElementById('date_fin');
    
    if (dateDebut && dateFin) {
        dateDebut.addEventListener('change', function() {
            if (dateFin.value && new Date(dateDebut.value) > new Date(dateFin.value)) {
                dateFin.value = dateDebut.value;
            }
            dateFin.setAttribute('min', dateDebut.value);
            calculerMontantTotal();
        });
        
        dateFin.addEventListener('change', function() {
            calculerMontantTotal();
        });
    }
}

/**
 * Initialise le calcul automatique du montant total
 */
function initCalculMontant() {
    const circuitSelect = document.getElementById('circuit_id');
    const nombrePersonnes = document.getElementById('nombre_personnes');
    
    if (circuitSelect && nombrePersonnes) {
        circuitSelect.addEventListener('change', calculerMontantTotal);
        nombrePersonnes.addEventListener('change', calculerMontantTotal);
        nombrePersonnes.addEventListener('input', calculerMontantTotal);
        
        // Calcul initial
        calculerMontantTotal();
    }
}

/**
 * Calcule le montant total de la réservation
 */
function calculerMontantTotal() {
    const circuitSelect = document.getElementById('circuit_id');
    const nombrePersonnes = document.getElementById('nombre_personnes');
    const montantTotal = document.getElementById('montant_total');
    const dateDebut = document.getElementById('date_debut');
    const dateFin = document.getElementById('date_fin');
    
    if (circuitSelect && nombrePersonnes && montantTotal && dateDebut && dateFin) {
        const selectedOption = circuitSelect.options[circuitSelect.selectedIndex];
        
        if (selectedOption && selectedOption.dataset.prix && nombrePersonnes.value > 0 && dateDebut.value && dateFin.value) {
            const prixCircuit = parseFloat(selectedOption.dataset.prix);
            const nbPersonnes = parseInt(nombrePersonnes.value);
            
            // Calcul du nombre de jours
            const debut = new Date(dateDebut.value);
            const fin = new Date(dateFin.value);
            const diffTime = Math.abs(fin - debut);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // +1 pour inclure le jour de départ
            
            // Calcul du montant total
            const total = prixCircuit * nbPersonnes * diffDays;
            montantTotal.value = total.toFixed(2);
        } else {
            montantTotal.value = '0.00';
        }
    }
}

/**
 * Initialise le formulaire de filtrage
 */
function initFilterForm() {
    const filterForm = document.getElementById('filterForm');
    const resetButton = document.getElementById('resetFilters');
    
    if (filterForm && resetButton) {
        resetButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Réinitialiser tous les champs du formulaire
            const inputs = filterForm.querySelectorAll('input, select');
            inputs.forEach(input => {
                if (input.type === 'text' || input.type === 'search' || input.tagName === 'SELECT') {
                    input.value = '';
                }
            });
            
            // Soumettre le formulaire
            filterForm.submit();
        });
    }
}

/**
 * Initialise les boutons de changement de statut
 */
function initStatusToggle() {
    const statusButtons = document.querySelectorAll('.status-toggle');
    
    if (statusButtons.length > 0) {
        statusButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const url = this.getAttribute('data-url');
                const status = this.getAttribute('data-status');
                const reservationId = this.getAttribute('data-id');
                
                if (url && status) {
                    // Confirmation avant changement de statut
                    if (confirm(`Êtes-vous sûr de vouloir changer le statut de cette réservation à "${status}" ?`)) {
                        // Envoi de la requête AJAX pour changer le statut
                        fetch(url, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ statut: status })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Mise à jour de l'interface
                                const statusBadge = document.querySelector(`#reservation-${reservationId} .status-badge`);
                                if (statusBadge) {
                                    // Supprimer les classes de couleur existantes
                                    statusBadge.classList.remove('bg-yellow-100', 'bg-green-100', 'bg-red-100', 'bg-blue-100', 'bg-purple-100');
                                    statusBadge.classList.remove('text-yellow-800', 'text-green-800', 'text-red-800', 'text-blue-800', 'text-purple-800');
                                    
                                    // Ajouter les nouvelles classes selon le statut
                                    switch(status) {
                                        case 'en_attente':
                                            statusBadge.classList.add('bg-yellow-100', 'text-yellow-800');
                                            statusBadge.textContent = 'En attente';
                                            break;
                                        case 'confirmee':
                                            statusBadge.classList.add('bg-green-100', 'text-green-800');
                                            statusBadge.textContent = 'Confirmée';
                                            break;
                                        case 'annulee':
                                            statusBadge.classList.add('bg-red-100', 'text-red-800');
                                            statusBadge.textContent = 'Annulée';
                                            break;
                                        case 'terminee':
                                            statusBadge.classList.add('bg-blue-100', 'text-blue-800');
                                            statusBadge.textContent = 'Terminée';
                                            break;
                                        case 'remboursee':
                                            statusBadge.classList.add('bg-purple-100', 'text-purple-800');
                                            statusBadge.textContent = 'Remboursée';
                                            break;
                                    }
                                }
                                
                                // Afficher une notification
                                showNotification('Statut mis à jour avec succès', 'success');
                            } else {
                                showNotification('Erreur lors de la mise à jour du statut', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Erreur:', error);
                            showNotification('Erreur lors de la mise à jour du statut', 'error');
                        });
                    }
                }
            });
        });
    }
}

/**
 * Initialise les confirmations de suppression
 */
function initDeleteConfirmation() {
    const deleteButtons = document.querySelectorAll('.delete-reservation');
    
    if (deleteButtons.length > 0) {
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (confirm('Êtes-vous sûr de vouloir supprimer cette réservation ? Cette action est irréversible.')) {
                    const form = this.closest('form');
                    if (form) {
                        form.submit();
                    }
                }
            });
        });
    }
}

/**
 * Initialise le graphique des réservations mensuelles
 */
function initReservationsChart() {
    const ctx = document.getElementById('reservationsChart').getContext('2d');
    const chartData = JSON.parse(document.getElementById('chartData').textContent);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Réservations',
                data: chartData.data,
                backgroundColor: 'rgba(16, 185, 129, 0.2)',
                borderColor: 'rgba(16, 185, 129, 1)',
                borderWidth: 2,
                tension: 0.3,
                pointBackgroundColor: 'rgba(16, 185, 129, 1)',
                pointRadius: 4
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
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 10,
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    bodySpacing: 5,
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 1,
                    callbacks: {
                        label: function(context) {
                            return `${context.parsed.y} réservation(s)`;
                        }
                    }
                }
            }
        }
    });
}

/**
 * Affiche une notification
 * @param {string} message - Le message à afficher
 * @param {string} type - Le type de notification (success, error, info)
 */
function showNotification(message, type = 'info') {
    // Créer l'élément de notification
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transform transition-all duration-300 ease-in-out translate-x-full';
    
    // Ajouter les classes selon le type
    switch(type) {
        case 'success':
            notification.classList.add('bg-green-100', 'text-green-800', 'border-l-4', 'border-green-500');
            break;
        case 'error':
            notification.classList.add('bg-red-100', 'text-red-800', 'border-l-4', 'border-red-500');
            break;
        default:
            notification.classList.add('bg-blue-100', 'text-blue-800', 'border-l-4', 'border-blue-500');
    }
    
    // Ajouter le contenu
    notification.innerHTML = `
        <div class="flex items-center">
            <div class="py-1">
                <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    ${type === 'success' ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>' : ''}
                    ${type === 'error' ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>' : ''}
                    ${type === 'info' ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>' : ''}
                </svg>
            </div>
            <div>
                <p class="font-bold">${message}</p>
            </div>
        </div>
    `;
    
    // Ajouter au DOM
    document.body.appendChild(notification);
    
    // Animation d'entrée
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
        notification.classList.add('translate-x-0');
    }, 10);
    
    // Supprimer après 3 secondes
    setTimeout(() => {
        notification.classList.remove('translate-x-0');
        notification.classList.add('translate-x-full');
        
        // Supprimer du DOM après l'animation
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}