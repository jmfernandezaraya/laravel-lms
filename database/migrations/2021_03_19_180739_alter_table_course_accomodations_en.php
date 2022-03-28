<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableCourseAccomodationsEn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_accommodations_en', function (Blueprint $table) {
            $table->foreign('course_unique_id')->references('unique_id')->on('courses_en')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_accommodations_en', function (Blueprint $table) {
            //
        });
    }
}
