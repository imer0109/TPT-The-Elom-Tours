<?php

require 'vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

// Vérifier si la colonne is_approved existe déjà
if (!Schema::hasColumn('comments', 'is_approved')) {
    // Ajouter la colonne is_approved
    Schema::table('comments', function (Blueprint $table) {
        $table->boolean('is_approved')->default(false)->after('blog_post_id');
    });
    
    echo "La colonne 'is_approved' a été ajoutée à la table comments.\n";
} else {
    echo "La colonne 'is_approved' existe déjà dans la table comments.\n";
}

// Vérifier si la colonne parent_id existe déjà
if (!Schema::hasColumn('comments', 'parent_id')) {
    // Ajouter la colonne parent_id
    Schema::table('comments', function (Blueprint $table) {
        $table->uuid('parent_id')->nullable()->after('is_approved');
    });
    
    echo "La colonne 'parent_id' a été ajoutée à la table comments.\n";
} else {
    echo "La colonne 'parent_id' existe déjà dans la table comments.\n";
}

// Vérifier si les colonnes created_at et updated_at existent déjà
if (!Schema::hasColumn('comments', 'created_at')) {
    // Ajouter les timestamps
    Schema::table('comments', function (Blueprint $table) {
        $table->timestamps();
    });
    
    echo "Les colonnes 'created_at' et 'updated_at' ont été ajoutées à la table comments.\n";
} else {
    echo "Les colonnes 'created_at' et 'updated_at' existent déjà dans la table comments.\n";
}

// Vérifier la structure finale de la table
echo "\nStructure finale de la table comments:\n";
$columns = Schema::getColumnListing('comments');
echo "Colonnes: " . implode(', ', $columns) . "\n";