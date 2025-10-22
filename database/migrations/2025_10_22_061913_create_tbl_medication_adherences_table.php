<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_medication_adherences', function (Blueprint $table) {
            $table->id();
            $table->string('username'); // username or patient identifier
            $table->date('date');       // medication date
            $table->enum('status', ['taken', 'missed']); // adherence status
            $table->timestamps();

            // Optional: prevent duplicate entries for same day/user
            $table->unique(['username', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_medication_adherences');
    }
};
