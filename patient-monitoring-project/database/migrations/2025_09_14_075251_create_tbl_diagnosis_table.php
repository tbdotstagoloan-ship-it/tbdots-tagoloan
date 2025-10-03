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
        Schema::create('tbl_diagnosis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->date('diag_diagnosis_date');
            $table->date('diag_notification_date');
            $table->string('diag_tb_case_no');
            $table->string('diag_attending_physician');
            $table->string('diag_referred_to')->nullable();
            $table->string('diag_address')->nullable();
            $table->string('diag_facility_code')->nullable();
            $table->string('diag_province')->nullable();
            $table->string('diag_region')->nullable();

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
        Schema::dropIfExists('tbl_diagnosis');
    }
};
