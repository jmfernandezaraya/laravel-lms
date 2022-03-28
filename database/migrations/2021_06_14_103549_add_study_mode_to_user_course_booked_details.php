<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class addStudyModeToUserCourseBookedDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_course_booked_details', function (Blueprint $table) {
            $table->string('study_mode_selected');
            $table->integer('age_selected');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_course_booked_details', function (Blueprint $table) {
            //
        });
    }
}
