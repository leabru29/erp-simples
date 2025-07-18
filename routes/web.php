<?php

use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('produtos', [ProdutoController::class, 'viewProdutos'])->name('produto.index');
Route::view('clientes', 'clientes.index')->name('cliente.index');

Route::prefix('carrinho')->group(function () {
    Route::get('/', [CarrinhoController::class, 'index'])->name('carrinho.index');
    Route::post('/atualizar', [CarrinhoController::class, 'atualizar'])->name('carrinho.atualizar');
    Route::delete('/remover/{index}', [CarrinhoController::class, 'remover'])->name('carrinho.remover');
    Route::post('/aplicar-cupom', [CarrinhoController::class, 'aplicarCupom'])->name('carrinho.aplicar-cupom');
    Route::post('/finalizar', [CarrinhoController::class, 'finalizar'])->name('carrinho.finalizar');
});