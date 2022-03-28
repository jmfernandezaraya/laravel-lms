<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUserCourseBookedDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_course_booked_details', function (Blueprint $table) {
            $table->string('legal_guardian_name')->after('signature')->nullable();
            $table->string('legal_id_number')->after('legal_guardian_name')->nullable();
            $table->string('legal_mobile')->after('legal_id_number')->nullable();
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
