<?php

// Afficher les erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Répertoire des migrations
$migrationsDir = __DIR__ . '/database/migrations/';

echo "Recherche du fichier avec l'erreur de syntaxe...\n";

// Parcourir tous les fichiers de migration
$files = glob($migrationsDir . '*.php');

foreach ($files as $filePath) {
    $fileName = basename($filePath);
    echo "\nAnalyse de $fileName:\n";
    
    // Lire le contenu du fichier
    $content = file_get_contents($filePath);
    
    // Vérifier si le fichier contient 'public function' après 'class'
    if (preg_match('/class[^{]*public\s+function/', $content)) {
        echo "TROUVÉ: Le fichier $fileName contient 'public function' après 'class', ce qui peut causer une erreur.\n";
        
        // Afficher les 10 premières lignes du fichier
        echo "Début du fichier:\n";
        $lines = explode("\n", $content);
        for ($i = 0; $i < min(20, count($lines)); $i++) {
            $lineNumber = $i + 1;
            echo "$lineNumber: " . $lines[$i] . "\n";
        }
        
        echo "\n";
    }
}

echo "\nRecherche terminée.\n";