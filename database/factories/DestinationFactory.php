<?php

namespace Database\Factories;

use App\Models\Destination;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DestinationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Destination::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->unique()->city();
        $slug = Str::slug($name);
        
        return [
            'name' => $name,
            'slug' => $slug,
            'description' => $this->faker->paragraph(3),
            'country' => $this->faker->country(),
            'city' => $name,
            'is_popular' => $this->faker->boolean(30),
            'is_active' => $this->faker->boolean(80),
            'meta_title' => 'Visiter ' . $name,
            'meta_description' => 'Découvrez ' . $name . ', ' . $this->faker->sentence(),
            'meta_keywords' => strtolower($name) . ', voyage, tourisme, ' . strtolower($this->faker->word()),
        ];
    }
}