<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title')->default('Основной адрес');
            $table->string('full_name');
            $table->string('phone');
            $table->string('country')->default('Россия');
            $table->string('region');
            $table->string('city');
            $table->string('street');
            $table->string('house');
            $table->string('apartment')->nullable();
            $table->string('postal_code');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('addresses');
    }
};
