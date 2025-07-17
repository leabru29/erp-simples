<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('estoques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produto_id')
                  ->nullable()
                  ->constrained('produtos')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
            $table->integer('quantidade');
            $table->foreignId('variacao_id')
                    ->nullable()
                    ->constrained('variacoes')
                    ->onUpdate('cascade')
                    ->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estoques');
    }
};