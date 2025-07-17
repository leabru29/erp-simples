<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pedido\StorePedidoRequest;
use App\Http\Requests\Pedido\UpdatePedidoRequest;
use App\Models\Pedido;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index(): JsonResponse
    {
        $pedidos = Pedido::with('cliente', 'produtos')->get();
        return response()->json($pedidos);
    }

    public function store(StorePedidoRequest $request)
    {
        $dados = $request->validated();

        $pedido = Pedido::create(['cliente_id' => $dados['cliente_id']]);
        $pedido->produtos()->attach($dados['produtos']);

        return response()->json('Pedido criado com sucesso', 201);
    }

    public function show(Pedido $pedido)
    {
        $pedido->load('cliente', 'produtos');
        return response()->json($pedido);
    }

    public function update(UpdatePedidoRequest $request, Pedido $pedido)
    {
        $dados = $request->validated();
        $pedido->update($dados);
        return response()->json('Pedido atualizado com sucesso');
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();
        return response()->json('Pedido excluído com sucesso');
    }
}