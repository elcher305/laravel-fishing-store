<?php
// database/migrations/xxxx_create_cart_items_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->string('session_id'); // Для гостей
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2); // Цена на момент добавления
            $table->timestamps();

            // Уникальность: один товар в корзине пользователя/сессии
            $table->unique(['session_id', 'product_id']);
            $table->unique(['user_id', 'product_id'])->where('user_id IS NOT NULL');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
