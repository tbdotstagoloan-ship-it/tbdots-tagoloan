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
        Schema::create('tbl_adherences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->date('pha_intensive_start');
            $table->date('pha_intensive_end')->nullable();
            $table->date('pha_continuation_start')->nullable();
            $table->date('pha_continuation_end')->nullable();
            $table->decimal('pha_weight', 5,2)->nullable();
            $table->decimal('pha_child_height', 5,2)->nullable();

            $table->foreign('patient_id')
                    ->references('id')
                    ->on('tbl_patients')
                    ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_adherences');
    }
};
