// Script pour enregistrer le Service Worker

if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('/sw.js')
      .then(registration => {
        console.log('Service Worker enregistré avec succès:', registration.scope);
        
        // Demander la permission pour les notifications
        requestNotificationPermission();
        
        // Vérifier les mises à jour du Service Worker
        registration.addEventListener('updatefound', () => {
          const newWorker = registration.installing;
          newWorker.addEventListener('statechange', () => {
            if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
              showUpdateNotification();
            }
          });
        });
      })
      .catch(error => {
        console.error('Erreur lors de l\'enregistrement du Service Worker:', error);
      });
      
    // Gérer les formulaires en mode hors ligne
    if ('SyncManager' in window) {
      setupFormSync();
    }
  });
}

// Fonction pour demander la permission des notifications
function requestNotificationPermission() {
  if ('Notification' in window) {
    Notification.requestPermission().then(permission => {
      if (permission === 'granted') {
        console.log('Permission de notification accordée');
        subscribeToPushNotifications();
      }
    });
  }
}

// Fonction pour s'abonner aux notifications push
async function subscribeToPushNotifications() {
  try {
    const registration = await navigator.serviceWorker.ready;
    const subscription = await registration.pushManager.subscribe({
      userVisibleOnly: true,
      applicationServerKey: urlBase64ToUint8Array(window.vapidPublicKey)
    });
    
    // Envoyer l'abonnement au serveur
    await fetch('/api/push-subscription', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(subscription)
    });
    
    console.log('Abonnement aux notifications push réussi');
  } catch (error) {
    console.error('Erreur lors de l\'abonnement aux notifications push:', error);
  }
}

// Fonction pour convertir la clé VAPID en format approprié
function urlBase64ToUint8Array(base64String) {
  const padding = '='.repeat((4 - base64String.length % 4) % 4);
  const base64 = (base64String + padding)
    .replace(/-/g, '+')
    .replace(/_/g, '/');
  
  const rawData = window.atob(base64);
  const outputArray = new Uint8Array(rawData.length);
  
  for (let i = 0; i < rawData.length; ++i) {
    outputArray[i] = rawData.charCodeAt(i);
  }
  
  return outputArray;
}

// Fonction pour configurer la synchronisation des formulaires
function setupFormSync() {
  const contactForm = document.getElementById('contact-form');
  
  if (contactForm) {
    contactForm.addEventListener('submit', async event => {
      if (!navigator.onLine) {
        event.preventDefault();
        
        const formData = new FormData(contactForm);
        const formDataObj = {};
        
        formData.forEach((value, key) => {
          formDataObj[key] = value;
        });
        
        formDataObj.id = Date.now().toString();
        
        try {
          await storeFormData(formDataObj);
          await navigator.serviceWorker.ready;
          await navigator.serviceWorker.sync.register('contact-form-submission');
          
          showOfflineSubmissionNotification();
          contactForm.reset();
        } catch (error) {
          console.error('Erreur lors de l\'enregistrement du formulaire hors ligne:', error);
        }
      }
    });
  }
}

// Fonction pour stocker les données du formulaire dans IndexedDB
async function storeFormData(formData) {
  return new Promise((resolve, reject) => {
    const request = indexedDB.open('elomToursOfflineDB', 1);
    
    request.onupgradeneeded = event => {
      const db = event.target.result;
      if (!db.objectStoreNames.contains('formRequests')) {
        db.createObjectStore('formRequests', { keyPath: 'id' });
      }
    };
    
    request.onsuccess = event => {
      const db = event.target.result;
      const transaction = db.transaction(['formRequests'], 'readwrite');
      const store = transaction.objectStore('formRequests');
      const addRequest = store.add(formData);
      
      addRequest.onsuccess = () => resolve();
      addRequest.onerror = () => reject(addRequest.error);
    };
    
    request.onerror = () => reject(request.error);
  });
}

// Fonction pour afficher une notification de mise à jour
function showUpdateNotification() {
  const updateNotification = document.createElement('div');
  updateNotification.className = 'fixed bottom-0 inset-x-0 pb-2 sm:pb-5 z-50';
  updateNotification.innerHTML = `
    <div class="max-w-screen-xl mx-auto px-2 sm:px-6 lg:px-8">
      <div class="p-2 rounded-lg bg-green-600 shadow-lg sm:p-3">
        <div class="flex items-center justify-between flex-wrap">
          <div class="w-0 flex-1 flex items-center">
            <span class="flex p-2 rounded-lg bg-green-800">
              <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
              </svg>
            </span>
            <p class="ml-3 font-medium text-white truncate">
              <span class="md:inline">Une nouvelle version du site est disponible!</span>
            </p>
          </div>
          <div class="order-3 mt-2 flex-shrink-0 w-full sm:order-2 sm:mt-0 sm:w-auto">
            <div class="rounded-md shadow-sm">
              <button id="update-app" class="flex items-center justify-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-green-600 bg-white hover:text-green-500 focus:outline-none focus:shadow-outline transition ease-in-out duration-150">
                Mettre à jour
              </button>
            </div>
          </div>
          <div class="order-2 flex-shrink-0 sm:order-3 sm:ml-2">
            <button id="close-notification" type="button" class="-mr-1 flex p-2 rounded-md hover:bg-green-500 focus:outline-none focus:bg-green-500 transition ease-in-out duration-150">
              <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  `;
  
  document.body.appendChild(updateNotification);
  
  document.getElementById('update-app').addEventListener('click', () => {
    window.location.reload();
  });
  
  document.getElementById('close-notification').addEventListener('click', () => {
    updateNotification.remove();
  });
}

// Fonction pour afficher une notification de soumission hors ligne
function showOfflineSubmissionNotification() {
  const offlineNotification = document.createElement('div');
  offlineNotification.className = 'fixed bottom-0 inset-x-0 pb-2 sm:pb-5 z-50';
  offlineNotification.innerHTML = `
    <div class="max-w-screen-xl mx-auto px-2 sm:px-6 lg:px-8">
      <div class="p-2 rounded-lg bg-blue-600 shadow-lg sm:p-3">
        <div class="flex items-center justify-between flex-wrap">
          <div class="w-0 flex-1 flex items-center">
            <span class="flex p-2 rounded-lg bg-blue-800">
              <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </span>
            <p class="ml-3 font-medium text-white truncate">
              <span class="md:inline">Votre message a été enregistré et sera envoyé dès que vous serez en ligne.</span>
            </p>
          </div>
          <div class="order-2 flex-shrink-0 sm:order-3 sm:ml-2">
            <button id="close-offline-notification" type="button" class="-mr-1 flex p-2 rounded-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500 transition ease-in-out duration-150">
              <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  `;
  
  document.body.appendChild(offlineNotification);
  
  document.getElementById('close-offline-notification').addEventListener('click', () => {
    offlineNotification.remove();
  });
  
  setTimeout(() => {
    if (document.body.contains(offlineNotification)) {
      offlineNotification.remove();
    }
  }, 5000);
}