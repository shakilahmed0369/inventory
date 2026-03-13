<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
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
            'sku' => strtoupper('PROD-'.$this->faker->unique()->numerify('###')),
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'image' => null,
            'purchase_price' => $this->faker->randomFloat(2, 50, 500),
            'sell_price' => $this->faker->randomFloat(2, 100, 1000),
            'opening_stock' => $this->faker->numberBetween(10, 100),
            'current_stock' => $this->faker->numberBetween(0, 100),
        ];
    }
}
