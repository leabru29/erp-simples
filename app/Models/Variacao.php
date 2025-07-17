<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Variacao extends Model
{
    use HasFactory;

    protected $table = 'variacoes';

    protected $fillable = [
        'nome_variacao',
        'preco_variacao',
        'quantidade_variacao',
        'produto_id',
    ];

    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class);
    }
}