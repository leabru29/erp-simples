<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cliente\StoreClienteRequest;
use App\Http\Requests\Cliente\UpdateClienteRequest;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(): JsonResponse
    {
        $clientes = Cliente::with('pedidos')
            ->get()
            ->map(function ($cliente) {
                return [
                    'id' => $cliente->id,
                    'nome' => $cliente->nome,
                    'email' => $cliente->email,
                    'telefone' => $cliente->telefone,
                    'pedidos' => $cliente->pedidos->map(function ($pedido) {
                        return [
                            'id' => $pedido->id,
                            'produto_id' => $pedido->produto_id,
                            'quantidade_pedido' => $pedido->quantidade_pedido,
                            'preco_unitario_pedido' => $pedido->preco_unitario_pedido,
                            'cupom_valor_pedido' => $pedido->cupom_valor_pedido,
                        ];
                    }),
                ];
            });
        return response()->json($clientes);
    }

    public function store(StoreClienteRequest $request): JsonResponse
    {
        $dados = $request->validate();
        Cliente::create($dados);
        return response()->json(['message' => 'Cliente cadastrado com sucesso'], 201);
    }

    public function show(Cliente $cliente): JsonResponse
    {
        return response()->json($cliente);
    }

    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        $dados = $request->validate();
        $cliente->update($dados);
        return response()->json(['message' => 'Cliente atualizado com sucesso']);
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return response()->json(['message' => 'Cliente excluído com sucesso']);
    }
}