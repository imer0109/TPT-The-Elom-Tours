<?php

// Afficher les erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion directe à la base de données MySQL
try {
    // Paramètres de connexion (à adapter selon votre configuration)
    $host = '127.0.0.1';
    $port = '3306';
    $database = 'theelomtours';
    $username = 'root';
    $password = '';
    
    echo "Tentative de connexion à la base de données {$database}...\n";
    
    // Connexion à MySQL
    $mysqli = new mysqli($host, $username, $password, $database, $port);
    
    // Vérifier la connexion
    if ($mysqli->connect_error) {
        throw new Exception("Échec de la connexion: " . $mysqli->connect_error);
    }
    
    echo "Connexion réussie à la base de données.\n";
    
    // Créer la table clients si elle n'existe pas
    $sql = "CREATE TABLE IF NOT EXISTS `clients` (
        `id` char(36) NOT NULL,
        `nom` varchar(255) NOT NULL,
        `prenom` varchar(255) NOT NULL,
        `email` varchar(255) NOT NULL,
        `telephone` varchar(255) NOT NULL,
        `adresse` varchar(255) DEFAULT NULL,
        `ville` varchar(255) DEFAULT NULL,
        `pays` varchar(255) DEFAULT NULL,
        `code_postal` varchar(255) DEFAULT NULL,
        `date_naissance` date DEFAULT NULL,
        `user_id` char(36) DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        `deleted_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `clients_email_unique` (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    if ($mysqli->query($sql) === TRUE) {
        echo "Table 'clients' créée avec succès.\n";
    } else {
        echo "Erreur lors de la création de la table: " . $mysqli->error . "\n";
    }
    
    // Vérifier si la table existe maintenant
    $result = $mysqli->query("SHOW TABLES LIKE 'clients'");
    if ($result->num_rows > 0) {
        echo "La table 'clients' existe bien dans la base de données.\n";
        
        // Tester la requête problématique
        echo "\nTest de la requête: SELECT * FROM clients WHERE deleted_at IS NULL ORDER BY nom ASC\n";
        $result = $mysqli->query("SELECT * FROM clients WHERE deleted_at IS NULL ORDER BY nom ASC");
        if ($result) {
            echo "Requête exécutée avec succès. Nombre de résultats: " . $result->num_rows . "\n";
        } else {
            echo "Erreur lors de l'exécution de la requête: " . $mysqli->error . "\n";
        }
    } else {
        echo "La table 'clients' n'a pas pu être créée.\n";
    }
    
    // Fermer la connexion
    $mysqli->close();
    
} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage() . "\n";
}