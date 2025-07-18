<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    use HasFactory;

    protected $table = 'estoques';

    protected $fillable = [
        'produto_id',
        'quantidade_estoque_produto',
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}