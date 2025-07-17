<?php

namespace App\Http\Controllers;

use App\Http\Requests\Produto\StoreProdutoRequest;
use App\Http\Requests\Produto\UpdateProdutoRequest;
use App\Models\Produto;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

class ProdutoController extends Controller
{
    public function index(): JsonResponse
    {
        $produtos = Produto::with('variacoes');
        return DataTables::eloquent($produtos)
            ->addColumn('variacoes', function ($produto) {
                return $produto->variacoes->map(function ($v) {
                    return $v->nome . ' (' . $v->estoque . ')';
                })->implode('<br>');
            })
            ->addColumn('action', function ($produto) {
                return $produto->id;
            })
            ->make(true);
    }

    public function store(StoreProdutoRequest $request): JsonResponse
    {
        $dados = $request->validated();
        Produto::create($dados);
        return response()->json(['message' => 'Produto cadastrado com sucesso'], 201);
    }

    public function show(Produto $produto): JsonResponse
    {
        $produto->load('variacoes');
        return response()->json($produto);
    }

    public function update(UpdateProdutoRequest $request, Produto $produto): JsonResponse
    {
        $dados = $request->validated();
        $produto->update($dados);
        return response()->json(['message' => 'Produto atualizado com sucesso']);
    }

    public function destroy(Produto $produto): JsonResponse
    {
        $produto->delete();
        return response()->json(['message' => 'Produto excluído com sucesso']);
    }
}