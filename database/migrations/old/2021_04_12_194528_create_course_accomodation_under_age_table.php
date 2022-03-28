<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseAccommodationUnderAgeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_accommodation_under_age', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('accom_id')->index('course_accommodation_under_age_accom_id_foreign');
            $table->longText('under_age');
            $table->bigInteger('under_age_fees');
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
        Schema::dropIfExists('course_accommodation_under_age');
    }
}