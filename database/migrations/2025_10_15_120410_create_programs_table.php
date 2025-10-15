<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('program_name');
            $table->string('program_code');
            $table->string('campus');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('duration'); // e.g. "3 Months 5 Days"
            $table->string('amount');
            $table->longText('summary');
            $table->string('status')->default('Ongoing');
            $table->string('action')->default('Active');
            $table->string('created_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
