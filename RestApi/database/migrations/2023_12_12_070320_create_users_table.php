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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name of the user
            $table->string('email')->unique(); // Email of the user
            $table->boolean('email_verified')->default(false); // Email verified of the user
            $table->string('password'); // Password of the user
            $table->rememberToken(); // Remember token for the user
            $table->string('api_token', 80)->unique()->nullable()->default(null); // API token for the user
            $table->string('avatar')->nullable(); // Avatar of the user
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
