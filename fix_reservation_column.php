<?php

try {
    // Connexion directe à MySQL sans passer par Laravel
    $host = '127.0.0.1';
    $db   = 'theElomTours';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    // Vérifier si la colonne 'statut' existe
    $stmt = $pdo->query("SHOW COLUMNS FROM reservations LIKE 'statut'");
    $statutExists = $stmt->fetch() !== false;
    
    // Vérifier si la colonne 'status' existe
    $stmt = $pdo->query("SHOW COLUMNS FROM reservations LIKE 'status'");
    $statusExists = $stmt->fetch() !== false;
    
    echo "État actuel:\n";
    echo "- Colonne 'statut' existe: " . ($statutExists ? "Oui" : "Non") . "\n";
    echo "- Colonne 'status' existe: " . ($statusExists ? "Oui" : "Non") . "\n";
    
    // Si 'statut' existe et 'status' n'existe pas, renommer la colonne
    if ($statutExists && !$statusExists) {
        $pdo->exec("ALTER TABLE reservations CHANGE statut status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending'");
        echo "\nLa colonne 'statut' a été renommée en 'status'.\n";
    } 
    // Si les deux colonnes existent, supprimer 'statut' (cas improbable)
    elseif ($statutExists && $statusExists) {
        $pdo->exec("ALTER TABLE reservations DROP COLUMN statut");
        echo "\nLa colonne 'statut' a été supprimée car 'status' existe déjà.\n";
    }
    // Si 'status' n'existe pas et 'statut' non plus, créer 'status'
    elseif (!$statusExists && !$statutExists) {
        $pdo->exec("ALTER TABLE reservations ADD COLUMN status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending'");
        echo "\nLa colonne 'status' a été créée.\n";
    }
    else {
        echo "\nAucune action nécessaire, la colonne 'status' existe déjà.\n";
    }
    
    // Vérifier l'état final
    $stmt = $pdo->query("SHOW COLUMNS FROM reservations LIKE 'status'");
    $statusExists = $stmt->fetch() !== false;
    echo "\nÉtat final: Colonne 'status' existe: " . ($statusExists ? "Oui" : "Non") . "\n";
    
    if ($statusExists) {
        $stmt = $pdo->query("SHOW COLUMNS FROM reservations LIKE 'status'");
        $column = $stmt->fetch();
        echo "Type de la colonne 'status': " . $column['Type'] . "\n";
    }
    
} catch (\PDOException $e) {
    echo "Erreur de connexion ou d'exécution: " . $e->getMessage() . "\n";
}