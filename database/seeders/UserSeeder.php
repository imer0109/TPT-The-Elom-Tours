<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Création des rôles (ou récupération s'ils existent déjà)
        $superAdminRole = Role::firstOrCreate(
            ['slug' => 'super-admin'],
            [
                'name' => RoleEnum::SUPER_ADMIN->value,
                'description' => 'Super Administrateur avec tous les privilèges',
            ]
        );
        
        $adminRole = Role::firstOrCreate(
            ['slug' => 'admin'],
            [
                'name' => RoleEnum::ADMIN->value,
                'description' => 'Administrateur avec privilèges limités',
            ]
        );
        
        // Création du Super Administrateur (ou récupération s'il existe déjà)
        $superAdmin = User::firstOrCreate(
            ['email' => 'super.admin@elomtours.com'],
            [
                'firstName' => 'Super',
                'lastName' => 'Admin',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]
        );
        
        // Création de l'Administrateur simple (ou récupération s'il existe déjà)
        $admin = User::firstOrCreate(
            ['email' => 'admin@elomtours.com'],
            [
                'firstName' => 'Admin',
                'lastName' => 'Simple',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]
        );
        
        // Attribution stricte des rôles
        // Super Administrateur ne doit avoir que le rôle SUPER_ADMIN
        $superAdmin->roles()->sync([$superAdminRole->id]);
        
        // Administrateur simple ne doit avoir que le rôle ADMIN
        $admin->roles()->sync([$adminRole->id]);
    }
}