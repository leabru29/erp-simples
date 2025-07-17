<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('cupons', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->decimal('valor_desconto', 10, 2);
            $table->enum('tipo', ['percentual', 'valor'])->default('valor');
            $table->decimal('valor_minimo', 10, 2)->default(0);
            $table->timestamp('validade')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cupoms');
    }
};