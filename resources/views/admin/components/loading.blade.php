<div id="loading-overlay" 
     x-data="{ show: false, message: 'Chargement en cours...' }" 
     x-show="show"
     x-cloak
     @loading.window="
        show = true; 
        message = $event.detail.message || 'Chargement en cours...'; 
        if ($event.detail.duration) {
            setTimeout(() => { show = false }, $event.detail.duration);
        }
     "
     @loading-done.window="show = false"
     class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    
    <div class="bg-white p-6 rounded-lg shadow-xl max-w-sm w-full">
        <div class="flex flex-col items-center">
            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-primary mb-4"></div>
            <p class="text-gray-700 text-center" x-text="message"></p>
        </div>
    </div>
</div>

<script>
    function showLoading(message = 'Chargement en cours...', duration = null) {
        window.dispatchEvent(new CustomEvent('loading', {
            detail: {
                message: message,
                duration: duration
            }
        }));
    }
    
    function hideLoading() {
        window.dispatchEvent(new CustomEvent('loading-done'));
    }
</script>