<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCourseAccommodationUnderAgeTable extends Migration
{
    /**course_accommodations

     * Run the migrations.

     *

     * @return void

     */
    public function up()
    {
        Schema::table('course_accommodation_under_age', function (Blueprint $table) {
            $table->foreign('accom_id')->references('unique_id')->on('course_accommodations_en')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_accommodation_under_age', function (Blueprint $table) {
            $table->dropForeign('course_accommodation_under_age_accom_id_foreign');
        });
    }
}