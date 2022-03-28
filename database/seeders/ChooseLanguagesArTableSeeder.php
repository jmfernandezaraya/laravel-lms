<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class ChooseLanguagesArTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('choose_languages_ar')->delete();
        
        \DB::table('choose_languages_ar')->insert(array (
            0 => 
            array (
                'id' => '11',
                'unique_id' => '1616592093',
                'name' => 'English',
                'created_at' => '2021-03-24 09:21:34',
                'updated_at' => '2021-03-24 09:21:34',
            ),
            1 => 
            array (
                'id' => '12',
                'unique_id' => '1616681834',
                'name' => 'hiieroer',
                'created_at' => '2021-03-25 10:17:15',
                'updated_at' => '2021-03-25 10:17:15',
            ),
            2 => 
            array (
                'id' => '13',
                'unique_id' => '1616681886',
                'name' => 'gg',
                'created_at' => '2021-03-25 10:18:06',
                'updated_at' => '2021-03-25 10:18:06',
            ),
            3 => 
            array (
                'id' => '14',
                'unique_id' => '1616682042',
                'name' => 'gujarath',
                'created_at' => '2021-03-25 10:20:42',
                'updated_at' => '2021-03-25 10:20:42',
            ),
            4 => 
            array (
                'id' => '15',
                'unique_id' => '1616682100',
                'name' => 'dffd',
                'created_at' => '2021-03-25 10:21:41',
                'updated_at' => '2021-03-25 10:21:41',
            ),
            5 => 
            array (
                'id' => '16',
                'unique_id' => '1616682105',
                'name' => 'dffd',
                'created_at' => '2021-03-25 10:21:45',
                'updated_at' => '2021-03-25 10:21:45',
            ),
            6 => 
            array (
                'id' => '17',
                'unique_id' => '1616682198',
                'name' => 'dffd',
                'created_at' => '2021-03-25 10:23:18',
                'updated_at' => '2021-03-25 10:23:18',
            ),
            7 => 
            array (
                'id' => '18',
                'unique_id' => '1616682205',
                'name' => 'dffddd',
                'created_at' => '2021-03-25 10:23:25',
                'updated_at' => '2021-03-25 10:23:25',
            ),
        ));
        
        
    }
}