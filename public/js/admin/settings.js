/**
 * Script pour la gestion des paramètres du site
 */

document.addEventListener('DOMContentLoaded', function() {
    // Gestion des onglets
    initTabs();
    
    // Gestion des formulaires
    initForms();
    
    // Gestion des boutons spéciaux
    initSpecialButtons();
    
    // Gestion des toggles de visibilité
    initToggles();
});

/**
 * Initialise les onglets
 */
function initTabs() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            
            // Désactiver tous les onglets
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.add('hidden'));
            
            // Activer l'onglet sélectionné
            this.classList.add('active');
            document.getElementById(`${tabId}-tab`).classList.remove('hidden');
            
            // Sauvegarder l'onglet actif dans le localStorage
            localStorage.setItem('activeSettingsTab', tabId);
        });
    });
    
    // Restaurer l'onglet actif depuis le localStorage
    const activeTab = localStorage.getItem('activeSettingsTab');
    if (activeTab) {
        const activeButton = document.querySelector(`.tab-button[data-tab="${activeTab}"]`);
        if (activeButton) {
            activeButton.click();
        }
    }
}

/**
 * Initialise les formulaires
 */
function initForms() {
    const forms = document.querySelectorAll('form');
    const saveAllButton = document.getElementById('save-all-settings');
    
    if (saveAllButton) {
        saveAllButton.addEventListener('click', function() {
            // Simuler l'enregistrement de tous les formulaires
            const button = this;
            const originalText = button.innerHTML;
            
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Enregistrement...';
            
            // Collecter les données de tous les formulaires
            const formData = {};
            forms.forEach(form => {
                const formElements = form.elements;
                for (let i = 0; i < formElements.length; i++) {
                    const element = formElements[i];
                    if (element.name) {
                        if (element.type === 'checkbox') {
                            formData[element.name] = element.checked;
                        } else if (element.type === 'radio') {
                            if (element.checked) {
                                formData[element.name] = element.value;
                            }
                        } else if (element.type === 'select-multiple') {
                            const selectedOptions = Array.from(element.selectedOptions).map(option => option.value);
                            formData[element.name] = selectedOptions;
                        } else {
                            formData[element.name] = element.value;
                        }
                    }
                }
            });
            
            // Simuler une requête AJAX
            setTimeout(function() {
                console.log('Données à enregistrer:', formData);
                
                button.innerHTML = '<i class="fas fa-check mr-2"></i> Enregistré !';
                
                // Afficher une notification de succès
                showNotification('Tous les paramètres ont été enregistrés avec succès.', 'success');
                
                setTimeout(function() {
                    button.disabled = false;
                    button.innerHTML = originalText;
                }, 2000);
            }, 1500);
        });
    }
}

/**
 * Initialise les boutons spéciaux
 */
function initSpecialButtons() {
    // Bouton de génération de sitemap
    const generateSitemapButton = document.getElementById('generate_sitemap');
    if (generateSitemapButton) {
        generateSitemapButton.addEventListener('click', function() {
            const button = this;
            const originalText = button.innerHTML;
            
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Génération en cours...';
            
            // Simuler une requête AJAX
            setTimeout(function() {
                button.innerHTML = '<i class="fas fa-check mr-2"></i> Sitemap généré !';
                
                // Mettre à jour la date de dernière génération
                const now = new Date();
                const formattedDate = `${now.getDate().toString().padStart(2, '0')}/${(now.getMonth() + 1).toString().padStart(2, '0')}/${now.getFullYear()} à ${now.getHours().toString().padStart(2, '0')}:${now.getMinutes().toString().padStart(2, '0')}`;
                
                const lastGeneratedElement = button.nextElementSibling;
                if (lastGeneratedElement) {
                    lastGeneratedElement.textContent = `Dernier sitemap généré: ${formattedDate}`;
                }
                
                // Afficher une notification de succès
                showNotification('Le sitemap a été généré avec succès.', 'success');
                
                setTimeout(function() {
                    button.disabled = false;
                    button.innerHTML = originalText;
                }, 2000);
            }, 1500);
        });
    }
    
    // Bouton d'envoi d'email de test
    const testEmailButton = document.getElementById('test_email');
    if (testEmailButton) {
        testEmailButton.addEventListener('click', function() {
            const button = this;
            const originalText = button.innerHTML;
            
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Envoi en cours...';
            
            // Simuler une requête AJAX
            setTimeout(function() {
                button.innerHTML = '<i class="fas fa-check mr-2"></i> Email envoyé !';
                
                // Afficher une notification de succès
                showNotification('L\'email de test a été envoyé avec succès.', 'success');
                
                setTimeout(function() {
                    button.disabled = false;
                    button.innerHTML = originalText;
                }, 2000);
            }, 1500);
        });
    }
    
    // Bouton de génération de clé API
    const generateApiKeyButton = document.getElementById('generate_api_key');
    if (generateApiKeyButton) {
        generateApiKeyButton.addEventListener('click', function() {
            const apiKeyInput = document.getElementById('api_key');
            if (apiKeyInput) {
                // Générer une clé aléatoire
                const randomKey = 'elom_api_' + generateRandomString(20);
                apiKeyInput.value = randomKey;
                
                // Afficher une notification de succès
                showNotification('Une nouvelle clé API a été générée.', 'success');
            }
        });
    }
    
    // Bouton de génération de secret API
    const generateApiSecretButton = document.getElementById('generate_api_secret');
    if (generateApiSecretButton) {
        generateApiSecretButton.addEventListener('click', function() {
            const apiSecretInput = document.getElementById('api_secret');
            if (apiSecretInput) {
                // Générer un secret aléatoire
                const randomSecret = 'elom_secret_' + generateRandomString(20);
                apiSecretInput.value = randomSecret;
                
                // Afficher une notification de succès
                showNotification('Un nouveau secret API a été généré.', 'success');
            }
        });
    }
    
    // Bouton pour afficher/masquer le secret API
    const toggleApiSecretButton = document.getElementById('toggle_api_secret');
    if (toggleApiSecretButton) {
        toggleApiSecretButton.addEventListener('click', function() {
            const apiSecretInput = document.getElementById('api_secret');
            if (apiSecretInput) {
                const type = apiSecretInput.getAttribute('type') === 'password' ? 'text' : 'password';
                apiSecretInput.setAttribute('type', type);
                
                const icon = this.querySelector('i');
                if (icon) {
                    if (type === 'password') {
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    } else {
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    }
                }
            }
        });
    }
}

