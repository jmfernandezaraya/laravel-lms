<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class SchoolsEnTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('schools_en')->delete();
        
        \DB::table('schools_en')->insert(array (
            0 => 
            array (
                'id' => '1',
                'unique_id' => '1614169810',
                'name' => 'school',
                'email' => 'email@gmail.com',
                'contact' => '349347943',
                'emergency_number' => '34974397',
                'branch_name' => '["Branch Name"]',
                'logo' => 'y1dlMKEqNtkbO2MFdhZbdXFAfJJhsddfYOua0Hpk.jpg',
                'video' => NULL,
                'multiple_photos' => '["g3Ufg57O6UBK8qlVC4Rw2yXaeeKcZiETsA6DrOtp.jpg","HDra77lVcEqcUIHMOgRURXCbDzmUHvNNsuCLugJd.jpg"]',
                'capacity' => '3473',
                'facilities' => 'No facility',
                'class_size' => '97',
                'opened' => '2016',
                'about' => 'School About',
                'logos' => '["zfMszHoGBZPMiNoVeTFXWd85sKhC0wpN3igJxMaX.jpg"]',
                'address' => 'https://www.google.com',
                'city' => 'City',
                'country' => 'Country',
                'video_url' => '["https:\\/\\/www.linkedin.in"]',
                'viewed_count' => '6',
                'created_at' => '2021-02-24 07:30:14',
                'updated_at' => '2021-04-12 13:04:05',
            ),
            1 => 
            array (
                'id' => '2',
                'unique_id' => '1614258254',
                'name' => 'school name',
                'email' => 'school_email@gmail.com',
                'contact' => '343434',
                'emergency_number' => '3474374',
                'branch_name' => '["fddd","fdfdf"]',
                'logo' => 'ba3w4hJJd3FiCn50nJsmTu8vxXWGtFURckk8GyOF.jpg',
                'video' => NULL,
                'multiple_photos' => '["AtzwOFYJFnbhzc9ZBYsP6CpCQo679oZXuyJ3OrnH.jpg","Tiw3CvT4sqoFIdfIFji5LoTWl5p5ypJPYtnVq3VI.jpg"]',
                'capacity' => '47',
                'facilities' => 'fdfddf',
                'class_size' => '343443',
                'opened' => '2017',
                'about' => 'about',
                'logos' => '["9ZyPDd1IZbyInkJEzdXz3m7tsK8PDukXNrvH43wB.jpg"]',
                'address' => 'fjsdfj',
                'city' => 'city',
                'country' => 'countey',
                'video_url' => '["dfdf","dfderw44"]',
                'viewed_count' => '5',
                'created_at' => '2021-02-25 08:04:22',
                'updated_at' => '2021-04-12 13:03:51',
            ),
            2 => 
            array (
                'id' => '4',
                'unique_id' => '176',
                'name' => 'LSI',
                'email' => 'LSI@LSI.com',
                'contact' => '+966555555555',
                'emergency_number' => '+966555555555',
                'branch_name' => '["center"]',
                'logo' => 'womU7eDuc6OvTRqSEbxUQ4f1d49g79BN3zRL0CcZ.png',
                'video' => NULL,
                'multiple_photos' => '["Ooix0oKXvK1VBjmjEOxvU2rJJKuTvDx1phQe98fJ.png","49yyZK21EGndsPchWt5nsBLOAHR7w5jvt39I129s.png","LSVZ2vSuL2VZ23jBb3THYPLUii00Jyg7deDRw0RW.png"]',
                'capacity' => '300',
                'facilities' => 'test',
                'class_size' => '15',
                'opened' => '2000',
                'about' => 'tet',
                'logos' => '["xsyn9YLNkaTE4k0ndwsmx9ymGIvcy15ok60vT7XG.png"]',
                'address' => 'https://www.google.com/maps/place/The+London+Interdisciplinary+School/@51.5168917,-0.0674857,15z/data=!4m5!3m4!1s0x0:0xfffe9a5870c559b2!8m2!3d51.5168917!4d-0.0674857',
                'city' => 'London',
                'country' => 'UK',
                'video_url' => '["https:\\/\\/www.youtube.com\\/watch?v=ofFf0OBn9fU"]',
                'viewed_count' => '14',
                'created_at' => '2021-04-10 18:32:07',
                'updated_at' => '2021-04-12 14:23:54',
            ),
        ));
        
        
    }
}