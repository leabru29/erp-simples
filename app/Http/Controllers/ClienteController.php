<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cliente\StoreClienteRequest;
use App\Http\Requests\Cliente\UpdateClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ClienteController extends Controller
{
    public function index(): JsonResponse
    {
        $clientes = Cliente::all();
        return DataTables::of($clientes)
            ->addColumn('action', function ($cliente) {
                return $cliente->id;
            })
            ->make(true);
    }

    public function store(StoreClienteRequest $request): JsonResponse
    {
        $dados = $request->validated();
        if (empty($dados['senha'])) {
            $dados['senha'] = Hash::make(Str::random(8));
        }
        Cliente::create($dados);
        return response()->json(['message' => 'Cliente cadastrado com sucesso'], 201);
    }

    public function show(Cliente $cliente): JsonResponse
    {
        return response()->json($cliente);
    }

    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        $dados = $request->validated();
        $cliente->update($dados);
        return response()->json(['message' => 'Cliente atualizado com sucesso']);
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return response()->json(['message' => 'Cliente excluído com sucesso']);
    }
}