<?php

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use App\Models\Produto;
use App\Models\Estoque;
use App\Models\Variacao;

class CarrinhoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_deve_adicionar_um_produto_ao_carrinho()
    {
        $produto = Produto::factory()->create(['preco' => 100.00]);
        Estoque::factory()->create([
            'produto_id' => $produto->id,
            'quantidade_estoque_produto' => 10,
        ]);
        Variacao::factory()->create([
            'produto_id' => $produto->id,
            'quantidade_variacao' => 5,
        ]);

        $response = $this->postJson('api/carrinho/adicionar', [
            'produto_id'   => $produto->id,
            'quantidade'   => 2,
            'variacao_id'  => 1,
        ]);

        $response->assertOk()
                 ->assertJson(['message' => 'Produto adicionado ao carrinho']);

        $this->assertEquals([
            [
                'id'            => $produto->id,
                'nome'          => $produto->nome,
                'preco'         => $produto->preco,
                'quantidade'    => 2,
                'variacao_id'   => 1,
            ]
        ], session('carrinho'));
    }


    public function test_calcula_frete_de_15_quando_subtotal_entre_52_e_166_59()
    {
        // adiciona item de R$ 60,00
        $this->withSession([
            'carrinho' => [
                ['id' => 1,'nome' => 'X','preco' => 60.00,'quantidade' => 1,'variacao_id' => null]
            ]
        ]);

        $response = $this->postJson('api/carrinho/finalizar', [
            'cep' => '01001000',
        ]);

        $response->assertOk()
                 ->assertJsonFragment([
                     'subtotal' => 60.00,
                     'frete'    => 15.00,
                 ]);
    }


    public function test_frete_gratis_quando_subtotal_maior_que_200()
    {
        $this->withSession([
            'carrinho' => [
                ['id' => 1,'nome' => 'Y','preco' => 210.00,'quantidade' => 1,'variacao_id' => null]
            ]
        ]);

        $response = $this->postJson('api/carrinho/finalizar', [
            'cep' => '01001000',
        ]);

        $response->assertOk()
                 ->assertJsonFragment([
                     'subtotal' => 210.00,
                     'frete'    => 0.00,
                 ]);
    }


    public function test_frete_de_20_para_outros_subtotais()
    {
        $this->withSession([
            'carrinho' => [
                ['id' => 1,'nome' => 'Z','preco' => 30.00,'quantidade' => 1,'variacao_id' => null]
            ]
        ]);

        $response = $this->postJson('api/carrinho/finalizar', [
            'cep' => '01001000',
        ]);

        $response->assertOk()
                 ->assertJsonFragment([
                     'subtotal' => 30.00,
                     'frete'    => 20.00,
                 ]);
    }


    public function test_valida_e_retorna_dados_do_endereco_pelo_cep()
    {
        // finge a resposta da API do ViaCEP
        Http::fake([
            'viacep.com.br/ws/01001000/json/' => Http::response([
                'cep'         => '01001-000',
                'logradouro'  => 'Praça da Sé',
                'bairro'      => 'Sé',
                'localidade'  => 'São Paulo',
                'uf'          => 'SP',
            ], 200),
        ]);

        $this->withSession([
            'carrinho' => [
                ['id' => 1,'nome' => 'W','preco' => 100.00,'quantidade' => 1,'variacao_id' => null]
            ]
        ]);

        $response = $this->postJson('api/carrinho/finalizar', [
            'cep' => '01001000',
        ]);

        $response->assertOk()
                 ->assertJsonStructure([
                     'subtotal',
                     'frete',
                     'endereco' => ['cep','logradouro','bairro','localidade','uf'],
                 ])
                 ->assertJsonPath('endereco.uf', 'SP')
                 ->assertJsonPath('endereco.localidade', 'São Paulo');
    }
}