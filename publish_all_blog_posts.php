<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\BlogPost;

$updated = 0;

BlogPost::query()->where(function ($q) {
	$q->whereNull('published_at')
	  ->orWhere('published_at', '>', now());
})->chunkById(100, function ($posts) use (&$updated) {
	foreach ($posts as $post) {
		$post->published_at = now();
		$post->is_active = true;
		$post->save();
		$updated++;
	}
});

echo "Mis à jour et publié: {$updated} article(s)\n";


