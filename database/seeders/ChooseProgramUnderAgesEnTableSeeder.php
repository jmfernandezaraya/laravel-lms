<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class ChooseProgramUnderAgesEnTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('choose_program_under_ages_en')->delete();
        
        \DB::table('choose_program_under_ages_en')->insert(array (
            0 => 
            array (
                'id' => '1',
                'unique_id' => '1616573667',
                'age' => '21',
                'created_at' => '2021-03-24 04:14:28',
                'updated_at' => '2021-03-24 04:14:28',
            ),
            1 => 
            array (
                'id' => '2',
                'unique_id' => '1616573699',
                'age' => '22',
                'created_at' => '2021-03-24 04:14:59',
                'updated_at' => '2021-03-24 04:14:59',
            ),
            2 => 
            array (
                'id' => '5',
                'unique_id' => '816',
                'age' => '15',
                'created_at' => '2021-04-11 17:39:16',
                'updated_at' => '2021-04-11 17:39:16',
            ),
            3 => 
            array (
                'id' => '7',
                'unique_id' => '765',
                'age' => '16',
                'created_at' => '2021-04-11 17:40:12',
                'updated_at' => '2021-04-11 17:40:12',
            ),
            4 => 
            array (
                'id' => '8',
                'unique_id' => '280',
                'age' => '17',
                'created_at' => '2021-04-11 17:40:44',
                'updated_at' => '2021-04-11 17:40:44',
            ),
            5 => 
            array (
                'id' => '9',
                'unique_id' => '192',
                'age' => '18',
                'created_at' => '2021-04-11 17:41:29',
                'updated_at' => '2021-04-11 17:41:29',
            ),
            6 => 
            array (
                'id' => '10',
                'unique_id' => '956',
                'age' => '19',
                'created_at' => '2021-04-11 18:10:34',
                'updated_at' => '2021-04-11 18:10:34',
            ),
            7 => 
            array (
                'id' => '11',
                'unique_id' => '937',
                'age' => '20',
                'created_at' => '2021-04-11 18:10:43',
                'updated_at' => '2021-04-11 18:10:43',
            ),
        ));
        
        
    }
}