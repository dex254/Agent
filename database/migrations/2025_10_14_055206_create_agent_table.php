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
        Schema::create('agent', function (Blueprint $table) {
            $table->id();

            // Required fields
            $table->string('email')->unique();
            $table->string('password');

            // Optional fields (nullable)
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('status')->nullable();
            $table->timestamp('login_time')->nullable();
            $table->timestamp('logout_time')->nullable();
            $table->string('profile')->nullable();
            $table->text('activity')->nullable();
            $table->string('securitykey')->nullable();
            $table->string('campus')->nullable();
             $table->string('role')->nullable();
           $table->string('temp_password')->nullable();
            $table->timestamp('temp_password_expiry')->nullable();
            $table->string('reset_token', 100)->nullable()->unique();

            // Optional if you use "remember me" feature
            $table->rememberToken();

            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agent');
    }
};
