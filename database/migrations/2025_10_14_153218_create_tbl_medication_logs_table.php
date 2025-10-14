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
        Schema::create('tbl_medication_logs', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->date('date');
            $table->timestamps();

            // Index for faster queries
            $table->index(['username', 'date']);
            
            // Prevent duplicate entries for same user and date
            $table->unique(['username', 'date']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_medication_logs');
    }
};
