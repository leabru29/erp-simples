<?php

namespace App\Http\Requests\Cliente;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:clientes,email' . ($this->cliente ? ',' . $this->cliente->id : ''),
            'telefone' => 'required|string|max:20',
            'senha' => 'sometimes|string|min:8|confirmed',
        ];
    }
}