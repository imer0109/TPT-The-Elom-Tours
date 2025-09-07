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

    // Vérifier si la table reservations existe
    $stmt = $pdo->query("SHOW TABLES LIKE 'reservations'");
    $reservationsExists = $stmt->rowCount() > 0;
    echo "Table reservations existe: " . ($reservationsExists ? 'Oui' : 'Non') . "\n";
    
    if ($reservationsExists) {
        // Vérifier la structure de la table reservations
        $stmt = $pdo->query("DESCRIBE reservations");
        echo "Structure de la table reservations:\n";
        while ($row = $stmt->fetch()) {
            echo "- {$row['Field']}: {$row['Type']}" . ($row['Key'] ? " (Key: {$row['Key']})" : "") . "\n";
        }
        
        // Vérifier si la colonne statut existe
        $stmt = $pdo->query("SHOW COLUMNS FROM reservations LIKE 'statut'");
        $statutExists = $stmt->rowCount() > 0;
        echo "\nColonne 'statut' existe: " . ($statutExists ? 'Oui' : 'Non') . "\n";
        
        // Vérifier si la colonne status existe
        $stmt = $pdo->query("SHOW COLUMNS FROM reservations LIKE 'status'");
        $statusExists = $stmt->rowCount() > 0;
        echo "Colonne 'status' existe: " . ($statusExists ? 'Oui' : 'Non') . "\n";
        
        // Vérifier les données dans la table
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM reservations");
        $count = $stmt->fetch()['count'];
        echo "Nombre de réservations: {$count}\n";
        
        if ($count > 0) {
            $stmt = $pdo->query("SELECT * FROM reservations LIMIT 1");
            $reservation = $stmt->fetch();
            echo "\nExemple de réservation:\n";
            foreach ($reservation as $key => $value) {
                echo "- {$key}: {$value}\n";
            }
        }
    }
    
} catch (PDOException $e) {
    echo "Erreur: " . $e->getMessage() . "\n";
}