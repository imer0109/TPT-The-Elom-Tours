<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur administrateur s'il n'existe pas déjà
        if (!User::where('email', 'admin@elomtours.com')->exists()) {
            User::create([
                'firstName' => 'Admin',
                'lastName' => 'System',
                'email' => 'admin@elomtours.com',
                'password' => Hash::make('admin123'),
                'role' => RoleEnum::ADMIN,
            ]);
        }

        // Créer un utilisateur standard s'il n'existe pas déjà
        if (!User::where('email', 'user@elomtours.com')->exists()) {
            User::create([
                'firstName' => 'User',
                'lastName' => 'Standard',
                'email' => 'user@elomtours.com',
                'password' => Hash::make('user123'),
                'role' => RoleEnum::USER,
            ]);
        }

        // Vous pouvez également créer des utilisateurs aléatoires
        // Limiter à 5 utilisateurs au total pour éviter d'en créer trop
        $userCount = User::where('role', RoleEnum::USER)->count();
        $remainingUsers = max(0, 5 - $userCount);
        
        if ($remainingUsers > 0) {
            User::factory($remainingUsers)->create([
                'role' => RoleEnum::USER,
            ]);
        }
    }
}