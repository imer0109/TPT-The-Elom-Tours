<?php

try {
    // Connexion directe à MySQL
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
    
    // Tester la requête qui posait problème
    $stmt = $pdo->query("SELECT COUNT(*) as aggregate FROM reservations WHERE status = 'pending' AND deleted_at IS NULL");
    $result = $stmt->fetch();
    
    echo "Nombre de réservations en attente: " . $result['aggregate'] . "\n";
    
    // Afficher quelques réservations pour vérifier
    $stmt = $pdo->query("SELECT id, status, deleted_at FROM reservations LIMIT 5");
    $reservations = $stmt->fetchAll();
    
    echo "\nExemples de réservations:\n";
    foreach ($reservations as $reservation) {
        echo "ID: " . $reservation['id'] . ", Status: " . $reservation['status'] . ", Deleted At: " . 
             ($reservation['deleted_at'] ? $reservation['deleted_at'] : 'NULL') . "\n";
    }
    
} catch (\PDOException $e) {
    echo "Erreur de connexion ou d'exécution: " . $e->getMessage() . "\n";
}