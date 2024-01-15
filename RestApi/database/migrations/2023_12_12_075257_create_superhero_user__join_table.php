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
        Schema::create('user_superhero', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('superhero_id');
    
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('superhero_id')->references('id')->on('superheroes');
        });

        DB::table('user_superhero')->insert([
            'user_id' => '1',
            'superhero_id' => '1',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('superhero_user__join');
    }
};
