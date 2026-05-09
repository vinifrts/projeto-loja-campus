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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('coupon_id')
                ->nullable()
                ->constrained('coupons')
                ->nullOnDelete();

            $table->timestamp('date_order')->useCurrent();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2);
            $table->decimal('freight', 10, 2);
            $table->decimal('total', 10, 2);

            $table->enum('type_delivery', [
                'retirada',
                'delivery'
            ]);

            $table->enum('status_order', [
                'pendente',
                'pago',
                'enviado',
                'entregue',
                'cancelado'
            ])->default('pendente');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
