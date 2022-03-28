<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class ChooseProgramAgeRangesEnTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('choose_program_age_ranges_en')->delete();
        
        \DB::table('choose_program_age_ranges_en')->insert(array (
            0 => 
            array (
                'id' => '7',
                'unique_id' => '1616592120',
                'age' => '23',
                'created_at' => '2021-03-24 09:22:00',
                'updated_at' => '2021-03-24 09:22:00',
            ),
            1 => 
            array (
                'id' => '8',
                'unique_id' => '1616592125',
                'age' => '26',
                'created_at' => '2021-03-24 09:22:05',
                'updated_at' => '2021-03-24 09:22:05',
            ),
            2 => 
            array (
                'id' => '9',
                'unique_id' => '909',
                'age' => '24',
                'created_at' => '2021-04-11 17:17:01',
                'updated_at' => '2021-04-11 17:17:01',
            ),
            3 => 
            array (
                'id' => '10',
                'unique_id' => '303',
                'age' => '25',
                'created_at' => '2021-04-11 17:17:07',
                'updated_at' => '2021-04-11 17:17:07',
            ),
            4 => 
            array (
                'id' => '11',
                'unique_id' => '253',
                'age' => '15',
                'created_at' => '2021-04-11 17:18:29',
                'updated_at' => '2021-04-11 17:18:29',
            ),
            5 => 
            array (
                'id' => '12',
                'unique_id' => '567',
                'age' => '16',
                'created_at' => '2021-04-11 17:18:35',
                'updated_at' => '2021-04-11 17:18:35',
            ),
            6 => 
            array (
                'id' => '13',
                'unique_id' => '237',
                'age' => '17',
                'created_at' => '2021-04-11 17:18:45',
                'updated_at' => '2021-04-11 17:18:45',
            ),
            7 => 
            array (
                'id' => '14',
                'unique_id' => '522',
                'age' => '18',
                'created_at' => '2021-04-11 17:18:57',
                'updated_at' => '2021-04-11 17:18:57',
            ),
            8 => 
            array (
                'id' => '15',
                'unique_id' => '469',
                'age' => '19',
                'created_at' => '2021-04-11 17:19:02',
                'updated_at' => '2021-04-11 17:19:02',
            ),
            9 => 
            array (
                'id' => '16',
                'unique_id' => '933',
                'age' => '20',
                'created_at' => '2021-04-11 18:09:50',
                'updated_at' => '2021-04-11 18:09:50',
            ),
            10 => 
            array (
                'id' => '17',
                'unique_id' => '720',
                'age' => '21',
                'created_at' => '2021-04-11 18:09:57',
                'updated_at' => '2021-04-11 18:09:57',
            ),
            11 => 
            array (
                'id' => '18',
                'unique_id' => '292',
                'age' => '22',
                'created_at' => '2021-04-11 18:10:02',
                'updated_at' => '2021-04-11 18:10:02',
            ),
        ));
        
        
    }
}