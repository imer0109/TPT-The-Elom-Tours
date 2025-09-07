<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Category;
use App\Models\TypeProduct;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Exécuter les seeders
        $this->call([
            UserSeeder::class,
            TestimonialSeeder::class,
            SettingsSeeder::class,
            ReviewSeeder::class,
        ]);

        TypeProduct::factory()->create([
            'name' => 'Logiciel',
        ]);

        TypeProduct::factory()->create([
            'name' => 'Equipement',
        ]);

        Category::factory()->create([
            'type_product_id' => TypeProduct::query()->first()->id,
            'name' => 'App Mobile',
        ]);
    }
}
