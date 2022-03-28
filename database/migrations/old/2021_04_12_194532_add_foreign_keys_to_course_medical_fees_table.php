<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCourseMedicalFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_medical_fees', function (Blueprint $table) {
            $table->foreign('course_unique_id')->references('unique_id')->on('courses_en')->onUpdate('RESTRICT')->onDelete('CASCADE');
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
            $table->dropForeign('course_medical_fees_course_id_foreign');
        });
    }
}