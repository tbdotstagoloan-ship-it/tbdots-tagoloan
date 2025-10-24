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
        Schema::create('tbl_baseline_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->decimal('base_weight', 5,2);
            $table->decimal('base_height', 5,2);
            $table->string('base_blood_pressure');
            $table->string('base_pulse_rate');
            $table->string('base_temperature');
            $table->string('base_emergency_contact_name');
            $table->string('base_relationship');
            $table->string('base_contact_info');
            $table->string('base_diabetes_screening');
            $table->string('base_four_ps_beneficiary');
            $table->string('base_fbs_screening')->nullable();
            $table->date('base_date_tested')->nullable();
            $table->string('base_occupation');

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
        Schema::dropIfExists('tbl_baseline_infos');
    }
};
