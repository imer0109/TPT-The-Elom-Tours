<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\BlogPost;

$affected = BlogPost::query()
    ->where(function ($q) {
        $q->whereNull('published_at')
          ->orWhere('published_at', '>', now());
    })
    ->update([
        'published_at' => now(),
        'is_active' => true,
    ]);

echo "Mis à jour: {$affected}\n";


