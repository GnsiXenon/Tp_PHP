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
        Schema::create('superpowers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        DB::table('superpowers')->insert([
            ['name' => 'Super Strength'],
            ['name' => 'Super Speed'],
            ['name' => 'Flight'],
            ['name' => 'Invisibility'],
            ['name' => 'Telepathy'],
            ['name' => 'Teleportation'],
            ['name' => 'Telekinesis'],
            ['name' => 'Shapeshifting'],
            ['name' => 'Invulnerability'],
            ['name' => 'Teleportation'],
            ['name' => 'Regeneration'],
            ['name' => 'Time Travel'],
            ['name' => 'Mind Control'],
            ['name' => 'Heat Vision'],
            ['name' => 'X-Ray Vision'],
            ['name' => 'Energy Blasts'],
            ['name' => 'Force Fields'],
            ['name' => 'Magic'],
            ['name' => 'Sonic Scream'],
            ['name' => 'Elasticity'],
            ['name' => 'Matter Manipulation'],
            ['name' => 'Animal Communication'],
            ['name' => 'Weather Manipulation'],
            ['name' => 'Wallcrawling'],
            ['name' => 'Elemental Control'],
            ['name' => 'Phasing'],
            ['name' => 'Invisibility'],
            ['name' => 'Vortex Breath'],
            ['name' => 'Super Senses'],
            ['name' => 'Super Durability'],
            ['name' => 'Super Stamina'],
            ['name' => 'Super Agility'],
            ['name' => 'Super Reflexes'],
            ['name' => 'Super Hearing'],
            ['name' => 'Super Touch'],
            ['name' => 'Super Smell'],
            ['name' => 'Super Tracking'],
            ['name' => 'Super Accuracy'],
            ['name' => 'Super Memory'],
            ['name' => 'Super Intelligence'],
            ['name' => 'Super Wisdom'],
            ['name' => 'Super Charisma'],
            ['name' => 'Super Combat'],
            ['name' => 'Super Accuracy'],
            ['name' => 'Super Memory'],
            ['name' => 'Super Intelligence'],
            ['name' => 'Super Wisdom'],
            ['name' => 'Super Charisma'],
            ['name' => 'Super Combat'],
            ['name' => 'Super Accuracy']

        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('superpowers');
    }
};
