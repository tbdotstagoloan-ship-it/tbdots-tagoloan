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
        Schema::create('tbl_hiv_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->string('hiv_information')->nullable();
            $table->date('hiv_test_date')->nullable();
            $table->date('hiv_confirmatory_test_date')->nullable();
            $table->string('hiv_result')->nullable();
            $table->string('hiv_art_started')->nullable();
            $table->string('hiv_cpt_started')->nullable();

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
        Schema::dropIfExists('tbl_hiv_infos');
    }
};
