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
        Schema::create('tbl_treatment_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('treatfacility_id');
            $table->unsignedBigInteger('patient_id');
            $table->date('hist_date_tx_started')->nullable();
            $table->string('hist_treatment_unit')->nullable();
            $table->string('hist_regimen')->nullable();
            $table->string('hist_outcome')->nullable();

            $table->foreign('treatfacility_id')
                    ->references('id')
                    ->on('tbl_treatment_facilities')
                    ->onDelete('cascade');
                    
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
        Schema::dropIfExists('tbl_treatment_histories');
    }
};
