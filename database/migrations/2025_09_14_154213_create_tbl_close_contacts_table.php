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
        Schema::create('tbl_close_contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->string('con_name')->nullable();
            $table->string('con_age')->nullable();
            $table->string('con_sex')->nullable();
            $table->string('con_relationship')->nullable();
            $table->date('con_initial_screening')->nullable();
            $table->date('con_follow_up')->nullable();
            $table->string('con_remarks')->nullable();

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
        Schema::dropIfExists('tbl_close_contacts');
    }
};
