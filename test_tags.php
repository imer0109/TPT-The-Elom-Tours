<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Tag;

// Créer un tag de test
$tag = Tag::create([
    'name' => 'Test Tag ' . time(),
]);

echo "Tag créé avec l'ID: {$tag->id}\n";

// Compter les tags
$count = Tag::count();
echo "Nombre total de tags: {$count}\n";

// Lister tous les tags
echo "Liste des tags:\n";
foreach (Tag::all() as $tag) {
    echo "- {$tag->name} (slug: {$tag->slug})\n";
}