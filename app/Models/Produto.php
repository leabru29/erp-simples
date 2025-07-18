<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';

    protected $fillable = [
        'nome',
        'preco',
    ];

    public function variacoes()
    {
        return $this->hasMany(Variacao::class);
    }

    public function estoque()
    {
        return $this->hasOne(Estoque::class);
    }
}