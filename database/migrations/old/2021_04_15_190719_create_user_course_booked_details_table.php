<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCourseBookedDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_course_booked_details', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->string('fname')->nullable();
            $table->string('mname')->nullable();
            $table->string('lname')->nullable();
            $table->date('dob')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('country')->nullable();
            $table->string('gender')->nullable();
            $table->string('nationality')->nullable();
            $table->string('passport_number')->nullable();
            $table->date('passport_date_of_issue')->nullable();
            $table->date('passport_date_of_expiry')->nullable();
            $table->longText('passport_copy')->nullable();
            $table->string('study_finance')->nullable();
            $table->string('financial_guarantee')->nullable();
            $table->string('id_number')->nullable();  //lqama number            $table->string('level_of_language')->nullable();
            $table->string('bank_statement')->nullable();
            $table->string('mobile')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
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
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
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
        Schema::dropIfExists('user_course_booked_details');
    }
}
