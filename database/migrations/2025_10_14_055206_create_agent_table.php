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
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->string('status')->default('pending');
            $table->string('role')->default('user');
            $table->timestamp('login_time')->nullable();
            $table->timestamp('logout_time')->nullable();
            $table->string('profile')->nullable();
            $table->text('activity')->nullable();
            $table->string('securitykey')->nullable();
            $table->string('campus')->nullable();

            // 🔐 Security Features
            $table->string('temp_password')->nullable();
            $table->timestamp('temp_password_expiry')->nullable();
            $table->string('reset_token', 100)->nullable();
            $table->integer('failed_attempts')->default(0);
            $table->timestamp('lockout_until')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->boolean('is_online')->default(false);
           

            $table->rememberToken();
            $table->timestamps();
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
