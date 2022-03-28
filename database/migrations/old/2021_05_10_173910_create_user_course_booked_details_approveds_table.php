<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCourseBookedDetailsApprovedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('user_course_booked_details_approveds');
        Schema::create('user_course_booked_details_approveds', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('fname')->nullable();
            $table->foreignId('user_course_id')->references('id')->on('user_course_booked_details')->cascadeOnDelete();
            $table->string('mname')->nullable();
            $table->string('lname')->nullable();
            $table->string('country')->nullable();
            $table->string('gender')->nullable();
            $table->string('nationality')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('address')->nullable();
            $table->string('post_code')->nullable();
            $table->string('city_contact')->nullable();
            $table->string('country_contact')->nullable();
            $table->string('full_name_emergency')->nullable();
            $table->string('relative_emergency')->nullable();
            $table->string('mobile_emergency')->nullable();
            $table->string('telephone_emergency')->nullable();
            $table->string('email_emergency')->nullable();
            $table->string('heard_where')->nullable();
            $table->string('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_course_booked_details_approveds');
    }
}
