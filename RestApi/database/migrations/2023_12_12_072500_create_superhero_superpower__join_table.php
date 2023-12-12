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
    {
        Schema::create('superhero_superpower', function (Blueprint $table) {
            $table->unsignedBigInteger('superhero_id');
            $table->unsignedBigInteger('superpower_id');
        
            $table->foreign('superhero_id')->references('id')->on('superheroes');
            $table->foreign('superpower_id')->references('id')->on('superpowers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('superhero_superpower__join');
    }
};
