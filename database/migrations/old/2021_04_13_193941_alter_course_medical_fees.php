<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCourseMedicalFees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_medical_fees', function (Blueprint $table) {
            $table->bigInteger('medical_start_date')->change();
            $table->bigInteger('medical_end_date')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_medical_fees', function (Blueprint $table) {
            //
        });
    }
}
