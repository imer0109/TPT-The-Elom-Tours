<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

// Charger les variables d'environnement
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Connexion à la base de données
$host = env('DB_HOST', '127.0.0.1');
$port = env('DB_PORT', '3306');
$database = env('DB_DATABASE', 'theelomtours');
$username = env('DB_USERNAME', 'root');
$password = env('DB_PASSWORD', '');

try {
    $pdo = new PDO("mysql:host={$host};port={$port};dbname={$database}", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connexion à la base de données réussie.\n";
    
    // Lire le fichier SQL
    $sql = file_get_contents(__DIR__ . '/create_clients_table.sql');
    
    // Exécuter la requête SQL
    $pdo->exec($sql);
    
    echo "Table 'clients' créée avec succès.\n";
    
    // Vérifier que la table existe
    $stmt = $pdo->query("SHOW TABLES LIKE 'clients'");
    if ($stmt->rowCount() > 0) {
        echo "Vérification: La table 'clients' existe bien dans la base de données.\n";
        
        // Afficher la structure de la table
        $stmt = $pdo->query("DESCRIBE clients");
        echo "Structure de la table 'clients':\n";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "- {$row['Field']} ({$row['Type']})" . ($row['Null'] === 'NO' ? ' NOT NULL' : '') . "\n";
        }
    } else {
        echo "Erreur: La table 'clients' n'a pas été créée.\n";
    }
    
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage() . "\n";
}