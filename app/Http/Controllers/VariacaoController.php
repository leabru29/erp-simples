<?php

namespace App\Http\Controllers;

use App\Http\Requests\Variacao\StoreVariacaoRequest;
use App\Http\Requests\Variacao\UpdateVariacaoRequest;
use App\Models\Variacao;
use Illuminate\Http\JsonResponse;

class VariacaoController extends Controller
{
    public function index(): JsonResponse
    {
        $variacoes = Variacao::with('produto')->get();
        return response()->json($variacoes);
    }

    public function store(StoreVariacaoRequest $request): JsonResponse
    {
        $dados = $request->validated();
        Variacao::create($dados);
        return response()->json(['message' => 'Variação criada com sucesso'], 201);
    }

    public function show(Variacao $variacao): JsonResponse
    {
        return response()->json($variacao->load('produto'));
    }

    public function update(UpdateVariacaoRequest $request, Variacao $variacao): JsonResponse
    {
        $dados = $request->validated();
        $variacao->update($dados);
        return response()->json(['message' => 'Variação atualizada com sucesso']);
    }

    public function destroy(Variacao $variacao): JsonResponse
    {
        $variacao->delete();
        return response()->json(['message' => 'Variação deletada com sucesso']);
    }
}