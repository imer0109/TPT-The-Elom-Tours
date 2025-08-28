<?php

// Afficher les erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Test de la syntaxe d'une classe de migration...\n";

// Définir une classe de migration correcte
class TestMigration extends stdClass
{
    public function up(): void
    {
        echo "Méthode up() appelée.\n";
    }

    public function down(): void
    {
        echo "Méthode down() appelée.\n";
    }
}

// Créer une instance de la classe
$migration = new TestMigration();

// Appeler les méthodes
$migration->up();
$migration->down();

echo "\nTest terminé avec succès. La syntaxe de la classe est correcte.\n";