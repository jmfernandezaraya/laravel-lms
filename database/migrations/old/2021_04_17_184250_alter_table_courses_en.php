<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableCoursesEn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses_en', function (Blueprint $table) {
            $table->longText('about_program')->change();
        });
        Schema::table('courses_program_en', function (Blueprint $table) {
            $table->longText('about_courier')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses_en', function (Blueprint $table) {
            //
        });
    }
}
