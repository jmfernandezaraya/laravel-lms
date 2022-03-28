<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class ChooseCustodianUnderAgesEnTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('choose_custodian_under_ages_en')->delete();
        
        \DB::table('choose_custodian_under_ages_en')->insert(array (
            0 => 
            array (
                'id' => '1',
                'unique_id' => '1616587108',
                'age' => '29',
                'created_at' => '2021-03-24 07:58:28',
                'updated_at' => '2021-03-24 07:58:28',
            ),
            1 => 
            array (
                'id' => '3',
                'unique_id' => '580',
                'age' => '16',
                'created_at' => '2021-04-11 18:13:04',
                'updated_at' => '2021-04-11 18:13:04',
            ),
            2 => 
            array (
                'id' => '4',
                'unique_id' => '204',
                'age' => '17',
                'created_at' => '2021-04-11 18:13:10',
                'updated_at' => '2021-04-11 18:13:10',
            ),
            3 => 
            array (
                'id' => '5',
                'unique_id' => '758',
                'age' => '18',
                'created_at' => '2021-04-11 18:13:15',
                'updated_at' => '2021-04-11 18:13:15',
            ),
            4 => 
            array (
                'id' => '6',
                'unique_id' => '882',
                'age' => '15',
                'created_at' => '2021-04-11 18:13:28',
                'updated_at' => '2021-04-11 18:13:28',
            ),
        ));
        
        
    }
}