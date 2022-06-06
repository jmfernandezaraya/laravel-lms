<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AccomodationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		$sevendays = Carbon::now();
		$fourdays = Carbon::now();
		$sevendays =$sevendays->add(7, 'days');
		$fourdays = $fourdays->add(14, 'days');
		\DB::table('course_accommodations_en')->insert([
			'course_unique_id' => 34334343443,
			'type' => 'Type',
			'room_type' => 'Single',
			'meal' => '3 times',
			'age_range' => 21,
			'placement_fee' => 1000,
			'duration_fee' => null,
			
			'deposit_fee' => 500,
			'special_diet_fee' => 300,
			'special_diet_note' => 'Diet Note',
			'fee_per_week' => 1000,
			'accomodation_start_fee' => $sevendays,
			'accomodation_end_fee' => $fourdays,
			
			'discount_per_week' => '10%',
			'discount_start_date' => $sevendays,
			'discount_end_date' => $fourdays,
			'summer_fee_per_week' => 1000,
			'summer_fee_start_date' => $sevendays,
			'summer_fee_end_date' => $fourdays,
			
			'peak_time_fee_per_week' => 1000,
			'peak_time_fee_start_date' => $sevendays,
			'peak_time_fee_end_date' => $fourdays,
			'christmas_fee_per_week' => 1000,
			'christmas_fee_start_date' => $sevendays,
			'christmas_fee_end_date' => $fourdays,
			
			'under_age' => 20,
			'under_age_fee_per_week' => 1000,
			'airport_name' => 'airport',
			'sevice_name' => 'service',
			'service_fee' => 500,
			'program_duration_fee' => null,
			
			'medical_insurance_fee' => 200,
			'medical_start_date' => $sevendays,
			'medical_end_date' => $fourdays,
			'medical_insurance_note' =>'Medical Note',

			'custodian_fee' => 1000,
			
			'created_at' => now(),
			'updated_at' => now(),
		]);
    }
}