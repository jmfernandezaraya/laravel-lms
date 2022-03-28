<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseAccomodationsEnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_accommodations_en', function (Blueprint $table) {
            $table->unsignedBigInteger('unique_id')->primary();
            $table->unsignedBigInteger('course_unique_id')->index('course_accommodations_en_course_unique_id_foreign');
            $table->string('type')->nullable();
            $table->string('room_type')->nullable();
            $table->string('meal')->nullable();
            $table->string('age_range')->nullable();
            $table->string('placement_fee')->nullable();
            $table->string('program_duration')->nullable();
            $table->string('deposit_fee')->nullable();
            $table->string('custodian_fee')->nullable();
            $table->string('custodian_age_range', 500)->nullable();
            $table->string('special_diet_fee')->nullable();
            $table->string('special_diet_note')->nullable();
            $table->string('fee_per_week')->nullable();
            $table->string('start_week')->nullable();
            $table->string('end_week')->nullable();
            $table->string('accommodation_start_date', 200);
            $table->string('accommodation_end_date', 200);
            $table->string('discount_per_week')->nullable();
            $table->string('accommodation_symbol', 20)->nullable();
            $table->string('discount_start_date')->nullable();
            $table->string('discount_end_date')->nullable();
            $table->string('summer_fee_per_week')->nullable();
            $table->string('summer_fee_start_date')->nullable();
            $table->string('summer_fee_end_date')->nullable();
            $table->string('peak_time_fee_per_week')->nullable();
            $table->string('peak_time_fee_start_date')->nullable();
            $table->string('peak_time_fee_end_date')->nullable();
            $table->string('christmas_fee_per_week')->nullable();
            $table->string('christmas_fee_start_date')->nullable();
            $table->string('christmas_fee_end_date')->nullable();
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
        Schema::dropIfExists('course_accommodations_en');
    }
}