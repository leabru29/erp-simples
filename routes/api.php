<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CupomController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Route;

Route::apiResource('clientes', ClienteController::class);
Route::apiResource('produtos', ProdutoController::class);
Route::apiResource('cupons', CupomController::class);