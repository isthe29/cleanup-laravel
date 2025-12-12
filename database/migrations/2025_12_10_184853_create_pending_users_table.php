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
        Schema::create('pending_users', function (Blueprint $table) {
            $table->increments('usr_id'); // Primary key, auto-increment
            $table->string('usr_name', 50)->nullable();
            $table->string('password', 255);
            $table->string('email')->unique();
            $table->string('remember_token', 100)->nullable();
            $table->enum('registered_as', ['Volunteer', 'Organizer']);
            $table->string('verification_token', 100)->unique(); // Token for email verification
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_users');
    }
};
