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
        Schema::create('superheroes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('secret_identity');
            $table->string('gender');
            $table->string('hair_color');
            $table->string('origin_planet');
            $table->text('description');
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->timestamps();
        
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->foreign('group_id')->references('id')->on('groups');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('superheroes');
    }
};
