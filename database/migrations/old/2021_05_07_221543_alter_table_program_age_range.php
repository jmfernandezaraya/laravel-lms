<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableProgramAgeRange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses_program_en', function (Blueprint $table) {
            $table->longText('program_age_range')->default(null)->change();
        });

        Schema::table('course_accommodations_en', function (Blueprint $table) {
            $table->longText('age_range')->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses_program_en', function (Blueprint $table) {
            //
        });
    }
}
