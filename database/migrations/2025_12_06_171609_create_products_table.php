<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Название товара
            $table->text('description')->nullable(); // Описание
            $table->decimal('price', 10, 2); // Цена
            $table->integer('quantity')->default(0); // Количество
            $table->string('image')->nullable(); // Фото
            $table->string('category'); // Категория (удочки, катушки, лески и т.д.)
            $table->json('characteristics')->nullable(); // Характеристики в JSON
            $table->boolean('is_active')->default(true); // Активен ли товар
            $table->timestamps();
            $table->softDeletes(); // Мягкое удаление
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
