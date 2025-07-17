<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('variacoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->decimal('preco', 10, 2);
            $table->foreignId('produto_id')
                  ->constrained('produtos')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variacaos');
    }
};