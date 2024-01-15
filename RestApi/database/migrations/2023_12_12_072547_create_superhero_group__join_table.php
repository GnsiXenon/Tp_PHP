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
        Schema::create('superhero_group', function (Blueprint $table) {
            $table->unsignedBigInteger('superhero_id');
            $table->unsignedBigInteger('group_id');
        
            $table->foreign('superhero_id')->references('id')->on('superheroes');
            $table->foreign('group_id')->references('id')->on('groups');
        });

        DB::table('superhero_group')->insert([
            'superhero_id' => '1',
            'group_id' => '1',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('superhero_superhero_group__join');
    }
};
