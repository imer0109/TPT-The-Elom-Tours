@extends('layouts.admin')

@section('title', 'Messages - The Elom Tours')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Messages de contact</h1>
    </div>
    
    <!-- Filtres et recherche -->
    <form action="{{ route('admin.messages.index') }}" method="GET" class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-4">
                <!-- Filtre par statut -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select id="status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                        <option value="">Tous les statuts</option>
                        <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Non lu</option>
                        <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Lu</option>
                        <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archivé</option>
                    </select>
                </div>
                
                <!-- Filtre par date -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" id="date" name="date" value="{{ request('date') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5">
                </div>
            </div>
            
            <!-- Recherche -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="search" name="search" value="{{ request('search') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full pl-10 p-2.5" placeholder="Rechercher un message...">
            </div>
        </div>
        <div class="mt-4 flex justify-end">
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-green-700 transition-colors">
                <i class="fas fa-filter mr-2"></i>Filtrer
            </button>
        </div>
    </form>
    
    <!-- Liste des messages -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                <input id="checkbox-all" type="checkbox" class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary">
                                <label for="checkbox-all" class="sr-only">Sélectionner tout</label>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Expéditeur
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Sujet
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($messages as $message)
                    <tr class="hover-effect {{ !$message->is_read ? 'bg-blue-50' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <input id="checkbox-{{ $message->id }}" type="checkbox" name="message_ids[]" value="{{ $message->id }}" class="message-checkbox w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary">
                                <label for="checkbox-{{ $message->id }}" class="sr-only">Sélectionner</label>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if (!$message->is_read)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <span class="w-2 h-2 mr-1 bg-blue-500 rounded-full"></span>
                                    Non lu
                                </span>
                            @elseif ($message->is_archived)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <span class="w-2 h-2 mr-1 bg-gray-500 rounded-full"></span>
                                    Archivé
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <span class="w-2 h-2 mr-1 bg-gray-500 rounded-full"></span>
                                    Lu
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $message->name }}</div>
                            <div class="text-sm text-gray-500">{{ $message->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm {{ !$message->is_read ? 'font-semibold' : '' }} text-gray-900">{{ $message->subject }}</div>
                            <div class="text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($message->message, 80) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $message->created_at->format('d/m/Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.messages.show', $message) }}" class="text-primary hover:text-green-700 mr-3"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('admin.messages.show', $message) }}#reply" class="text-blue-600 hover:text-blue-800 mr-3"><i class="fas fa-reply"></i></a>
                            <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Aucun message trouvé
                        </td>
                    </tr>
                    @endforelse
                    
                    <!-- Fin des messages -->
                </tbody>
            </table>
        </div>
        
        <!-- Actions groupées et pagination -->
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <form action="{{ route('admin.messages.bulk-action') }}" method="POST" id="bulk-action-form" class="flex items-center space-x-2 mb-4 sm:mb-0">
                    @csrf
                    <select id="bulk-action" name="action" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary p-2">
                        <option value="">Actions groupées</option>
                        <option value="mark-read">Marquer comme lu</option>
                        <option value="mark-unread">Marquer comme non lu</option>
                        <option value="archive">Archiver</option>
                        <option value="unarchive">Désarchiver</option>
                        <option value="delete">Supprimer</option>
                    </select>
                    <button type="submit" class="px-3 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition-colors">
                        Appliquer
                    </button>
                </form>
                
                <div>
                    {{ $messages->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion de la sélection de tous les messages
        const checkboxAll = document.getElementById('checkbox-all');
        const checkboxes = document.querySelectorAll('.message-checkbox');
        
        checkboxAll.addEventListener('change', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = checkboxAll.checked;
            });
        });
        
        // Mise à jour du checkbox principal lorsque les checkboxes individuels changent
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const allChecked = Array.from(checkboxes).every(c => c.checked);
                const someChecked = Array.from(checkboxes).some(c => c.checked);
                
                checkboxAll.checked = allChecked;
                checkboxAll.indeterminate = someChecked && !allChecked;
            });
        });
        
        // Validation du formulaire d'action en masse
        document.getElementById('bulk-action-form').addEventListener('submit', function(e) {
            const checkboxes = document.querySelectorAll('.message-checkbox:checked');
            const action = document.getElementById('bulk-action').value;
            
            if (checkboxes.length === 0) {
                e.preventDefault();
                alert('Veuillez sélectionner au moins un message.');
                return false;
            }
            
            if (action === '') {
                e.preventDefault();
                alert('Veuillez sélectionner une action.');
                return false;
            }
            
            if (action === 'delete' && !confirm('Êtes-vous sûr de vouloir supprimer les messages sélectionnés ?')) {
                e.preventDefault();
                return false;
            }
            
            return true;
        });
    });
</script>
@endsection