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
            $table->binary('image')->nullable(); 
            $table->timestamps();
        });

        DB::table('superheroes')->insert([
            'name' => 'Superman',
            'secret_identity' => 'Clark Kent',
            'gender' => 'Male',
            'hair_color' => 'Black',
            'origin_planet' => 'Krypton',
            'description' => 'The Man of Steel',
            'image' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('superheroes');
    }
};
