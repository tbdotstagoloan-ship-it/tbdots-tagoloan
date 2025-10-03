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
        Schema::create('tbl_tb_classifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->string('clas_bacteriological_status');
            $table->string('clas_drug_resistance_status');
            $table->string('clas_other_drug_resistant')->nullable();
            $table->string('clas_anatomical_site');
            $table->string('clas_site_other')->nullable();
            $table->string('clas_registration_group');

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
        Schema::dropIfExists('tbl_tb_classifications');
    }
};
