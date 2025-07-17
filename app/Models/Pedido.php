<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'cupom_id',
        'cupom_valor_pedido',
        'produto_id',
        'quantidade_pedido',
        'preco_unitario_pedido',
        'cliente_id',
    ];

    public function cupom(): BelongsTo
    {
        return $this->belongsTo(Cupom::class);
    }

    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class);
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }
}