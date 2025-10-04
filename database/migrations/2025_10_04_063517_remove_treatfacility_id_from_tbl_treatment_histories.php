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
        Schema::table('tbl_treatment_histories', function (Blueprint $table) {
            $table->dropForeign(['treatfacility_id']);
            $table->dropColumn('treatfacility_id');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_treatment_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('treatfacility_id')->nullable();
        });
    }

};
