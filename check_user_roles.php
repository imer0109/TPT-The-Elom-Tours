<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

// Vérifier si l'utilisateur admin existe
$admin = User::where('email', 'admin@elomtours.com')->first();

if ($admin) {
    echo "Utilisateur admin trouvé: ID {$admin->id}, Nom: {$admin->firstName} {$admin->lastName}\n";
    echo "Rôle dans la colonne 'role': {$admin->role}\n";
    
    // Vérifier les rôles dans la table pivot
    $roles = $admin->roles()->get();
    
    if ($roles->count() > 0) {
        echo "Rôles attribués via la relation many-to-many:\n";
        foreach ($roles as $role) {
            echo "- {$role->name} (ID: {$role->id})\n";
        }
    } else {
        echo "Aucun rôle n'est attribué à cet utilisateur via la relation many-to-many.\n";
        
        // Attribuer le rôle manuellement
        $adminRole = Role::where('name', 'Administrateur')->first();
        if ($adminRole) {
            $admin->roles()->attach($adminRole->id);
            echo "Le rôle 'Administrateur' a été attribué manuellement.\n";
        } else {
            echo "Le rôle 'Administrateur' n'existe pas dans la base de données.\n";
        }
    }
} else {
    echo "Utilisateur admin@elomtours.com non trouvé dans la base de données.\n";
    
    // Créer l'utilisateur et le rôle si nécessaire
    echo "Création de l'utilisateur admin...\n";
    
    // Vérifier si le rôle existe
    $adminRole = Role::where('name', 'Administrateur')->first();
    if (!$adminRole) {
        $adminRole = Role::create([
            'name' => 'Administrateur',
            'slug' => 'admin',
            'description' => 'Administrateur avec privilèges limités'
        ]);
        echo "Rôle 'Administrateur' créé.\n";
    }
    
    // Créer l'utilisateur
    $admin = User::create([
        'firstName' => 'Admin',
        'lastName' => 'Simple',
        'email' => 'admin@elomtours.com',
        'password' => bcrypt('password'),
        'role' => 'Administrateur'
    ]);
    
    // Attribuer le rôle
    $admin->roles()->attach($adminRole->id);
    echo "Utilisateur admin créé et rôle attribué.\n";
}

// Vérifier la structure de la table role_user
echo "\nStructure de la table role_user:\n";
$columns = DB::getSchemaBuilder()->getColumnListing('role_user');
echo "Colonnes: " . implode(', ', $columns) . "\n";

// Vérifier les entrées dans la table role_user
echo "\nEntrées dans la table role_user:\n";
$roleUsers = DB::table('role_user')->get();
foreach ($roleUsers as $ru) {
    echo "- user_id: {$ru->user_id}, role_id: {$ru->role_id}\n";
}