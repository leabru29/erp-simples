<?php

namespace App\Http\Controllers;

use App\Http\Requests\Estoque\StoreEstoqueRequest;
use App\Http\Requests\Estoque\UpdateEstoqueRequest;
use App\Models\Estoque;
use Illuminate\Http\JsonResponse;

class EstoqueController extends Controller
{
    public function index(): JsonResponse
    {
        $estoques = Estoque::with('produto')->get();
        return response()->json($estoques);
    }

    public function store(StoreEstoqueRequest $request): JsonResponse
    {
        $dados = $request->validated();
        Estoque::create($dados);
        return response()->json('Estoque do produto cadastrado com sucesso', 201);
    }

    public function show(Estoque $estoque): JsonResponse
    {
        return response()->json($estoque->load('produto'));
    }

    public function update(UpdateEstoqueRequest $request, Estoque $estoque): JsonResponse
    {
        $dados = $request->validated();
        $estoque->update($dados);
        return response()->json('Estoque do produto atualizado com sucesso');
    }

    public function destroy(Estoque $estoque): JsonResponse
    {
        $estoque->delete();
        return response()->json('Estoque do produto excluído com sucesso');
    }
}