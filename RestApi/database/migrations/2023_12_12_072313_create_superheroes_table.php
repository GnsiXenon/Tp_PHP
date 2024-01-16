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
            ['name' => 'Superman',
            'secret_identity' => 'Clark Kent',
            'gender' => 'Male',
            'hair_color' => 'Black',
            'origin_planet' => 'Krypton',
            'description' => 'The Man of Steel',
            'image' => null,
            'created_at' => now(),
            'updated_at' => now(),],
            [
                'name' => 'Wonder Woman',
                'secret_identity' => 'Diana Prince',
                'gender' => 'Female',
                'hair_color' => 'Dark Brown',
                'origin_planet' => 'Themyscira',
                'description' => 'The Amazonian Warrior',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Batman',
                'secret_identity' => 'Bruce Wayne',
                'gender' => 'Male',
                'hair_color' => 'Black',
                'origin_planet' => 'Earth',
                'description' => 'The Dark Knight',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Spider-Man',
                'secret_identity' => 'Peter Parker',
                'gender' => 'Male',
                'hair_color' => 'Brown',
                'origin_planet' => 'Earth',
                'description' => 'The Friendly Neighborhood Hero',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Captain Marvel',
                'secret_identity' => 'Carol Danvers',
                'gender' => 'Female',
                'hair_color' => 'Blonde',
                'origin_planet' => 'Earth',
                'description' => 'The Mighty Avenger',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'The Flash',
                'secret_identity' => 'Barry Allen',
                'gender' => 'Male',
                'hair_color' => 'Blonde',
                'origin_planet' => 'Earth',
                'description' => 'The Scarlet Speedster',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Black Widow',
                'secret_identity' => 'Natasha Romanoff',
                'gender' => 'Female',
                'hair_color' => 'Red',
                'origin_planet' => 'Earth',
                'description' => 'The Spy and Avenger',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Aquaman',
                'secret_identity' => 'Arthur Curry',
                'gender' => 'Male',
                'hair_color' => 'Blonde',
                'origin_planet' => 'Atlantis',
                'description' => 'The King of the Seven Seas',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Storm',
                'secret_identity' => 'Ororo Munroe',
                'gender' => 'Female',
                'hair_color' => 'White',
                'origin_planet' => 'Earth',
                'description' => 'The Weather Goddess',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name' => 'Green Lantern',
                'secret_identity' => 'Hal Jordan',
                'gender' => 'Male',
                'hair_color' => 'Brown',
                'origin_planet' => 'Earth',
                'description' => 'The Emerald Knight',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Supergirl',
                'secret_identity' => 'Kara Zor-El',
                'gender' => 'Female',
                'hair_color' => 'Blonde',
                'origin_planet' => 'Krypton',
                'description' => 'The Girl of Steel',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Iron Man',
                'secret_identity' => 'Tony Stark',
                'gender' => 'Male',
                'hair_color' => 'Black',
                'origin_planet' => 'Earth',
                'description' => 'The Armored Avenger',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name' => 'Hulk',
                'secret_identity' => 'Bruce Banner',
                'gender' => 'Male',
                'hair_color' => 'Green',
                'origin_planet' => 'Earth',
                'description' => 'The Green Goliath',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Black Panther',
                'secret_identity' => "T'Challa",
                'gender' => 'Male',
                'hair_color' => 'Bald',
                'origin_planet' => 'Earth',
                'description' => 'The King of Wakanda',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Doctor Strange',
                'secret_identity' => 'Stephen Strange',
                'gender' => 'Male',
                'hair_color' => 'Black',
                'origin_planet' => 'Earth',
                'description' => 'The Sorcerer Supreme',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Deadpool',
                'secret_identity' => 'Wade Wilson',
                'gender' => 'Male',
                'hair_color' => 'None (masked)',
                'origin_planet' => 'Earth',
                'description' => 'The Merc with a Mouth',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
            
                        
            
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
