<?php

namespace App\Http\Controllers;

use App\Http\Requests\Produto\StoreProdutoRequest;
use App\Http\Requests\Produto\UpdateProdutoRequest;
use App\Models\Produto;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ProdutoController extends Controller
{
    public function index(): JsonResponse
    {
        $produtos = Produto::with('variacoes');
        return DataTables::eloquent($produtos)
            ->addColumn('variacoes', function ($produto) {
                return $produto->variacoes->map(function ($v) {
                    return [
                        'nome' => $v->nome_variacao,
                        'preco' => $v->preco_variacao,
                        'estoque' => $v->quantidade_variacao,
                    ];
                });
            })
            ->addColumn('estoque', function ($produto) {
                return optional($produto->estoque)->quantidade_estoque_produto ?? 0;
            })
            ->addColumn('action', function ($produto) {
                return $produto->id;
            })
            ->make(true);
    }

    public function store(StoreProdutoRequest $request): JsonResponse
    {
        $dadosProduto = $request->only(['nome', 'preco']);
        $produto = Produto::create($dadosProduto);
        $produto->estoque()->create([
            'produto_id' => $produto->id,
            'quantidade_estoque_produto' => $request->input('quantidade_estoque_produto')
        ]);
        return response()->json(['message' => 'Produto cadastrado com sucesso'], 201);
    }

    public function show(Produto $produto): JsonResponse
    {
        $produto->load('variacoes', 'estoque');
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

    public function viewProdutos(): View
    {
        $produtos = Produto::all();
        return view('produtos.index', compact('produtos'));
    }
}