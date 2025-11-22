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
        Schema::table('tbl_laboratory_tests', function (Blueprint $table) {
            $table->string('lab_other_test_name')->nullable()->after('lab_tst_result');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_laboratory_tests', function (Blueprint $table) {
            $table->dropColumn('lab_other_test_name');
    });
    }
};
