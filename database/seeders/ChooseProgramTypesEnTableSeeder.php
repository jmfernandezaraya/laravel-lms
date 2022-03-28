<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class ChooseProgramTypesEnTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('choose_program_types_en')->delete();
        
        \DB::table('choose_program_types_en')->insert(array (
            0 => 
            array (
                'id' => '2',
                'unique_id' => '1616570596',
                'name' => 'New program',
                'created_at' => '2021-03-24 03:23:16',
                'updated_at' => '2021-03-24 03:23:16',
            ),
            1 => 
            array (
                'id' => '3',
                'unique_id' => '267',
                'name' => 'General English',
                'created_at' => '2021-04-11 17:26:43',
                'updated_at' => '2021-04-11 17:26:43',
            ),
            2 => 
            array (
                'id' => '4',
                'unique_id' => '473',
                'name' => 'intensive',
                'created_at' => '2021-04-11 20:52:57',
                'updated_at' => '2021-04-11 20:52:57',
            ),
        ));
        
        
    }
}