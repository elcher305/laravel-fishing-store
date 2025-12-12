<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // admin, user
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Добавляем базовые роли
        DB::table('roles')->insert([
            ['name' => 'admin', 'description' => 'Administrator'],
            ['name' => 'user', 'description' => 'Regular user'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
