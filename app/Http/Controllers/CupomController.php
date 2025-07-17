<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cupom\StoreCupomRequest;
use App\Http\Requests\Cupom\UpdateCupomRequest;
use App\Models\Cupom;
use Illuminate\Http\JsonResponse;

class CupomController extends Controller
{
    public function index(): JsonResponse
    {
        $cupons = Cupom::all();
        return response()->json($cupons);
    }

    public function store(StoreCupomRequest $request): JsonResponse
    {
        $dados = $request->validated();
        Cupom::create($dados);
        return response()->json([
            'message' => 'Cupom cadastrado com sucesso'], 201);
    }

    public function show(Cupom $cupom): JsonResponse
    {
        return response()->json($cupom);
    }

    public function update(UpdateCupomRequest $request, Cupom $cupom): JsonResponse
    {
        $dados = $request->validated();
        $cupom->update($dados);
        return response()->json(['message' => 'Cupom atualizado com sucesso']);
    }

    public function destroy(Cupom $cupom): JsonResponse
    {
        $cupom->delete();
        return response()->json(['message' => 'Cupom excluído com sucesso']);
    }
}