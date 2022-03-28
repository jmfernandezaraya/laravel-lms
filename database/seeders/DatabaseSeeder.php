<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(CoursesEnTableSeeder::class);
        $this->call(CourseAccomodationsEnTableSeeder::class);
        $this->call(AirportFeesTableSeeder::class);
        $this->call(ChooseAccomodationAgeRangesArTableSeeder::class);
        $this->call(ChooseAccomodationAgeRangesEnTableSeeder::class);
        $this->call(ChooseAccommodationUnderAgesArTableSeeder::class);
        $this->call(ChooseAccommodationUnderAgesEnTableSeeder::class);
        $this->call(ChooseBranchesArTableSeeder::class);
        $this->call(ChooseBranchesEnTableSeeder::class);
        $this->call(ChooseCustodianUnderAgesArTableSeeder::class);
        $this->call(ChooseCustodianUnderAgesEnTableSeeder::class);
        $this->call(ChooseLanguagesArTableSeeder::class);
        $this->call(ChooseLanguagesEnTableSeeder::class);
        $this->call(ChooseProgramAgeRangesArTableSeeder::class);
        $this->call(ChooseProgramAgeRangesEnTableSeeder::class);
        $this->call(ChooseProgramTypesEnTableSeeder::class);
        $this->call(ChooseProgramUnderAgesEnTableSeeder::class);
        $this->call(ChooseStartDaysEnTableSeeder::class);
        $this->call(ChooseStudyModesEnTableSeeder::class);
        $this->call(ChooseStudyTimesEnTableSeeder::class);
        $this->call(CoursesProgramEnTableSeeder::class);
        $this->call(CourseAccommodationUnderAgeTableSeeder::class);

        $this->call(CourseProgramTextBookTableSeeder::class);
        $this->call(SchoolsEnTableSeeder::class);
        $this->call(CourseProgramUnderAgeFeesTableSeeder::class);
        $this->call(UsersTableSeeder::class);

    }
}
