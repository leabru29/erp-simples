<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\Estoque;
use App\Models\Produto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProdutoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_deve_cadastrar_produto_com_variacoes_e_estoque()
    {
        $dados = [
                'nome' => 'Camiseta Slim',
                'preco' => 59.90,
                'quantidade_estoque_produto' => 10,
            ];

        $response = $this->postJson(route('produtos.store'), $dados);

        $response->assertStatus(201);
        $this->assertDatabaseHas('produtos', [
            'nome' => 'Camiseta Slim',
            'preco' => 59.90
        ]);
        $this->assertDatabaseHas('estoques', [
            'quantidade_estoque_produto' => 10
        ]);
        $this->assertEquals(1, Produto::count());
        $this->assertEquals(1, Estoque::count());
    }
}