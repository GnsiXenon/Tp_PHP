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
        Schema::create('gadgets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        DB::table('gadgets')->insert([
            ['name' => 'Shield'],
            ['name' => 'Mjolnir'],
            ['name' => 'Arc Reactor'],
            ['name' => 'Wakandan Shield'],
            ['name' => 'Batarang'],
            ['name' => 'Lasso Of Truth'],
            ['name' => 'Utility Belt'],
            ['name' => 'Web Shooters'],
            ['name' => 'Eye Of Agamotto'],
            ['name' => 'Infinity Gauntlet'],
            ['name' => 'Tesseract'],        
        ]);
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gadgets');
    }
};
