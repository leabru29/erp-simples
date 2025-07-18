<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\Cupom;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CupomControllerTest extends TestCase
{
    use RefreshDatabase;

    private string $baseUrl = '/api/cupons';

    public function test_deve_criar_um_cupom_via_api()
    {
        $data = [
            'codigo' => 'PROMO10',
            'valor_desconto' => 10,
            'tipo' => 'percentual',
            'valor_minimo' => 50,
            'validade' => Carbon::now()->addDays(5)->toDateString(),
        ];

        $response = $this->postJson($this->baseUrl, $data);

        $response->assertCreated();
        $response->assertJson(['message' => 'Cupom cadastrado com sucesso']);

        $this->assertDatabaseHas('cupons', ['codigo' => 'PROMO10']);
    }


    public function test_nao_deve_criar_cupom_com_dados_invalidos()
    {
        $data = [
            'codigo' => '',
            'valor_desconto' => 'invalido',
            'tipo' => 'invalido',
        ];

        $response = $this->postJson($this->baseUrl, $data);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['codigo', 'valor_desconto', 'tipo']);
    }


    public function test_deve_atualizar_um_cupom_via_api()
    {
        $cupom = Cupom::factory()->create();

        $data = [
            'codigo' => 'ATUALIZADO10',
            'valor_desconto' => 20,
            'tipo' => 'valor',
            'valor_minimo' => 100,
            'validade' => Carbon::now()->addDays(10)->toDateString(),
        ];

        $response = $this->putJson(route('cupons.update', $cupom->id), $data);

        $response->assertOk();
        $response->assertJson(['message' => 'Cupom atualizado com sucesso']);
        $this->assertDatabaseHas('cupons', ['codigo' => 'ATUALIZADO10']);
    }


    public function test_deve_excluir_um_cupom_via_api()
    {
        $cupom = Cupom::factory()->create();

        $response = $this->deleteJson(route('cupons.destroy', $cupom->id));

        $response->assertOk();
        $this->assertDatabaseMissing('cupons', ['id' => $cupom->id]);
    }


    public function test_deve_listar_os_cupons_via_api()
    {
        $cupons = Cupom::factory()->count(3)->create();

        $response = $this->getJson($this->baseUrl);

        $response->assertOk();
        $response->assertJsonCount($cupons->count());
    }
}