<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesEnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses_en', function (Blueprint $table) {
            $table->unsignedBigInteger('unique_id')->primary();
            $table->string('language')->nullable();
            $table->string('program_type')->nullable();
            $table->string('study_mode', 1000)->nullable();
            $table->string('school_id')->nullable();
            $table->string('branch', 500)->nullable();
            $table->string('currency')->nullable();
            $table->string('program_name');
            $table->string('program_level')->nullable();
            $table->string('lessons_per_week')->nullable();
            $table->string('hours_per_week')->nullable();
            $table->string('study_time')->nullable();
            $table->string('every_day')->nullable();
            $table->string('about_program')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses_en');
    }
}
