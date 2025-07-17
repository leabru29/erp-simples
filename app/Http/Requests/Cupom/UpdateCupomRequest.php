<?php

namespace App\Http\Requests\Cupom;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCupomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo' => 'required|string|max:255|unique:cupons,codigo,' . $this->cupom->id,
            'valor_desconto' => 'required|numeric|min:0',
            'tipo' => 'required|in:percentual,valor_fixo',
            'valor_minimo' => 'nullable|numeric|min:0',
            'validade' => 'required|date|after_or_equal:today',
        ];
    }
}