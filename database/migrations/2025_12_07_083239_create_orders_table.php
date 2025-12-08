<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // Уникальный номер заказа
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_name'); // Имя клиента
            $table->string('customer_email'); // Email клиента
            $table->string('customer_phone'); // Телефон клиента
            $table->text('customer_address')->nullable(); // Адрес доставки
            $table->text('notes')->nullable(); // Комментарии к заказу
            $table->decimal('total_amount', 10, 2)->default(0); // Общая сумма
            $table->enum('status', [
                'pending',     // Ожидает обработки
                'processing',  // В обработке
                'shipped',     // Отправлен
                'delivered',   // Доставлен
                'cancelled'    // Отменен
            ])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
