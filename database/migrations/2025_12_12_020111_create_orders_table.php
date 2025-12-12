<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('address_id')->constrained()->onDelete('cascade');
            $table->enum('status', [
                'pending',        // Ожидает обработки
                'processing',     // В обработке
                'shipped',        // Отправлен
                'delivered',      // Доставлен
                'cancelled',      // Отменен
                'refunded'        // Возвращен
            ])->default('pending');

            $table->enum('payment_method', ['card', 'cash', 'online'])->default('card');
            $table->enum('delivery_method', ['pickup', 'courier', 'post'])->default('courier');

            $table->decimal('subtotal', 10, 2);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('total', 10, 2);

            $table->text('notes')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
