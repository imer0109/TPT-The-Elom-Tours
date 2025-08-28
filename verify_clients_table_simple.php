<?php

// Simple script to check if clients table exists

// Database connection parameters
$host = 'localhost';
$dbname = 'theelomtours';
$username = 'root';
$password = '';

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to database successfully.\n";
    
    // Check if the clients table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'clients'");
    $tableExists = $stmt->rowCount() > 0;
    
    echo "Table 'clients' exists: " . ($tableExists ? 'Yes' : 'No') . "\n";
    
    if ($tableExists) {
        // Get the structure of the clients table
        $stmt = $pdo->query("DESCRIBE clients");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "\nColumns in 'clients' table:\n";
        foreach ($columns as $column) {
            echo "{$column['Field']} - {$column['Type']} - {$column['Null']} - {$column['Key']} - {$column['Default']}\n";
        }
        
        // Count the number of records in the clients table
        $stmt = $pdo->query("SELECT COUNT(*) FROM clients");
        $count = $stmt->fetchColumn();
        
        echo "\nNumber of records in 'clients' table: $count\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}