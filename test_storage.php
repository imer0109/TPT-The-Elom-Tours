<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Vérifier si le dossier existe
$circuitsPath = storage_path('app/public/circuits');
if (!file_exists($circuitsPath)) {
    mkdir($circuitsPath, 0755, true);
    echo "Dossier circuits créé: {$circuitsPath}\n";
} else {
    echo "Le dossier circuits existe déjà: {$circuitsPath}\n";
}

// Vérifier les permissions
echo "Permissions du dossier: " . substr(sprintf('%o', fileperms($circuitsPath)), -4) . "\n";

// Tester l'écriture d'un fichier
$testFile = $circuitsPath . '/test_image.txt';
if (file_put_contents($testFile, 'Test de fichier')) {
    echo "Fichier test créé avec succès: {$testFile}\n";
} else {
    echo "Impossible de créer le fichier test: {$testFile}\n";
}

// Vérifier le lien symbolique
$publicStoragePath = public_path('storage');
if (is_link($publicStoragePath)) {
    echo "Le lien symbolique existe: {$publicStoragePath}\n";
    echo "Cible du lien: " . readlink($publicStoragePath) . "\n";
} else {
    echo "Le lien symbolique n'existe pas: {$publicStoragePath}\n";
}

// Vérifier si le fichier est accessible via le lien symbolique
$linkedTestFile = $publicStoragePath . '/circuits/test_image.txt';
if (file_exists($linkedTestFile)) {
    echo "Le fichier test est accessible via le lien symbolique: {$linkedTestFile}\n";
} else {
    echo "Le fichier test n'est pas accessible via le lien symbolique: {$linkedTestFile}\n";
}