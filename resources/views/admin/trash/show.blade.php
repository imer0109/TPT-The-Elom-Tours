@extends('admin.layouts.app')

@php
use Illuminate\Support\Str;
@endphp

@section('title')
CORBEILLE - {{ $modelName }} - THE ELOM TOURS
@endsection

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 flex items-center gap-2">
                <i class="fas fa-trash-alt text-red-500"></i>
                Corbeille - {{ $modelName }}
            </h1>
            <p class="text-sm text-gray-500 mt-1">Éléments supprimés de {{ $modelName }}</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.trash.index') }}" class="inline-flex items-center gap-2 rounded-md bg-gray-100 px-3 py-2 text-sm font-semibold text-gray-800 hover:bg-gray-200">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
            @if($items->count() > 0)
            <form action="{{ route('admin.trash.restore-all-model', $model) }}" method="POST" onsubmit="return confirm('Restaurer tous les éléments de {{ $modelName }} ?');">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white hover:bg-green-700">
                    <i class="fas fa-undo"></i> Restaurer tout
                </button>
            </form>
            <form action="{{ route('admin.trash.empty-model', $model) }}" method="POST" onsubmit="return confirm('Vider définitivement la corbeille de {{ $modelName }} ? Cette action est irréversible.');">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-700">
                    <i class="fas fa-trash"></i> Vider
                </button>
            </form>
            @endif
        </div>
    </div>

    @if($items->count() > 0)
    <div class="mb-4">
        <div class="rounded-md bg-teal-50 p-4 border border-teal-200">
            <div class="flex">
                <div class="flex-shrink-0 text-teal-600">
                    <i class="fas fa-list"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-teal-800">
                        {{ $items->total() }} {{ $items->total() > 1 ? 'éléments' : 'élément' }} supprimé{{ $items->total() > 1 ? 's' : '' }} dans {{ $modelName }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Tableau des éléments -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-4">
            @if($items->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">
                                    <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Élément</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Supprimé le</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Supprimé par</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($items as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        <input type="checkbox" class="item-checkbox rounded border-gray-300 text-green-600 focus:ring-green-500" value="{{ $item->id }}">
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-start gap-3">
                                            <div class="text-gray-400">
                                                @php
                                                    $icons = [
                                                        'circuits' => 'route',
                                                        'destinations' => 'map-marker-alt',
                                                        'blog-posts' => 'blog',
                                                        'reservations' => 'calendar-check',
                                                        'clients' => 'users',
                                                        'comments' => 'comments',
                                                        'reviews' => 'star',
                                                        'categories' => 'tags',
                                                        'paiements' => 'credit-card',
                                                        'settings' => 'cog',
                                                        'users' => 'user',
                                                    ];
                                                    $icon = $icons[$model] ?? 'file';
                                                @endphp
                                                <i class="fas fa-{{ $icon }}"></i>
                                            </div>
                                            <div>
                                                @php
                                                    $itemName = '';
                                                    switch ($model) {
                                                        case 'circuits':
                                                            $itemName = $item->titre ?? 'Circuit #' . $item->id;
                                                            break;
                                                        case 'destinations':
                                                            $itemName = $item->name ?? 'Destination #' . $item->id;
                                                            break;
                                                        case 'blog-posts':
                                                            $itemName = $item->title ?? 'Article #' . $item->id;
                                                            break;
                                                        case 'reservations':
                                                            $itemName = 'Réservation #' . $item->id;
                                                            break;
                                                        case 'clients':
                                                            $itemName = ($item->nom ?? '') . ' ' . ($item->prenom ?? '') ?: 'Client #' . $item->id;
                                                            break;
                                                        case 'comments':
                                                            $itemName = 'Commentaire #' . $item->id;
                                                            break;
                                                        case 'reviews':
                                                            $itemName = 'Avis #' . $item->id;
                                                            break;
                                                        case 'categories':
                                                            $itemName = $item->name ?? 'Catégorie #' . $item->id;
                                                            break;
                                                        case 'paiements':
                                                            $itemName = 'Paiement #' . $item->id;
                                                            break;
                                                        case 'settings':
                                                            $itemName = $item->key ?? 'Paramètre #' . $item->id;
                                                            break;
                                                        case 'users':
                                                            $itemName = $item->name ?? 'Utilisateur #' . $item->id;
                                                            break;
                                                        default:
                                                            $itemName = 'Élément #' . $item->id;
                                                    }
                                                @endphp
                                                <p class="text-sm font-medium text-gray-900">{{ $itemName }}</p>
                                                @php
                                                    $description = '';
                                                    switch ($model) {
                                                        case 'circuits':
                                                            $description = Str::limit($item->description ?? '', 50);
                                                            break;
                                                        case 'destinations':
                                                            $description = Str::limit($item->description ?? '', 50);
                                                            break;
                                                        case 'blog-posts':
                                                            $description = Str::limit($item->excerpt ?? '', 50);
                                                            break;
                                                        case 'reservations':
                                                            $description = 'Référence: ' . ($item->reference ?? $item->id);
                                                            break;
                                                        case 'clients':
                                                            $description = $item->email ?? 'Client';
                                                            break;
                                                        case 'comments':
                                                            $description = Str::limit($item->comment ?? '', 50);
                                                            break;
                                                        case 'reviews':
                                                            $description = Str::limit($item->comment ?? '', 50);
                                                            break;
                                                        case 'categories':
                                                            $description = Str::limit($item->description ?? '', 50);
                                                            break;
                                                        case 'paiements':
                                                            $description = 'Montant: ' . number_format($item->montant ?? 0) . ' FCFA';
                                                            break;
                                                        case 'settings':
                                                            $description = 'Valeur: ' . Str::limit($item->value ?? '', 30);
                                                            break;
                                                        case 'users':
                                                            $description = $item->email ?? 'Utilisateur';
                                                            break;
                                                        default:
                                                            $description = 'Élément supprimé';
                                                    }
                                                @endphp
                                                <p class="text-sm text-gray-500">{{ $description }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">{{ $item->deleted_at->format('d/m/Y à H:i') }}</span>
                                        <div class="text-xs text-gray-500 mt-1">{{ $item->deleted_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        @if($item->deletedBy)
                                            <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                                                <i class="fas fa-user mr-1"></i>
                                                {{ $item->deletedBy->name }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">
                                                <i class="fas fa-robot mr-1"></i>
                                                Système
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <form action="{{ route('admin.trash.restore', [$model, $item->id]) }}" method="POST" onsubmit="return confirm('Restaurer cet élément ?');">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center gap-1 rounded-md bg-green-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-green-700">
                                                    <i class="fas fa-undo"></i> Restaurer
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.trash.force-delete', [$model, $item->id]) }}" method="POST" onsubmit="return confirm('Supprimer définitivement cet élément ? Cette action est irréversible.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-1 rounded-md bg-red-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-700">
                                                    <i class="fas fa-trash"></i> Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex justify-center">
                    {{ $items->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-16 bg-white rounded-lg">
                    <div class="mb-4 text-gray-300">
                        <i class="fas fa-trash-alt text-5xl"></i>
                    </div>
                    <h3 class="text-gray-700 text-lg font-semibold mb-2">Aucun élément supprimé</h3>
                    <p class="text-gray-500 mb-4">Aucun élément de {{ $modelName }} n'est actuellement dans la corbeille.</p>
                    <div class="inline-flex items-center gap-2 text-sm text-blue-700 bg-blue-50 border border-blue-200 rounded px-3 py-2">
                        <i class="fas fa-info-circle"></i>
                        Les éléments supprimés de {{ $modelName }} apparaîtront ici.
                    </div>
                </div>
            @endif
        </div>
    </div>
    </div>
@endsection

@push('scripts')
<script>
    const selectAll = document.getElementById('selectAll');
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = this.checked);
        });
    }
</script>
@endpush
