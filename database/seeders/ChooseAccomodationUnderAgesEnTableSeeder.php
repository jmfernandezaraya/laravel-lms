<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class ChooseAccommodationUnderAgesEnTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('choose_accommodation_under_ages_en')->delete();
        
        \DB::table('choose_accommodation_under_ages_en')->insert(array (
            0 => 
            array (
                'id' => '2',
                'unique_id' => '1616592230',
                'age' => '12',
                'created_at' => '2021-03-24 09:23:50',
                'updated_at' => '2021-03-24 09:23:50',
            ),
            1 => 
            array (
                'id' => '3',
                'unique_id' => '87',
                'age' => '14',
                'created_at' => '2021-04-11 18:13:48',
                'updated_at' => '2021-04-11 18:13:48',
            ),
            2 => 
            array (
                'id' => '4',
                'unique_id' => '410',
                'age' => '15',
                'created_at' => '2021-04-11 18:13:54',
                'updated_at' => '2021-04-11 18:13:54',
            ),
            3 => 
            array (
                'id' => '5',
                'unique_id' => '108',
                'age' => '16',
                'created_at' => '2021-04-11 18:14:00',
                'updated_at' => '2021-04-11 18:14:00',
            ),
            4 => 
            array (
                'id' => '6',
                'unique_id' => '83',
                'age' => '17',
                'created_at' => '2021-04-11 18:14:05',
                'updated_at' => '2021-04-11 18:14:05',
            ),
        ));
        
        
    }
}