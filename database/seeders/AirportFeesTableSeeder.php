<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class AirportFeesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('airport_fees')->delete();
        
        \DB::table('airport_fees')->insert(array (
            0 => 
            array (
                'unique_id' => '2',
                'course_unique_id' => '340',
                'name_en' => 'Airprota name',
                'name_ar' => NULL,
                'service_name_en' => 'service',
                'service_name_ar' => NULL,
                'service_fee' => '93.00',
                'week_selected_fee' => '10',
                'created_at' => '2021-04-11 20:52:17',
                'updated_at' => '2021-04-11 20:52:17',
            ),
            1 => 
            array (
                'unique_id' => '3',
                'course_unique_id' => '627',
                'name_en' => 'London',
                'name_ar' => NULL,
                'service_name_en' => 'Pickup',
                'service_name_ar' => NULL,
                'service_fee' => '100.00',
                'week_selected_fee' => '10',
                'created_at' => '2021-04-12 13:02:06',
                'updated_at' => '2021-04-12 13:02:06',
            ),
            2 => 
            array (
                'unique_id' => '4',
                'course_unique_id' => '627',
                'name_en' => 'London',
                'name_ar' => NULL,
                'service_name_en' => 'Drop off',
                'service_name_ar' => NULL,
                'service_fee' => '100.00',
                'week_selected_fee' => '10',
                'created_at' => '2021-04-12 13:02:06',
                'updated_at' => '2021-04-12 13:02:06',
            ),
            3 => 
            array (
                'unique_id' => '5',
                'course_unique_id' => '627',
                'name_en' => 'Manchester',
                'name_ar' => NULL,
                'service_name_en' => 'Drop off',
                'service_name_ar' => NULL,
                'service_fee' => '100.00',
                'week_selected_fee' => '10',
                'created_at' => '2021-04-12 13:02:06',
                'updated_at' => '2021-04-12 13:02:06',
            ),
            4 => 
            array (
                'unique_id' => '6',
                'course_unique_id' => '627',
                'name_en' => 'Manchester',
                'name_ar' => NULL,
                'service_name_en' => 'Pick up',
                'service_name_ar' => NULL,
                'service_fee' => '100.00',
                'week_selected_fee' => '10',
                'created_at' => '2021-04-12 13:02:06',
                'updated_at' => '2021-04-12 13:02:06',
            ),
        ));
        
        
    }
}