<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class ChooseLanguagesEnTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('choose_languages_en')->delete();
        
        \DB::table('choose_languages_en')->insert(array (
            0 => 
            array (
                'id' => '21',
                'unique_id' => '1616592093',
                'name' => 'English',
                'created_at' => '2021-03-24 09:21:34',
                'updated_at' => '2021-03-24 09:21:34',
            ),
        ));
        
        
    }
}