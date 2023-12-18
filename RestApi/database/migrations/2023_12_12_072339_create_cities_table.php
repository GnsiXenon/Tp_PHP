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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        DB::table('cities')->insert([
            ['name' => 'New York'],
            ['name' => 'London'],
            ['name' => 'Gotham'],
            ['name' => 'Metropolis'],
            ['name' => 'Wakanda'],
            ['name' => 'Asgard'],
            ['name' => 'Atlantis'],
            ['name' => 'Themyscira'],
            ['name' => 'Kamar-Taj'],
            ['name' => 'Xandar'],
            ['name' => 'Knowhere'],
            ['name' => 'Sokovia'],
            ['name' => 'Madripoor'],
            ['name' => 'Genosha'],
            ['name' => 'Latveria'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
