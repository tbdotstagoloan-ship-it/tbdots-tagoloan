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
        Schema::create('tbl_prescribed_drugs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->date('drug_start_date');
            $table->string('drug_name');
            $table->string('drug_strength');
            $table->string('drug_unit');
            $table->date('drug_con_date')->nullable();
            $table->string('drug_con_name')->nullable();
            $table->string('drug_con_strength')->nullable();
            $table->string('drug_con_unit')->nullable();

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
        Schema::dropIfExists('tbl_prescribed_drugs');
    }
};
