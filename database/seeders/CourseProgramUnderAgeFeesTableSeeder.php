<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class CourseProgramUnderAgeFeesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('course_program_under_age_fees')->delete();
        
        \DB::table('course_program_under_age_fees')->insert(array (
            0 => 
            array (
                'id' => '1',
                'course_program_id' => '161815306934',
                'under_age' => '["21","22","15"]',
                'underage_fee_per_week' => '12',
                'created_at' => '2021-04-11 20:35:18',
                'updated_at' => '2021-04-11 20:35:18',
            ),
            1 => 
            array (
                'id' => '2',
                'course_program_id' => '161815306935',
                'under_age' => '["21","22","15"]',
                'underage_fee_per_week' => '12',
                'created_at' => '2021-04-11 20:35:18',
                'updated_at' => '2021-04-11 20:35:18',
            ),
            2 => 
            array (
                'id' => '9',
                'course_program_id' => '161821205494',
                'under_age' => '["15","16"]',
                'underage_fee_per_week' => '20',
                'created_at' => '2021-04-12 12:55:02',
                'updated_at' => '2021-04-12 12:55:02',
            ),
            3 => 
            array (
                'id' => '10',
                'course_program_id' => '161821205494',
                'under_age' => '["17"]',
                'underage_fee_per_week' => '10',
                'created_at' => '2021-04-12 12:55:02',
                'updated_at' => '2021-04-12 12:55:02',
            ),
            4 => 
            array (
                'id' => '11',
                'course_program_id' => '161821205495',
                'under_age' => '["15","16"]',
                'underage_fee_per_week' => '20',
                'created_at' => '2021-04-12 12:55:02',
                'updated_at' => '2021-04-12 12:55:02',
            ),
            5 => 
            array (
                'id' => '12',
                'course_program_id' => '161821205495',
                'under_age' => '["17"]',
                'underage_fee_per_week' => '10',
                'created_at' => '2021-04-12 12:55:02',
                'updated_at' => '2021-04-12 12:55:02',
            ),
            6 => 
            array (
                'id' => '13',
                'course_program_id' => '161821205496',
                'under_age' => '["15","16"]',
                'underage_fee_per_week' => '20',
                'created_at' => '2021-04-12 12:55:02',
                'updated_at' => '2021-04-12 12:55:02',
            ),
            7 => 
            array (
                'id' => '14',
                'course_program_id' => '161821205496',
                'under_age' => '["17"]',
                'underage_fee_per_week' => '10',
                'created_at' => '2021-04-12 12:55:02',
                'updated_at' => '2021-04-12 12:55:02',
            ),
        ));
        
        
    }
}