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
        Schema::create('tbl_sputum_monitorings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->date('sput_date_collected')->nullable();
            $table->string('sput_smear_result')->nullable();
            $table->string('sput_xpert_result')->nullable();

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
        Schema::dropIfExists('tbl_sputum_monitorings');
    }
};
