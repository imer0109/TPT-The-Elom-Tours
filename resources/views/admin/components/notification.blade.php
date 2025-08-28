<div id="notification-component" 
     x-data="{ show: false, message: '', type: 'success' }" 
     x-show="show" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform translate-y-2"
     x-transition:enter-end="opacity-100 transform translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 transform translate-y-0"
     x-transition:leave-end="opacity-0 transform translate-y-2"
     @notification.window="
        show = true; 
        message = $event.detail.message; 
        type = $event.detail.type || 'success';
        setTimeout(() => { show = false }, $event.detail.duration || 5000);
     "
     class="fixed top-4 right-4 z-50 max-w-md shadow-lg rounded-lg overflow-hidden">
    
    <template x-if="type === 'success'">
        <div class="bg-green-50 border-l-4 border-green-500 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-800" x-text="message"></p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button @click="show = false" class="inline-flex text-green-500 hover:text-green-700 focus:outline-none">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
    
    <template x-if="type === 'error'">
        <div class="bg-red-50 border-l-4 border-red-500 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-800" x-text="message"></p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button @click="show = false" class="inline-flex text-red-500 hover:text-red-700 focus:outline-none">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
    
    <template x-if="type === 'warning'">
        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-800" x-text="message"></p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button @click="show = false" class="inline-flex text-yellow-500 hover:text-yellow-700 focus:outline-none">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
    
    <template x-if="type === 'info'">
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-800" x-text="message"></p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button @click="show = false" class="inline-flex text-blue-500 hover:text-blue-700 focus:outline-none">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>

<script>
    function showNotification(message, type = 'success', duration = 5000) {
        window.dispatchEvent(new CustomEvent('notification', {
            detail: {
                message: message,
                type: type,
                duration: duration
            }
        }));
    }
</script>