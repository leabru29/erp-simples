<?php

namespace App\Http\Controllers;

use App\Http\Requests\Variacao\StoreVariacaoRequest;
use App\Http\Requests\Variacao\UpdateVariacaoRequest;
use App\Models\Variacao;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

class VariacaoController extends Controller
{
    public function index(): JsonResponse
    {
        $variacoes = Variacao::with('produto');
        return DataTables::eloquent($variacoes)
            ->addColumn('produto', function ($variacao) {
                return $variacao->produto ? $variacao->produto->nome : '';
            })
            ->addColumn('action', function ($produto) {
                return $produto->id;
            })
            ->make(true);
    }

    public function store(StoreVariacaoRequest $request): JsonResponse
    {
        $dados = $request->validated();
        Variacao::create($dados);
        return response()->json(['message' => 'Variação criada com sucesso'], 201);
    }

    public function show(Variacao $variaco): JsonResponse
    {
        return response()->json($variaco->load('produto'));
    }

    public function update(UpdateVariacaoRequest $request, Variacao $variaco): JsonResponse
    {
        $dados = $request->validated();
        $variaco->update($dados);
        return response()->json(['message' => 'Variação atualizada com sucesso']);
    }

    public function destroy(Variacao $variaco): JsonResponse
    {
        $variaco->delete();
        return response()->json(['message' => 'Variação deletada com sucesso']);
    }
}