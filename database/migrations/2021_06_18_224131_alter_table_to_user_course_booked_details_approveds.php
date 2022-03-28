<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableToUserCourseBookedDetailsApproveds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('user_course_booked_details_approveds');
        Schema::create('user_course_booked_details_approveds', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\UserCourseBookedDetails::class);
            $table->boolean('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_course_booked_details_approveds', function (Blueprint $table) {
            //
        });
    }
}
