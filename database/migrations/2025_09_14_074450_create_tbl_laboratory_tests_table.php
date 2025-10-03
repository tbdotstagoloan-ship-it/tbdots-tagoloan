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
        Schema::create('tbl_laboratory_tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('diagfacility_id');
            $table->unsignedBigInteger('patient_id');
            $table->date('lab_xpert_test_date');
            $table->string('lab_xpert_result');
            $table->date('lab_smear_test_date')->nullable();
            $table->string('lab_smear_result')->nullable();
            $table->date('lab_cxray_test_date');
            $table->string('lab_cxray_result');
            $table->date('lab_tst_test_date')->nullable();
            $table->string('lab_tst_result')->nullable();
            $table->date('lab_other_test_date')->nullable();
            $table->string('lab_other_result')->nullable();


            $table->foreign('diagfacility_id')
                    ->references('id')
                    ->on('tbl_diagnosing_facilities')
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
        Schema::dropIfExists('tbl_laboratory_tests');
    }
};
