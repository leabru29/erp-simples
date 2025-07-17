<?php

namespace App\Http\Requests\Variacao;

use Illuminate\Foundation\Http\FormRequest;

class StoreVariacaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome_variacao' => 'required|string|max:255',
            'preco_variacao' => 'required|numeric|min:0',
            'quantidade_variacao' => 'required|integer|min:0',
            'produto_id' => 'required|exists:produtos,id',
        ];
    }
}