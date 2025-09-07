<?php

try {
    $pdo = new PDO(
        'mysql:host=127.0.0.1;dbname=theElomTours;charset=utf8mb4',
        'root',
        '',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );

    // Vérifier si la table blog_posts existe
    $stmt = $pdo->query("SHOW TABLES LIKE 'blog_posts'");
    $blogPostsExists = $stmt->rowCount() > 0;
    echo "Table blog_posts existe: " . ($blogPostsExists ? 'Oui' : 'Non') . "\n";
    
    if ($blogPostsExists) {
        // Vérifier la structure de la table blog_posts
        $stmt = $pdo->query("DESCRIBE blog_posts");
        echo "Structure de la table blog_posts:\n";
        while ($row = $stmt->fetch()) {
            echo "- {$row['Field']}: {$row['Type']}" . ($row['Key'] ? " (Key: {$row['Key']})" : "") . "\n";
        }
    }
    
    // Vérifier si la table tags existe
    $stmt = $pdo->query("SHOW TABLES LIKE 'tags'");
    $tagsExists = $stmt->rowCount() > 0;
    echo "\nTable tags existe: " . ($tagsExists ? 'Oui' : 'Non') . "\n";
    
    if ($tagsExists) {
        // Vérifier la structure de la table tags
        $stmt = $pdo->query("DESCRIBE tags");
        echo "Structure de la table tags:\n";
        while ($row = $stmt->fetch()) {
            echo "- {$row['Field']}: {$row['Type']}" . ($row['Key'] ? " (Key: {$row['Key']})" : "") . "\n";
        }
    }
    
    // Vérifier si la table circuit_images existe
    $stmt = $pdo->query("SHOW TABLES LIKE 'circuit_images'");
    $circuitImagesExists = $stmt->rowCount() > 0;
    echo "\nTable circuit_images existe: " . ($circuitImagesExists ? 'Oui' : 'Non') . "\n";
    
    if ($circuitImagesExists) {
        // Vérifier la structure de la table circuit_images
        $stmt = $pdo->query("DESCRIBE circuit_images");
        echo "Structure de la table circuit_images:\n";
        while ($row = $stmt->fetch()) {
            echo "- {$row['Field']}: {$row['Type']}" . ($row['Key'] ? " (Key: {$row['Key']})" : "") . "\n";
        }
    }
    
} catch (PDOException $e) {
    echo "Erreur: " . $e->getMessage() . "\n";
}