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
    {Schema::create('superhero_city', function (Blueprint $table) {
        $table->unsignedBigInteger('superhero_id');
        $table->unsignedBigInteger('city_id');
    
        $table->foreign('superhero_id')->references('id')->on('superheroes');
        $table->foreign('city_id')->references('id')->on('cities');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('superhero_superhero_city__join');
    }
};
