<?php

// Afficher les erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Vérification et correction de tous les fichiers de migration...\n";

// Répertoire des migrations
$migrationsDir = __DIR__ . '/database/migrations/';

// Obtenir la liste des fichiers de migration
$files = glob($migrationsDir . '*.php');

$fixedCount = 0;

// Parcourir tous les fichiers
foreach ($files as $file) {
    $fileName = basename($file);
    echo "\nVérification de $fileName:\n";
    
    // Lire le contenu du fichier
    $content = file_get_contents($file);
    
    // Rechercher différentes formes d'erreurs de syntaxe
    $patterns = [
        '/class\s+[^{]*extends\s+Migration\s+public/',  // class X extends Migration public
        '/return\s+new\s+class\s+extends\s+Migration\s+public/',  // return new class extends Migration public
        '/class\s+[^{]*\s+public\s+function/',  // class X public function
        '/return\s+new\s+class[^{]*\s+public\s+function/'  // return new class public function
    ];
    
    $needsFix = false;
    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $content)) {
            $needsFix = true;
            break;
        }
    }
    
    if ($needsFix) {
        echo "Erreur de syntaxe détectée dans $fileName.\n";
        
        // Corriger les différentes formes d'erreurs
        $correctedContent = $content;
        
        // Correction pour "class X extends Migration public"
        $correctedContent = preg_replace(
            '/(class\s+[^{]*extends\s+Migration)\s+public/',
            "$1\n{\n    public",
            $correctedContent
        );
        
        // Correction pour "return new class extends Migration public"
        $correctedContent = preg_replace(
            '/(return\s+new\s+class\s+extends\s+Migration)\s+public/',
            "$1\n{\n    public",
            $correctedContent
        );
        
        // Correction pour "class X public function"
        $correctedContent = preg_replace(
            '/(class\s+[^{]*)\s+public\s+function/',
            "$1\n{\n    public function",
            $correctedContent
        );
        
        // Correction pour "return new class public function"
        $correctedContent = preg_replace(
            '/(return\s+new\s+class[^{]*)\s+public\s+function/',
            "$1\n{\n    public function",
            $correctedContent
        );
        
        // Sauvegarder le fichier corrigé
        file_put_contents($file, $correctedContent);
        
        echo "Fichier corrigé.\n";
        $fixedCount++;
    } else {
        echo "Aucune erreur de syntaxe détectée.\n";
    }
}

echo "\nTraitement terminé. $fixedCount fichiers ont été corrigés.\n";

if ($fixedCount > 0) {
    echo "Exécutez 'php artisan migrate' pour appliquer les migrations corrigées.\n";
} else {
    echo "Aucun fichier n'a été corrigé. Si l'erreur persiste, vérifiez d'autres fichiers PHP dans le projet.\n";
}