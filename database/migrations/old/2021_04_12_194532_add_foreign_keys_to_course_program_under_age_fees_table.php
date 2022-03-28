<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCourseProgramUnderAgeFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_program_under_age_fees', function (Blueprint $table) {
            $table->foreign('course_program_id')->references('unique_id')->on('courses_program_en')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_program_under_age_fees', function (Blueprint $table) {
            $table->dropForeign('course_program_under_age_fees_course_program_id_foreign');
        });
    }
}