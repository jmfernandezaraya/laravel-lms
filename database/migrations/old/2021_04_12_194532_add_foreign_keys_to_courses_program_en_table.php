<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCoursesProgramEnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_programs', function (Blueprint $table) {
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
        Schema::table('course_programs', function (Blueprint $table) {
            $table->dropForeign('course_programs_course_unique_id_foreign');
        });
    }
}