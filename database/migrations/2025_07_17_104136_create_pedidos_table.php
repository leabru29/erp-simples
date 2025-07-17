<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cupom_id')
                  ->constrained('cupons')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            //Aqui seria o valor do cupom no momento do pedido
            $table->decimal('cupom_valor_pedido', 10, 2);

            $table->foreignId('produto_id')
                    ->constrained('produtos')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            //Quantidade do produto no pedido
            $table->integer('quantidade_pedido');

            //Aqui seria o preço do produto no momento do pedido
            $table->decimal('preco_unitario_pedido', 10, 2);

            //Cliente que fez o pedido
            $table->foreignUuid('cliente_id')
                  ->constrained('clientes')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};