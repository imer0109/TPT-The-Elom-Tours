<?php

// Afficher les erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Vérification des fichiers de migration récents...\n";

// Répertoire des migrations
$migrationsDir = __DIR__ . '/database/migrations/';

// Obtenir la liste des fichiers de migration
$files = glob($migrationsDir . '*.php');

// Trier les fichiers par date de modification (les plus récents d'abord)
$filesByDate = [];
foreach ($files as $file) {
    $filesByDate[$file] = filemtime($file);
}
arsort($filesByDate);

// Vérifier les 10 fichiers les plus récents
$count = 0;
foreach (array_keys($filesByDate) as $file) {
    if ($count >= 10) break;
    $count++;
    
    $fileName = basename($file);
    echo "\nVérification de $fileName:\n";
    
    // Exécuter php -l pour vérifier la syntaxe
    $command = sprintf('php -l "%s" 2>&1', $file);
    $output = shell_exec($command);
    echo $output;
    
    // Si le fichier contient une erreur, afficher son contenu
    if (strpos($output, 'No syntax errors') === false) {
        echo "\nContenu du fichier $fileName:\n";
        $content = file_get_contents($file);
        echo $content . "\n";
    }
}

echo "\nVérification terminée.\n";