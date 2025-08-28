<?php

// Afficher les erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Recherche et correction de l'erreur 'syntax error, unexpected token "public"'...\n";

// Fonction pour vérifier et corriger un fichier
function checkAndFixFile($filePath) {
    $fileName = basename($filePath);
    echo "Vérification de $fileName...\n";
    
    // Lire le contenu du fichier
    $content = file_get_contents($filePath);
    
    // Vérifier si le fichier contient l'erreur de syntaxe
    if (preg_match('/class[^{]*extends Migration public/', $content)) {
        echo "ERREUR TROUVÉE dans $fileName!\n";
        
        // Corriger l'erreur
        $correctedContent = preg_replace(
            '/(class[^{]*extends Migration)\s+public/',
            "$1\n{\n    public",
            $content
        );
        
        // Sauvegarder le fichier corrigé
        file_put_contents($filePath, $correctedContent);
        
        echo "Fichier corrigé avec succès.\n";
        return true;
    }
    
    return false;
}

// Répertoires à vérifier
$directories = [
    __DIR__ . '/database/migrations/',
    __DIR__ . '/app/Http/Controllers/',
    __DIR__ . '/app/Models/'
];

$fixedAny = false;

// Parcourir les répertoires
foreach ($directories as $directory) {
    echo "\nVérification des fichiers dans $directory...\n";
    
    // Obtenir tous les fichiers PHP
    $files = glob($directory . '*.php');
    
    // Trier par date de modification (les plus récents d'abord)
    $filesByDate = [];
    foreach ($files as $file) {
        $filesByDate[$file] = filemtime($file);
    }
    arsort($filesByDate);
    
    // Vérifier les 10 fichiers les plus récents dans chaque répertoire
    $count = 0;
    foreach (array_keys($filesByDate) as $file) {
        if ($count >= 10) break;
        $count++;
        
        if (checkAndFixFile($file)) {
            $fixedAny = true;
        }
    }
}

if (!$fixedAny) {
    echo "\nAucune erreur de syntaxe trouvée dans les fichiers vérifiés.\n";
    echo "Vérification des fichiers créés manuellement...\n";
    
    // Vérifier les fichiers que nous avons créés manuellement
    $manualFiles = [
        __DIR__ . '/create_clients_simple.php',
        __DIR__ . '/fix_clients_table.php'
    ];
    
    foreach ($manualFiles as $file) {
        if (file_exists($file) && checkAndFixFile($file)) {
            $fixedAny = true;
        }
    }
}

echo "\nTraitement terminé.\n";

if (!$fixedAny) {
    echo "Aucune erreur de syntaxe n'a été trouvée et corrigée.\n";
    echo "Vérifiez si l'erreur se trouve dans un autre fichier ou si elle a déjà été corrigée.\n";
}