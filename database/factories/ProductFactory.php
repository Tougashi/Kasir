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

    protected $model = \App\Models\Product::class;

    public function definition(): array
    {
        return [
            'code' => mt_rand(0000,9999),
            'name' => fake()->sentence(),
            'supplierId' => fake()->numberBetween(1, 3),
            'categoryId' => fake()->numberBetween(1, 2),
            'price' => '2000.00',
            'stock' => 0,
            'description' => fake()->word(),
            'entryDate' => fake()->dateTimeThisYear(),
            'expiredDate' => fake()->dateTimeThisYear('+32 months'),
        ];
    }
}
