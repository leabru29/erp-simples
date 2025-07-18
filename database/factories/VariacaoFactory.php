<?php

namespace Database\Factories;

use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

class VariacaoFactory extends Factory
{
    public function definition(): array
    {
        $produto = Produto::inRandomOrder()->first();
        return [
            'nome_variacao' => $this->faker->word(),
            'preco_variacao' => $this->faker->randomFloat(2, 1, 1000),
            'quantidade_variacao' => $this->faker->numberBetween(1, 10),
            'produto_id' => $produto->id,
        ];
    }
}