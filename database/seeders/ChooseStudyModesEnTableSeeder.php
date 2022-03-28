<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class ChooseStudyModesEnTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('choose_study_modes_en')->delete();
        
        \DB::table('choose_study_modes_en')->insert(array (
            0 => 
            array (
                'id' => '1',
                'unique_id' => '1616565574',
                'name' => 'Online',
                'created_at' => '2021-03-24 01:59:34',
                'updated_at' => '2021-03-24 01:59:34',
            ),
            1 => 
            array (
                'id' => '2',
                'unique_id' => '1616565575',
                'name' => 'Offline',
                'created_at' => '2021-03-24 01:59:34',
                'updated_at' => '2021-03-24 01:59:34',
            ),
        ));
        
        
    }
}