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
        Schema::create('superhero_gadget', function (Blueprint $table) {
            $table->unsignedBigInteger('superhero_id');
            $table->unsignedBigInteger('gadget_id');
        
            $table->foreign('superhero_id')->references('id')->on('superheroes');
            $table->foreign('gadget_id')->references('id')->on('gadgets');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('superhero_superhero_gadget__join');
    }
};
