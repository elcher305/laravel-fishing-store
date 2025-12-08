<?php
// database/migrations/xxxx_add_profile_fields_to_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Добавляем поля для профиля
            $table->string('phone')->nullable()->after('email');
            $table->string('address')->nullable()->after('phone');
            $table->date('birth_date')->nullable()->after('address');
            $table->string('avatar')->nullable()->after('birth_date');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('avatar');

            // Для рыболовного профиля
            $table->enum('fishing_experience', [
                'beginner',
                'amateur',
                'professional'
            ])->default('beginner')->after('gender');

            $table->text('about')->nullable()->after('fishing_experience');
            $table->string('favorite_fishing_type')->nullable()->after('about');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'address',
                'birth_date',
                'avatar',
                'gender',
                'fishing_experience',
                'about',
                'favorite_fishing_type'
            ]);
        });
    }
};
