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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        DB::table('vehicles')->insert([
            ['name' => 'Car'],
            ['name' => 'Bike'],
            ['name' => 'Bus'],
            ['name' => 'Train'],
            ['name' => 'Batmobile'],
            ['name' => 'Quinjet'],
            ['name' => 'PoliceCar'],
            
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
