<?php

namespace App\Http\Requests\Pedido;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePedidoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cupom_id' => 'nullable|exists:cupons,id',
            'cupom_valor_pedido' => 'nullable|numeric|min:0',
            'produto_id' => 'required|exists:produtos,id',
            'quantidade_pedido' => 'required|integer|min:1',
            'preco_unitario_pedido' => 'required|numeric|min:0',
            'cliente_id' => 'required|exists:clientes,id',
        ];
    }
}