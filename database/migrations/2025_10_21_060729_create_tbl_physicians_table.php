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
        Schema::create('tbl_physicians', function (Blueprint $table) {
            $table->id();
            $table->string('phy_first_name');
            $table->string('phy_last_name');
            $table->string('phy_sex');
            $table->date('phy_dob');
            $table->string('phy_designation');
            $table->string('phy_specialty')->nullable();
            $table->string('phy_contact');
            $table->string('phy_address');
            $table->string('phy_email')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_physicians');
    }
};
