<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AirportFees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('course_airport_fees', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('course_unique_id');
            $table->string('medical_fees_per_week')->nullable();
            $table->string('medical_start_date')->nullable();
            $table->string('medical_end_date')->nullable();
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
        //
    }
}
