<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CupomFactory extends Factory
{
    public function definition(): array
    {
        return [
            'codigo' => $this->faker->unique()->word,
            'valor_desconto' => $this->faker->randomFloat(2, 1, 100),
            'tipo' => $this->faker->randomElement(['percentual', 'valor']),
            'valor_minimo' => $this->faker->randomFloat(2, 0, 100),
            'validade' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
        ];
    }
}