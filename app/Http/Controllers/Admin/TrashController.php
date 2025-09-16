<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Circuit;
use App\Models\Destination;
use App\Models\BlogPost;
use App\Models\Reservation;
use App\Models\Client;
use App\Models\Comment;
use App\Models\Review;
use App\Models\Categorie;
use App\Models\Paiement;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Services\ActivityLogService;
use Illuminate\Support\Str;

class TrashController extends Controller
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    /**
     * Affiche la page principale de la corbeille
     */
    public function index(): View
    {
        // Vérifier que l'utilisateur est Super Administrateur
        if (!auth()->user()->hasRole('Super Administrateur')) {
            abort(403, 'Accès non autorisé');
        }

        // Compter les éléments supprimés pour chaque modèle
        $trashCounts = [
            'circuits' => Circuit::onlyTrashed()->count(),
            'destinations' => Destination::onlyTrashed()->count(),
            'blog-posts' => BlogPost::onlyTrashed()->count(),
            'reservations' => Reservation::onlyTrashed()->count(),
            'clients' => Client::onlyTrashed()->count(),
            'comments' => Comment::onlyTrashed()->count(),
            'reviews' => Review::onlyTrashed()->count(),
            'categories' => Categorie::onlyTrashed()->count(),
            'paiements' => Paiement::onlyTrashed()->count(),
            'settings' => Setting::onlyTrashed()->count(),
            'users' => User::onlyTrashed()->count(),
        ];

        return view('admin.trash.index', compact('trashCounts'));
    }

    /**
     * Affiche les éléments supprimés d'un modèle spécifique
     */
    public function show(Request $request, string $model): View
    {
        // Vérifier que l'utilisateur est Super Administrateur
        if (!auth()->user()->hasRole('Super Administrateur')) {
            abort(403, 'Accès non autorisé');
        }

        $modelClass = $this->getModelClass($model);
        if (!$modelClass) {
            abort(404, 'Modèle non trouvé');
        }

        $items = $modelClass::onlyTrashed()
            ->with(['deletedBy' => function($query) {
                $query->withTrashed();
            }])
            ->orderBy('deleted_at', 'desc')
            ->paginate(15);

        $modelName = $this->getModelDisplayName($model);

        return view('admin.trash.show', compact('items', 'model', 'modelName'));
    }

    /**
     * Restaure un élément supprimé
     */
    public function restore(Request $request, string $model, string $id): RedirectResponse
    {
        // Vérifier que l'utilisateur est Super Administrateur
        if (!auth()->user()->hasRole('Super Administrateur')) {
            abort(403, 'Accès non autorisé');
        }

        $modelClass = $this->getModelClass($model);
        if (!$modelClass) {
            abort(404, 'Modèle non trouvé');
        }

        $item = $modelClass::onlyTrashed()->findOrFail($id);
        $item->restore();

        // Logger l'activité
        $this->activityLogService->logRestored(
            auth()->user(),
            $modelClass,
            $id,
            "Restauration d'un élément {$this->getModelDisplayName($model)}"
        );

        return redirect()->back()->with('success', 'Élément restauré avec succès.');
    }

    /**
     * Supprime définitivement un élément
     */
    public function forceDelete(Request $request, string $model, string $id): RedirectResponse
    {
        // Vérifier que l'utilisateur est Super Administrateur
        if (!auth()->user()->hasRole('Super Administrateur')) {
            abort(403, 'Accès non autorisé');
        }

        $modelClass = $this->getModelClass($model);
        if (!$modelClass) {
            abort(404, 'Modèle non trouvé');
        }

        $item = $modelClass::onlyTrashed()->findOrFail($id);
        $itemName = $this->getItemName($item, $model);
        
        // Enregistrer l'utilisateur qui supprime définitivement
        $item->deleted_by = auth()->id();
        $item->save();
        
        $item->forceDelete();

        // Logger l'activité
        $this->activityLogService->logForceDeleted(
            auth()->user(),
            $modelClass,
            $id,
            "Suppression définitive d'un élément {$this->getModelDisplayName($model)}: {$itemName}"
        );

        return redirect()->back()->with('success', 'Élément supprimé définitivement.');
    }

    /**
     * Vide complètement la corbeille d'un modèle
     */
    public function empty(Request $request, string $model): RedirectResponse
    {
        // Vérifier que l'utilisateur est Super Administrateur
        if (!auth()->user()->hasRole('Super Administrateur')) {
            abort(403, 'Accès non autorisé');
        }

        $modelClass = $this->getModelClass($model);
        if (!$modelClass) {
            abort(404, 'Modèle non trouvé');
        }

        $count = $modelClass::onlyTrashed()->count();
        
        // Enregistrer l'utilisateur qui vide la corbeille
        $modelClass::onlyTrashed()->update(['deleted_by' => auth()->id()]);
        
        $modelClass::onlyTrashed()->forceDelete();

        // Logger l'activité
        $this->activityLogService->logForceDeleted(
            auth()->user(),
            $modelClass,
            null,
            "Vidage de la corbeille {$this->getModelDisplayName($model)}: {$count} éléments supprimés définitivement"
        );

        return redirect()->back()->with('success', "Corbeille vidée avec succès. {$count} éléments supprimés définitivement.");
    }

    /**
     * Restaure tous les éléments d'un modèle
     */
    public function restoreAll(Request $request, string $model): RedirectResponse
    {
        // Vérifier que l'utilisateur est Super Administrateur
        if (!auth()->user()->hasRole('Super Administrateur')) {
            abort(403, 'Accès non autorisé');
        }

        $modelClass = $this->getModelClass($model);
        if (!$modelClass) {
            abort(404, 'Modèle non trouvé');
        }

        $count = $modelClass::onlyTrashed()->count();
        $modelClass::onlyTrashed()->restore();

        // Logger l'activité
        $this->activityLogService->logRestored(
            auth()->user(),
            $modelClass,
            null,
            "Restauration de tous les éléments {$this->getModelDisplayName($model)}: {$count} éléments restaurés"
        );

        return redirect()->back()->with('success', "Tous les éléments restaurés avec succès. {$count} éléments restaurés.");
    }

    /**
     * Restaure tous les éléments de tous les modèles
     */
    public function restoreAllGlobal(Request $request): RedirectResponse
    {
        // Vérifier que l'utilisateur est Super Administrateur
        if (!auth()->user()->hasRole('Super Administrateur')) {
            abort(403, 'Accès non autorisé');
        }

        $totalRestored = 0;
        $models = [
            'circuits' => Circuit::class,
            'destinations' => Destination::class,
            'blog-posts' => BlogPost::class,
            'reservations' => Reservation::class,
            'clients' => Client::class,
            'comments' => Comment::class,
            'reviews' => Review::class,
            'categories' => Categorie::class,
            'paiements' => Paiement::class,
            'settings' => Setting::class,
            'users' => User::class,
        ];

        foreach ($models as $modelName => $modelClass) {
            $count = $modelClass::onlyTrashed()->count();
            if ($count > 0) {
                $modelClass::onlyTrashed()->restore();
                $totalRestored += $count;
                
                // Logger l'activité
                $this->activityLogService->logRestored(
                    auth()->user(),
                    $modelClass,
                    null,
                    "Restauration globale de tous les éléments {$this->getModelDisplayName($modelName)}: {$count} éléments restaurés"
                );
            }
        }

        return redirect()->back()->with('success', "Restauration globale terminée. {$totalRestored} éléments restaurés.");
    }

    /**
     * Vide complètement toute la corbeille
     */
    public function emptyAllGlobal(Request $request): RedirectResponse
    {
        // Vérifier que l'utilisateur est Super Administrateur
        if (!auth()->user()->hasRole('Super Administrateur')) {
            abort(403, 'Accès non autorisé');
        }

        $totalDeleted = 0;
        $models = [
            'circuits' => Circuit::class,
            'destinations' => Destination::class,
            'blog-posts' => BlogPost::class,
            'reservations' => Reservation::class,
            'clients' => Client::class,
            'comments' => Comment::class,
            'reviews' => Review::class,
            'categories' => Categorie::class,
            'paiements' => Paiement::class,
            'settings' => Setting::class,
            'users' => User::class,
        ];

        foreach ($models as $modelName => $modelClass) {
            $count = $modelClass::onlyTrashed()->count();
            if ($count > 0) {
                // Enregistrer l'utilisateur qui vide la corbeille
                $modelClass::onlyTrashed()->update(['deleted_by' => auth()->id()]);
                
                $modelClass::onlyTrashed()->forceDelete();
                $totalDeleted += $count;
                
                // Logger l'activité
                $this->activityLogService->logForceDeleted(
                    auth()->user(),
                    $modelClass,
                    null,
                    "Vidage global de la corbeille {$this->getModelDisplayName($modelName)}: {$count} éléments supprimés définitivement"
                );
            }
        }

        return redirect()->back()->with('success', "Corbeille vidée complètement. {$totalDeleted} éléments supprimés définitivement.");
    }

    /**
     * Obtient la classe du modèle à partir du nom
     */
    private function getModelClass(string $model): ?string
    {
        // Normaliser le nom reçu: minuscules et remplacer _ par -
        $normalized = strtolower(str_replace('_', '-', $model));

        $models = [
            'circuits' => Circuit::class,
            'destinations' => Destination::class,
            'blog-posts' => BlogPost::class,
            'reservations' => Reservation::class,
            'clients' => Client::class,
            'comments' => Comment::class,
            'reviews' => Review::class,
            'categories' => Categorie::class,
            'paiements' => Paiement::class,
            'settings' => Setting::class,
            'users' => User::class,
        ];

        return $models[$normalized] ?? null;
    }

    /**
     * Obtient le nom d'affichage du modèle
     */
    private function getModelDisplayName(string $model): string
    {
        $names = [
            'circuits' => 'Circuit',
            'destinations' => 'Destination',
            'blog-posts' => 'Article de blog',
            'reservations' => 'Réservation',
            'clients' => 'Client',
            'comments' => 'Commentaire',
            'reviews' => 'Avis',
            'categories' => 'Catégorie',
            'paiements' => 'Paiement',
            'settings' => 'Paramètre',
            'users' => 'Utilisateur',
        ];

        return $names[$model] ?? ucfirst($model);
    }

    /**
     * Obtient le nom d'un élément pour l'affichage
     */
    private function getItemName($item, string $model): string
    {
        switch ($model) {
            case 'circuits':
                return $item->titre ?? 'Circuit #' . $item->id;
            case 'destinations':
                return $item->name ?? 'Destination #' . $item->id;
            case 'blog-posts':
                return $item->title ?? 'Article #' . $item->id;
            case 'reservations':
                return 'Réservation #' . $item->id;
            case 'clients':
                return ($item->nom ?? '') . ' ' . ($item->prenom ?? '') ?: 'Client #' . $item->id;
            case 'comments':
                return 'Commentaire #' . $item->id;
            case 'reviews':
                return 'Avis #' . $item->id;
            case 'categories':
                return $item->name ?? 'Catégorie #' . $item->id;
            case 'paiements':
                return 'Paiement #' . $item->id;
            case 'settings':
                return $item->key ?? 'Paramètre #' . $item->id;
            case 'users':
                return $item->name ?? 'Utilisateur #' . $item->id;
            default:
                return 'Élément #' . $item->id;
        }
    }

    /**
     * Obtient l'icône d'un modèle
     */
    private function getModelIcon(string $model): string
    {
        $icons = [
            'circuits' => 'route',
            'destinations' => 'map-marker-alt',
            'blog_posts' => 'blog',
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

        return $icons[$model] ?? 'file';
    }

    /**
     * Obtient le nom d'affichage d'un élément
     */
    private function getItemDisplayName($item, string $model): string
    {
        return $this->getItemName($item, $model);
    }

    /**
     * Obtient la description d'un élément
     */
    private function getItemDescription($item, string $model): string
    {
        switch ($model) {
            case 'circuits':
                return Str::limit($item->description ?? '', 50);
            case 'destinations':
                return Str::limit($item->description ?? '', 50);
            case 'blog-posts':
                return Str::limit($item->excerpt ?? '', 50);
            case 'reservations':
                return 'Référence: ' . ($item->reference ?? $item->id);
            case 'clients':
                return $item->email ?? 'Client';
            case 'comments':
                return Str::limit($item->content ?? '', 50);
            case 'reviews':
                return Str::limit($item->comment ?? '', 50);
            case 'categories':
                return Str::limit($item->description ?? '', 50);
            case 'paiements':
                return 'Montant: ' . number_format($item->montant ?? 0) . ' FCFA';
            case 'settings':
                return 'Valeur: ' . Str::limit($item->value ?? '', 30);
            case 'users':
                return $item->email ?? 'Utilisateur';
            default:
                return 'Élément supprimé';
        }
    }
}
