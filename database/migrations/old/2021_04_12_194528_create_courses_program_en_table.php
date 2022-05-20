<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesProgramEnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_programs', function (Blueprint $table) {
            $table->unsignedBigInteger('unique_id')->primary();
            $table->unsignedBigInteger('course_unique_id')->index('course_programs_course_unique_id_foreign');
            $table->longText('program_name');
            $table->string('program_registration_fee', 500)->nullable();
            $table->string('program_duration', 200)->nullable();
            $table->string('program_age_range', 200)->nullable();
            $table->string('courier_fee', 200)->nullable();
            $table->string('about_courier', 500)->nullable();
            $table->string('program_cost')->nullable();
            $table->string('program_duration_start')->nullable();
            $table->string('program_duration_end')->nullable();
            $table->string('program_start_date', 200)->nullable();
            $table->string('program_end_date', 200)->nullable();
            $table->string('discount_per_week')->nullable();
            $table->string('discount_start_date', 500)->nullable();
            $table->string('discount_end_date', 500)->nullable();
            $table->string('x_week_selected')->nullable();
            $table->string('x_week_start_date')->nullable();
            $table->string('x_week_end_date')->nullable();
            $table->string('how_many_week_free')->nullable();
            $table->string('summer_fee_per_week')->nullable();
            $table->string('summer_fee_start_date', 500)->nullable();
            $table->string('summer_fee_end_date', 500)->nullable();
            $table->string('peak_time_fee_per_week')->nullable();
            $table->string('peak_time_start_date', 500)->nullable();
            $table->string('peak_time_end_date', 500)->nullable();
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
        Schema::dropIfExists('course_programs');
    }
}