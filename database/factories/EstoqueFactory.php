<?php

namespace Database\Factories;

use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

class EstoqueFactory extends Factory
{
    public function definition(): array
    {
        $produto = Produto::inRandomOrder()->first();
        return [
            'produto_id' => $produto->id,
            'quantidade_estoque_produto' => $this->faker->numberBetween(1, 10),
        ];
    }
}