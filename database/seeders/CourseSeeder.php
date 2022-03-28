<?php

namespace Database\Seeders;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
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
		\DB::table('courses_en')->insert([		
			'unique_id' => 34334343443,
			'language' => 'English',
			'program_type' => 'Offline',
			'school_id' => 1,
			'currency' => 'USD',
			'program_name' => 'Program1',			
			
			'program_level' => 1,
			'lessons_per_week' => 2,
			'hours_per_week' => 4,
			'study_time' => 'Morning',
			'every_day' => 'Monday',
			'about_program' => 'Good Program',			
			
			'program_registration_fee' => 3000,
			'program_duration' => null,
			'age_range' => 21,
			'courier_fee' => 22,
			'about_courier' => 'USD',
			'program_cost' => 300,			
			
			'program_duration_start' => $sevendays,
			'program_duration_end' => $fourdays,
			'discount_per_week' => '10%',
			'discount_start_date' => $sevendays,
			'discount_end_date' => $fourdays,
			'how_many_week_free' => 3,
			
			'summer_fee_per_week' => 6000,
			'summer_fee_start_date' => $sevendays,
			'summer_fee_end_date' => $fourdays,
			'peak_time_fee_per_week' => 1000,
			'peak_time_start_date' => $sevendays,
			'peak_time_end_date' => $fourdays,			
			
			'under_age' => 22,
			'underage_fee_per_week' =>1000,
			'text_book_fee' => 1000,
			'text_fee_start_date' => $sevendays,
			'text_fee_end_date' => $fourdays,
			'text_book_note' => 'textbooknote',			
			
			'created_at' => now(),
			'updated_at' => now(),
		]);
    }
}