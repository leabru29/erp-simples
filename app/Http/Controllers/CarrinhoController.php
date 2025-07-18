<?php

namespace App\Http\Controllers;

use App\Models\Cupom;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CarrinhoController extends Controller
{
    public function index()
    {
        $itens = session('carrinho', []);
        ;
        return view('carrinho.index', compact('itens'));
    }

    public function adicionarProdutoAoCarrinho(Request $request)
    {
        $produtoId = $request->input('produto_id');
        $quantidade = $request->input('quantidade');
        $variacaoId = $request->input('variacao_id');

        $produto = Produto::findOrFail($produtoId);

        $item = [
            'id' => $produto->id,
            'nome' => $produto->nome,
            'preco' => $produto->preco,
            'quantidade' => $quantidade,
            'variacao_id' => $variacaoId
        ];

        $carrinho = session()->get('carrinho', []);
        $carrinho[] = $item;

        session()->put('carrinho', $carrinho);

        return response()->json(['message' => 'Produto adicionado ao carrinho']);
    }

    public function finalizar(Request $request)
    {
        $subtotal = $this->calculaSubtotal();

        $cupom = null;
        $desconto = 0;

        if ($request->has('cupom')) {
            $cupom = Cupom::where('codigo', $request->input('cupom'))->first();

            if ($cupom && $cupom->isValido() && $subtotal >= $cupom->valor_minimo) {
                if ($cupom->tipo === 'percentual') {
                    $desconto = ($subtotal * $cupom->valor_desconto) / 100;
                } else {
                    $desconto = $cupom->valor_desconto;
                }
            }
        }

        $total = $subtotal - $desconto;

        return response()->json([
            'subtotal' => $subtotal,
            'desconto' => $desconto,
            'total' => max($total, 0),
        ]);
    }

    public function remover($id)
    {
        $carrinho = session()->get('carrinho', []);

        if (isset($carrinho[$id])) {
            unset($carrinho[$id]);
            session()->put('carrinho', $carrinho);
        }

        return redirect()->route('carrinho.index')->with('success', 'Produto removido.');
    }

    public function aplicarCupom(Request $request)
    {
        $cupom = $request->cupom;

        if ($cupom === 'DESCONTO10') {
            session()->put('cupom', ['codigo' => $cupom, 'desconto' => 10.00]);
        } else {
            session()->forget('cupom');
        }

        return redirect()->route('carrinho.index');
    }
}