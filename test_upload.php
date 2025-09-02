<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\Storage;

// Initialiser l'application Laravel pour pouvoir utiliser les facades
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Test d'upload d'image ===\n";

// Vérifier si le dossier storage/app/public/circuits existe
if (!Storage::disk('public')->exists('circuits')) {
    Storage::disk('public')->makeDirectory('circuits');
    echo "Dossier 'circuits' créé dans storage/app/public\n";
} else {
    echo "Le dossier 'circuits' existe déjà dans storage/app/public\n";
}

// Vérifier les permissions du dossier
$circuitsPath = storage_path('app/public/circuits');
echo "Chemin du dossier circuits: {$circuitsPath}\n";
echo "Permissions: " . substr(sprintf('%o', fileperms($circuitsPath)), -4) . "\n";

// Créer une image de test
$testImageContent = 'Test image content';
$testImageName = 'test_' . time() . '.txt';

try {
    // Tenter d'enregistrer un fichier de test
    $success = Storage::disk('public')->put('circuits/' . $testImageName, $testImageContent);
    
    if ($success) {
        echo "Fichier de test créé avec succès: {$testImageName}\n";
        
        // Vérifier si le fichier est accessible via le lien symbolique
        $publicPath = public_path('storage/circuits/' . $testImageName);
        if (file_exists($publicPath)) {
            echo "Le fichier est accessible via le lien symbolique: {$publicPath}\n";
        } else {
            echo "ERREUR: Le fichier n'est pas accessible via le lien symbolique\n";
            echo "Chemin public attendu: {$publicPath}\n";
            
            // Vérifier si le lien symbolique existe
            $linkPath = public_path('storage');
            if (is_link($linkPath)) {
                echo "Le lien symbolique existe et pointe vers: " . readlink($linkPath) . "\n";
            } else {
                echo "Le lien symbolique n'existe pas\n";
            }
        }
    } else {
        echo "ERREUR: Impossible de créer le fichier de test\n";
    }
} catch (\Exception $e) {
    echo "ERREUR: " . $e->getMessage() . "\n";
}

// Tester l'upload d'un fichier comme dans le contrôleur
echo "\n=== Test de la méthode storeAs ===\n";

// Créer un fichier temporaire pour simuler un upload
$tempFile = tempnam(sys_get_temp_dir(), 'test_upload');
file_put_contents($tempFile, 'Test upload content');

try {
    // Créer un objet UploadedFile simulé
    $uploadedFile = new \Illuminate\Http\UploadedFile(
        $tempFile,
        'test_upload.txt',
        'text/plain',
        null,
        true
    );
    
    // Tester la méthode storeAs comme dans le contrôleur
    $path = $uploadedFile->storeAs('public/circuits', 'test_controller_' . time() . '.txt');
    
    if ($path) {
        echo "Fichier uploadé avec succès via storeAs: {$path}\n";
        
        // Vérifier si le fichier existe dans le stockage
        if (Storage::exists($path)) {
            echo "Le fichier existe dans le stockage\n";
        } else {
            echo "ERREUR: Le fichier n'existe pas dans le stockage\n";
        }
        
        // Vérifier si le fichier est accessible via le lien symbolique
        $publicPath = public_path('storage/' . str_replace('public/', '', $path));
        if (file_exists($publicPath)) {
            echo "Le fichier est accessible via le lien symbolique: {$publicPath}\n";
        } else {
            echo "ERREUR: Le fichier n'est pas accessible via le lien symbolique\n";
        }
    } else {
        echo "ERREUR: Impossible d'uploader le fichier via storeAs\n";
    }
} catch (\Exception $e) {
    echo "ERREUR: " . $e->getMessage() . "\n";
} finally {
    // Nettoyer le fichier temporaire
    @unlink($tempFile);
}

echo "\n=== Test terminé ===\n";