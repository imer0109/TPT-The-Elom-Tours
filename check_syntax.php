<?php

// Afficher les erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Répertoire des migrations
$migrationsDir = __DIR__ . '/database/migrations/';

echo "Vérification de la syntaxe des fichiers de migration...\n";

// Parcourir tous les fichiers de migration
$files = scandir($migrationsDir);
foreach ($files as $file) {
    // Ignorer les répertoires . et ..
    if ($file === '.' || $file === '..') {
        continue;
    }
    
    // Vérifier uniquement les fichiers PHP
    if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
        $filePath = $migrationsDir . $file;
        
        // Exécuter php -l pour vérifier la syntaxe
        $command = sprintf('php -l "%s"', $filePath);
        echo "\nVérification de $file:\n";
        $output = shell_exec($command);
        
        echo $output;
        
        // Lire le contenu du fichier pour rechercher des erreurs spécifiques
        $content = file_get_contents($filePath);
        
        // Rechercher des erreurs de syntaxe courantes
        if (preg_match('/class.*Migration.*public/', $content)) {
            echo "ATTENTION: Le fichier $file contient 'public' après 'class Migration', ce qui peut causer une erreur de syntaxe.\n";
            echo "Extrait du code:\n";
            
            // Afficher les lignes pertinentes
            $lines = explode("\n", $content);
            foreach ($lines as $i => $line) {
                if (strpos($line, 'class') !== false && strpos($line, 'Migration') !== false) {
                    $lineNumber = $i + 1;
                    echo "Ligne $lineNumber: $line\n";
                }
            }
        }
    }
}

echo "\nVérification terminée.\n";