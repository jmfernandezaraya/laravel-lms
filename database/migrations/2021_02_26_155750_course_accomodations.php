<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CourseAccomodations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		Schema::create('course_accommodations_en', function(Blueprint $table){
			
		$table->string('type')->nullable();
			$table->string('room_type')->nullable();
			$table->string('meal')->nullable();
			$table->string('age_range')->nullable();
			$table->string('placement_fee')->nullable();
			$table->string('duration_fee')->nullable();
			$table->string('deposit_fee')->nullable();
			$table->string('custodian_fee')->nullable();
			$table->string('special_diet_fee')->nullable();
			$table->string('special_diet_note')->nullable();
			$table->string('fee_per_week')->nullable();
			$table->string('accomodation_start_fee')->nullable();
			$table->string('accomodation_end_fee')->nullable();
			$table->string('discount_per_week')->nullable();
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
			$table->string('under_age')->nullable();
			$table->string('under_age_fee_per_week')->nullable();
			
			$table->string('airport_name')->nullable();
			$table->string('sevice_name')->nullable();
			$table->string('service_fee')->nullable();
			$table->string('program_duration_fee')->nullable();
			$table->string('medical_insurance_fee')->nullable();
			$table->string('medical_start_date')->nullable();
			$table->string('medical_end_date')->nullable();
			$table->string('medical_insurance_note')->nullable();
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
        //
    }
}
