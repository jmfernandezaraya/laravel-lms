<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class CourseAccommodationUnderAgeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('course_accommodation_under_age')->delete();
        
        \DB::table('course_accommodation_under_age')->insert(array (
            0 => 
            array (
                'id' => '24',
                'accom_id' => '161794004689',
                'under_age' => '["12"]',
                'under_age_fee_per_week' => '132',
                'created_at' => '2021-04-08 23:52:45',
                'updated_at' => '2021-04-08 23:52:45',
            ),
            1 => 
            array (
                'id' => '25',
                'accom_id' => '161794004689',
                'under_age' => '["12"]',
                'under_age_fee_per_week' => '13',
                'created_at' => '2021-04-08 23:52:45',
                'updated_at' => '2021-04-08 23:52:45',
            ),
            2 => 
            array (
                'id' => '26',
                'accom_id' => '16179461537',
                'under_age' => '["12"]',
                'under_age_fee_per_week' => '13',
                'created_at' => '2021-04-09 11:00:37',
                'updated_at' => '2021-04-09 11:00:37',
            ),
            3 => 
            array (
                'id' => '27',
                'accom_id' => '16179461537',
                'under_age' => '["12"]',
                'under_age_fee_per_week' => '13',
                'created_at' => '2021-04-09 11:00:37',
                'updated_at' => '2021-04-09 11:00:37',
            ),
            4 => 
            array (
                'id' => '28',
                'accom_id' => '161794637974',
                'under_age' => '["12"]',
                'under_age_fee_per_week' => '12',
                'created_at' => '2021-04-09 11:03:36',
                'updated_at' => '2021-04-09 11:03:36',
            ),
            5 => 
            array (
                'id' => '29',
                'accom_id' => '161794637974',
                'under_age' => '["12"]',
                'under_age_fee_per_week' => '13',
                'created_at' => '2021-04-09 11:03:36',
                'updated_at' => '2021-04-09 11:03:36',
            ),
            6 => 
            array (
                'id' => '30',
                'accom_id' => '161794637975',
                'under_age' => '["12"]',
                'under_age_fee_per_week' => '12',
                'created_at' => '2021-04-09 11:03:36',
                'updated_at' => '2021-04-09 11:03:36',
            ),
            7 => 
            array (
                'id' => '31',
                'accom_id' => '161794637975',
                'under_age' => '["12"]',
                'under_age_fee_per_week' => '13',
                'created_at' => '2021-04-09 11:03:36',
                'updated_at' => '2021-04-09 11:03:36',
            ),
            8 => 
            array (
                'id' => '32',
                'accom_id' => '161815352233',
                'under_age' => '["12","14"]',
                'under_age_fee_per_week' => '13',
                'created_at' => '2021-04-11 20:46:16',
                'updated_at' => '2021-04-11 20:46:16',
            ),
            9 => 
            array (
                'id' => '33',
                'accom_id' => '161815352233',
                'under_age' => '["16"]',
                'under_age_fee_per_week' => '13',
                'created_at' => '2021-04-11 20:46:16',
                'updated_at' => '2021-04-11 20:46:16',
            ),
            10 => 
            array (
                'id' => '34',
                'accom_id' => '161821230690',
                'under_age' => '["14","15"]',
                'under_age_fee_per_week' => '20',
                'created_at' => '2021-04-12 13:01:01',
                'updated_at' => '2021-04-12 13:01:01',
            ),
            11 => 
            array (
                'id' => '35',
                'accom_id' => '161821230690',
                'under_age' => '["16","17"]',
                'under_age_fee_per_week' => '10',
                'created_at' => '2021-04-12 13:01:01',
                'updated_at' => '2021-04-12 13:01:01',
            ),
            12 => 
            array (
                'id' => '36',
                'accom_id' => '161821230691',
                'under_age' => '["14","15"]',
                'under_age_fee_per_week' => '20',
                'created_at' => '2021-04-12 13:01:01',
                'updated_at' => '2021-04-12 13:01:01',
            ),
            13 => 
            array (
                'id' => '37',
                'accom_id' => '161821230691',
                'under_age' => '["16","17"]',
                'under_age_fee_per_week' => '10',
                'created_at' => '2021-04-12 13:01:01',
                'updated_at' => '2021-04-12 13:01:01',
            ),
        ));
        
        
    }
}