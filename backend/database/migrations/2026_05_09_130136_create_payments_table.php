<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                ->constrained('orders')
                ->onDelete('cascade');
            
            $table->enum('type_payment', [
                'pix',
                'cartao',
                'boleto'
            ]);

            $table->decimal('value', 10, 2);

            $table->enum('status_payment', [
                'pendente',
                'aprovado',
                'recusado'
            ])->default('pendente');

            $table->timestamp('data_payment')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
