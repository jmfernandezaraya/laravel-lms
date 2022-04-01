<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Courses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		Schema::create('courses_en', function(Blueprint $table){			
			$table->bigIncrements('id');
			$table->string('language')->nullable();
			$table->string('program_type')->nullable();
			$table->string('school_id')->nullable();
			$table->string('currency')->nullable();
			$table->string('program_name')->nullable();
			$table->string('program_level')->nullable();
			$table->string('lessons_per_week')->nullable();
			$table->string('hours_per_week')->nullable();
			$table->string('study_time')->nullable();
			$table->string('every_day')->nullable();
			$table->string('about_program')->nullable();
			$table->string('program_registration_fee')->nullable();
			$table->string('program_duration')->nullable();
			$table->string('age_range')->nullable();
			$table->string('courier_fee')->nullable();
			$table->string('about_courier')->nullable();
			$table->string('program_cost')->nullable();
			
			$table->string('program_duration_start')->nullable();
			
			$table->string('program_duration_end')->nullable();
			$table->string('discount_per_week')->nullable();
			$table->string('how_many_week_free')->nullable();	//start and end date 
			$table->string('summer_fee_per_week')->nullable();
			$table->string('peak_time_fee_per_week')->nullable();
			$table->string('under_age')->nullable();
			$table->string('under_age_fee_per_week')->nullable();
			$table->string('text_book_fee')->nullable();
			$table->string('text_fee_start_date')->nullable();
			$table->string('text_fee_end_date')->nullable();
			$table->string('text_book_note')->nullable();
			
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

