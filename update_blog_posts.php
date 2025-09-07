<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\BlogPost;

// Mettre à jour les dates de publication pour qu'elles soient dans le passé
$posts = BlogPost::all();
$updated = 0;

foreach ($posts as $post) {
    // Définir la date de publication à aujourd'hui
    $post->published_at = now();
    $post->save();
    $updated++;
    
    echo "Article mis à jour: {$post->title} - Date de publication: {$post->published_at->format('Y-m-d H:i:s')}\n";
}

echo "\nNombre d'articles mis à jour: {$updated}\n";

// Vérifier les articles publiés après la mise à jour
$publishedCount = BlogPost::published()->count();
echo "Nombre d'articles publiés après mise à jour: {$publishedCount}\n";