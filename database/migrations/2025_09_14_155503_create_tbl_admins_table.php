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
        Schema::create('tbl_admins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('diagfacility_id');
            $table->unsignedBigInteger('patient_id');
            $table->string('adm_username');
            $table->string('adm_password');

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
        Schema::dropIfExists('tbl_admins');
    }
};
