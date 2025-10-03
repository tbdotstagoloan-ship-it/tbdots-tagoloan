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
        Schema::create('tbl_patients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('diagfacility_id');
            $table->string('pat_full_name');
            $table->date('pat_date_of_birth');
            $table->string('pat_age');
            $table->string('pat_sex');
            $table->string('pat_civil_status');
            $table->string('pat_permanent_address');
            $table->string('pat_permanent_city_mun');
            $table->string('pat_permanent_province');
            $table->string('pat_permanent_region');
            $table->string('pat_permanent_zip_code');
            $table->string('pat_current_address');
            $table->string('pat_current_city_mun');
            $table->string('pat_current_province');
            $table->string('pat_current_region');
            $table->string('pat_current_zip_code');
            $table->string('pat_contact_number');
            $table->string('pat_other_contact')->nullable();
            $table->string('pat_philhealth_no')->nullable();
            $table->string('pat_nationality');

            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');

            $table->foreign('diagfacility_id')
                    ->references('id')
                    ->on('tbl_diagnosing_facilities')
                    ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_patients');
    }
};
