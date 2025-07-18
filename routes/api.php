<?php

use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CupomController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\VariacaoController;
use Illuminate\Support\Facades\Route;

Route::apiResource('clientes', ClienteController::class);
Route::apiResource('produtos', ProdutoController::class);
Route::apiResource('cupons', CupomController::class);
Route::apiResource('variacoes', VariacaoController::class);
Route::apiResource('estoques', EstoqueController::class);
Route::apiResource('pedidos', PedidoController::class);

Route::post('/carrinho/adicionar', [CarrinhoController::class, 'adicionarProdutoAoCarrinho']);
Route::post('/carrinho/finalizar', [CarrinhoController::class, 'finalizar']);