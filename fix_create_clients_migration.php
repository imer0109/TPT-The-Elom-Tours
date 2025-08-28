<?php

// Afficher les erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Recherche du fichier de migration pour la table clients...\n";

// Répertoire des migrations
$migrationsDir = __DIR__ . '/database/migrations/';

// Obtenir la liste des fichiers de migration
$files = glob($migrationsDir . '*_create_clients_table.php');

if (empty($files)) {
    echo "Aucun fichier de migration pour la table clients trouvé.\n";
    echo "Recherche de tous les fichiers de migration récents...\n";
    
    // Obtenir tous les fichiers de migration
    $allFiles = glob($migrationsDir . '*.php');
    
    // Trier par date de modification (les plus récents d'abord)
    $filesByDate = [];
    foreach ($allFiles as $file) {
        $filesByDate[$file] = filemtime($file);
    }
    arsort($filesByDate);
    
    // Vérifier les 5 fichiers les plus récents
    $count = 0;
    foreach (array_keys($filesByDate) as $file) {
        if ($count >= 5) break;
        $count++;
        
        $fileName = basename($file);
        echo "\nVérification de $fileName:\n";
        
        // Lire le contenu du fichier
        $content = file_get_contents($file);
        
        // Vérifier la syntaxe avec php -l
        $command = sprintf('php -l "%s" 2>&1', $file);
        $output = shell_exec($command);
        echo $output;
        
        // Si le fichier contient une erreur, afficher et corriger
        if (strpos($output, 'No syntax errors') === false) {
            echo "\nErreur de syntaxe détectée dans $fileName.\n";
            echo "Contenu du fichier:\n";
            echo $content . "\n";
            
            // Corriger l'erreur de syntaxe courante: class Migration public function
            if (preg_match('/class\s+[^{]*\s+public\s+function/', $content)) {
                $correctedContent = preg_replace(
                    '/(class\s+[^{]*)\s+public\s+function/',
                    "$1\n{\n    public function",
                    $content
                );
                
                // Sauvegarder le fichier corrigé
                file_put_contents($file, $correctedContent);
                
                echo "\nFichier corrigé. Nouveau contenu:\n";
                echo $correctedContent . "\n";
            }
        }
    }
} else {
    // Traiter les fichiers de migration pour clients
    foreach ($files as $file) {
        $fileName = basename($file);
        echo "\nTraitement de $fileName:\n";
        
        // Lire le contenu du fichier
        $content = file_get_contents($file);
        
        // Vérifier la syntaxe avec php -l
        $command = sprintf('php -l "%s" 2>&1', $file);
        $output = shell_exec($command);
        echo $output;
        
        // Si le fichier contient une erreur, afficher et corriger
        if (strpos($output, 'No syntax errors') === false) {
            echo "\nErreur de syntaxe détectée dans $fileName.\n";
            
            // Corriger l'erreur de syntaxe courante: class Migration public function
            if (preg_match('/class\s+[^{]*\s+public\s+function/', $content)) {
                $correctedContent = preg_replace(
                    '/(class\s+[^{]*)\s+public\s+function/',
                    "$1\n{\n    public function",
                    $content
                );
                
                // Sauvegarder le fichier corrigé
                file_put_contents($file, $correctedContent);
                
                echo "\nFichier corrigé.\n";
            }
        }
    }
}

echo "\nTraitement terminé.\n";