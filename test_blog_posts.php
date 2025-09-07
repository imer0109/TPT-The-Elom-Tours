<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\BlogPost;
use App\Models\Category;

// Compter tous les articles de blog
$totalCount = BlogPost::count();
echo "Nombre total d'articles de blog: {$totalCount}\n";

// Compter les articles publiés
$publishedCount = BlogPost::published()->count();
echo "Nombre d'articles publiés: {$publishedCount}\n";

// Compter les articles actifs
$activeCount = BlogPost::active()->count();
echo "Nombre d'articles actifs: {$activeCount}\n";

// Vérifier les catégories
$categoriesCount = Category::count();
echo "Nombre de catégories: {$categoriesCount}\n";

// Lister les articles de blog
echo "\nListe des articles de blog:\n";
$posts = BlogPost::all();
foreach ($posts as $post) {
    $status = $post->is_active ? 'Actif' : 'Inactif';
    $published = $post->published_at ? 'Publié le ' . $post->published_at->format('Y-m-d') : 'Non publié';
    echo "- {$post->title} ({$status}, {$published})\n";
}

// Vérifier si la table blog_posts existe
echo "\nVérification de la structure de la base de données:\n";
$tableExists = \Illuminate\Support\Facades\Schema::hasTable('blog_posts');
echo "Table blog_posts existe: " . ($tableExists ? 'Oui' : 'Non') . "\n";

// Vérifier les colonnes de la table blog_posts
if ($tableExists) {
    $columns = \Illuminate\Support\Facades\Schema::getColumnListing('blog_posts');
    echo "Colonnes de la table blog_posts: " . implode(', ', $columns) . "\n";
}