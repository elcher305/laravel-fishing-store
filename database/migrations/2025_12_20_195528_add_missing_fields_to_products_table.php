<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Проверяем, существуют ли поля перед добавлением

            if (!Schema::hasColumn('products', 'characteristics')) {
                $table->text('characteristics')->nullable()->after('description');
            }

            if (!Schema::hasColumn('products', 'image')) {
                $table->string('image')->nullable()->after('characteristics');
            }

            if (!Schema::hasColumn('products', 'stock')) {
                $table->integer('stock')->default(0)->after('price');
            }

            if (!Schema::hasColumn('products', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('stock')->constrained('categories')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Удаляем только те поля, которые мы добавляли
            if (Schema::hasColumn('products', 'characteristics')) {
                $table->dropColumn('characteristics');
            }

            if (Schema::hasColumn('products', 'image')) {
                $table->dropColumn('image');
            }

            if (Schema::hasColumn('products', 'stock')) {
                $table->dropColumn('stock');
            }

            if (Schema::hasColumn('products', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }
        });
    }
};
