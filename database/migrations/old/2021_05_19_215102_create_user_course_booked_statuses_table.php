<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCourseBookedStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_course_booked_statuses', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->foreignId('user_course_booked_detail_id');
            $table->foreign('user_course_booked_detail_id')->on('user_course_booked_details')->references('id')->cascadeOnDelete();
            $table->string('status')->comment("received, process, files_sent_to_customer, customer_response, cancelled, refunded, completed");
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
        Schema::dropIfExists('user_course_booked_statuses');
    }
}
