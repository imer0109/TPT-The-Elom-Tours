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
    
    // Vérifier si la table circuits existe et récupérer un ID
    $stmt = $pdo->query("SELECT id FROM circuits LIMIT 1");
    $circuit = $stmt->fetch();
    
    if (!$circuit) {
        echo "Aucun circuit trouvé dans la base de données. Création d'un circuit de test...\n";
        
        // Créer un circuit de test si aucun n'existe
        $pdo->exec("INSERT INTO circuits (id, titre, slug, description, prix, duree, est_actif, created_at, updated_at) 
                    VALUES (UUID(), 'Circuit de test', 'circuit-de-test', 'Description du circuit de test', 1000, 7, 1, NOW(), NOW())");
        
        $stmt = $pdo->query("SELECT id FROM circuits LIMIT 1");
        $circuit = $stmt->fetch();
    }
    
    // Générer une référence unique
    $reference = 'RES-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
    
    // Insérer une réservation de test
    $stmt = $pdo->prepare("INSERT INTO reservations 
                          (id, circuit_id, reference, date_debut, date_fin, nombre_personnes, 
                           montant_total, status, commentaire, created_at, updated_at) 
                          VALUES (UUID(), :circuit_id, :reference, :date_debut, :date_fin, 
                                 :nombre_personnes, :montant_total, :status, :commentaire, NOW(), NOW())");
    
    $stmt->execute([
        'circuit_id' => $circuit['id'],
        'reference' => $reference,
        'date_debut' => date('Y-m-d', strtotime('+7 days')),
        'date_fin' => date('Y-m-d', strtotime('+14 days')),
        'nombre_personnes' => 2,
        'montant_total' => 2000.00,
        'status' => 'pending',
        'commentaire' => 'Réservation de test'
    ]);
    
    echo "Réservation créée avec succès!\n";
    echo "Référence: $reference\n";
    
    // Vérifier que la réservation a bien été créée
    $stmt = $pdo->prepare("SELECT * FROM reservations WHERE reference = :reference");
    $stmt->execute(['reference' => $reference]);
    $reservation = $stmt->fetch();
    
    echo "\nDétails de la réservation:\n";
    echo "ID: " . $reservation['id'] . "\n";
    echo "Circuit ID: " . $reservation['circuit_id'] . "\n";
    echo "Date de début: " . $reservation['date_debut'] . "\n";
    echo "Date de fin: " . $reservation['date_fin'] . "\n";
    echo "Nombre de personnes: " . $reservation['nombre_personnes'] . "\n";
    echo "Montant total: " . $reservation['montant_total'] . "\n";
    echo "Status: " . $reservation['status'] . "\n";
    
} catch (\PDOException $e) {
    echo "Erreur: " . $e->getMessage() . "\n";
}