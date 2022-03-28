<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChooseStudyTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('choose_study_times_en', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->bigInteger('unique_id');
            $table->string('name');
            $table->timestamps();
        });
        
        Schema::create('choose_study_times_ar', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->bigInteger('unique_id');
            $table->string('name');
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
        Schema::dropIfExists('choose__study__times');
    }
}