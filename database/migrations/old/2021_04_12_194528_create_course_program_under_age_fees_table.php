<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseProgramUnderAgeFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_program_under_age_fees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('course_program_id')->index('course_program_under_age_fee_en_course_program_id_foreign');
            $table->string('under_age');
            $table->bigInteger('under_age_fee_per_week');
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
        Schema::dropIfExists('course_program_under_age_fees');
    }
}