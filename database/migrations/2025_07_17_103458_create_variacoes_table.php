<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('variacoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome_variacao');
            $table->decimal('preco_variacao', 10, 2);
            $table->integer('quantidade_variacao')->default(0);
            $table->foreignId('produto_id')
                  ->constrained('produtos')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variacoes');
    }
};