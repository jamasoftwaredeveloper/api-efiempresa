<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 5, 30000), // Precio entre 5 y 1000
            'stock' => $this->faker->numberBetween(1, 100),   // Stock entre 1 y 100
            'ean' => $this->faker->unique()->ean13,           // Código de barras EAN-13
            'active' => $this->faker->boolean,
            'image' => "https://picsum.photos/300/300?random=" .  $this->faker->unique()->numberBetween(1, 1000),

        ];
    }
}
