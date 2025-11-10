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
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('old_price', 10, 2)->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
            $table->string('image')->nullable();
            $table->boolean('in_stock')->default(true);
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->integer('review_count')->default(0);
            $table->json('features')->nullable();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
