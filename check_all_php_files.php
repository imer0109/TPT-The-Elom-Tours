<?php

// Afficher les erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Vérification de la syntaxe de tous les fichiers PHP...\n";

// Fonction récursive pour parcourir les répertoires
function checkDirectory($dir) {
    $files = scandir($dir);
    
    foreach ($files as $file) {
        // Ignorer les répertoires . et ..
        if ($file === '.' || $file === '..') {
            continue;
        }
        
        $path = $dir . '/' . $file;
        
        if (is_dir($path)) {
            // Récursion pour les sous-répertoires
            checkDirectory($path);
        } elseif (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
            // Vérifier la syntaxe des fichiers PHP
            $command = sprintf('php -l "%s" 2>&1', $path);
            $output = shell_exec($command);
            
            // Si le résultat ne contient pas "No syntax errors", c'est qu'il y a une erreur
            if (strpos($output, 'No syntax errors') === false) {
                echo "\nERREUR dans $path:\n";
                echo $output . "\n";
                
                // Afficher les 10 premières lignes du fichier
                echo "Début du fichier:\n";
                $content = file_get_contents($path);
                $lines = explode("\n", $content);
                for ($i = 0; $i < min(20, count($lines)); $i++) {
                    $lineNumber = $i + 1;
                    echo "$lineNumber: " . $lines[$i] . "\n";
                }
            }
        }
    }
}

// Commencer la vérification à partir du répertoire racine
checkDirectory(__DIR__);

echo "\nVérification terminée.\n";