/**
 * Initialise les toggles de visibilité
 */
function initToggles() {
    // Gestion du toggle de mode maintenance
    const maintenanceModeToggle = document.getElementById('maintenance_mode');
    if (maintenanceModeToggle) {
        maintenanceModeToggle.addEventListener('change', function() {
            if (this.checked) {
                // Demander confirmation avant d'activer le mode maintenance
                if (confirm('Êtes-vous sûr de vouloir activer le mode maintenance ? Le site ne sera plus accessible aux visiteurs.')) {
                    showNotification('Le mode maintenance a été activé.', 'warning');
                } else {
                    this.checked = false;
                }
            } else {
                showNotification('Le mode maintenance a été désactivé.', 'success');
            }
        });
    }
}

/**
 * Affiche une notification
 * @param {string} message - Le message à afficher
 * @param {string} type - Le type de notification (success, warning, error, info)
 */
function showNotification(message, type = 'info') {
    // Créer l'élément de notification
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transition-all duration-300 transform translate-x-full`;
    
    // Définir la couleur en fonction du type
    switch (type) {
        case 'success':
            notification.classList.add('bg-green-500', 'text-white');
            break;
        case 'warning':
            notification.classList.add('bg-yellow-500', 'text-white');
            break;
        case 'error':
            notification.classList.add('bg-red-500', 'text-white');
            break;
        default:
            notification.classList.add('bg-blue-500', 'text-white');
            break;
    }
    
    // Ajouter le contenu
    notification.innerHTML = `
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'warning' ? 'fa-exclamation-triangle' : type === 'error' ? 'fa-times-circle' : 'fa-info-circle'} mr-2"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium">${message}</p>
            </div>
            <div class="ml-auto pl-3">
                <button type="button" class="inline-flex text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    `;
    
    // Ajouter au DOM
    document.body.appendChild(notification);
    
    // Animer l'entrée
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
        notification.classList.add('translate-x-0');
    }, 10);
    
    // Ajouter l'événement de fermeture
    const closeButton = notification.querySelector('button');
    closeButton.addEventListener('click', () => {
        closeNotification(notification);
    });
    
    // Fermer automatiquement après 5 secondes
    setTimeout(() => {
        closeNotification(notification);
    }, 5000);
}

/**
 * Ferme une notification
 * @param {HTMLElement} notification - L'élément de notification à fermer
 */
function closeNotification(notification) {
    notification.classList.remove('translate-x-0');
    notification.classList.add('translate-x-full');
    
    setTimeout(() => {
        notification.remove();
    }, 300);
}

/**
 * Génère une chaîne aléatoire
 * @param {number} length - La longueur de la chaîne à générer
 * @returns {string} - La chaîne aléatoire
 */
function generateRandomString(length) {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let result = '';
    for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * characters.length));
    }
    return result;
}