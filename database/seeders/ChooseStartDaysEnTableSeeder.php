<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class ChooseStartDaysEnTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('choose_start_days_en')->delete();
        
        \DB::table('choose_start_days_en')->insert(array (
            0 => 
            array (
                'id' => '7',
                'unique_id' => '797',
                'name' => 'Monday',
                'created_at' => '2021-04-11 17:23:04',
                'updated_at' => '2021-04-11 17:23:04',
            ),
        ));
        
        
    }
}