<?php

// Afficher les erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Recherche et correction des erreurs de syntaxe dans les fichiers de migration...\n";

// Répertoire des migrations
$migrationsDir = __DIR__ . '/database/migrations/';

// Obtenir la liste des fichiers de migration
$files = glob($migrationsDir . '*.php');

// Parcourir tous les fichiers
foreach ($files as $file) {
    $fileName = basename($file);
    
    // Lire le contenu du fichier
    $content = file_get_contents($file);
    
    // Rechercher le modèle problématique: class Migration public
    if (preg_match('/class\s+[^{]*\s+public\s+function/', $content)) {
        echo "\nProblème trouvé dans $fileName:\n";
        
        // Afficher les lignes problématiques
        $lines = explode("\n", $content);
        $problemLine = null;
        
        foreach ($lines as $i => $line) {
            if (preg_match('/class\s+[^{]*\s+public\s+function/', $line)) {
                $lineNumber = $i + 1;
                echo "Ligne $lineNumber: $line\n";
                $problemLine = $i;
            }
        }
        
        if ($problemLine !== null) {
            // Corriger la ligne problématique
            // Remplacer "class Migration public function" par "class Migration\n{\n    public function"
            $correctedLine = preg_replace(
                '/(class\s+[^{]*)\s+public\s+function/',
                "$1\n{\n    public function",
                $lines[$problemLine]
            );
            
            $lines[$problemLine] = $correctedLine;
            $correctedContent = implode("\n", $lines);
            
            // Sauvegarder le fichier corrigé
            file_put_contents($file, $correctedContent);
            
            echo "Fichier corrigé.\n";
            echo "Nouvelle ligne: $correctedLine\n";
        }
    }
}

echo "\nRecherche et correction terminées.\n";