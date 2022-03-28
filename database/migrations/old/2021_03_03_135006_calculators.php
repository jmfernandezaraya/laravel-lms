<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Calculators extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('calculators', function(Blueprint $blueprint) {
            $blueprint->bigIncrements('id');
            $blueprint->double('program_cost');
            $blueprint->double('program_registration_fee');
            $blueprint->double('text_book_fee');
            $blueprint->double('summer_fee');
            $blueprint->double('underage_fee');
            $blueprint->double('courier_fee');
            $blueprint->double('discount_fee');
            $blueprint->double('total');
            $blueprint->double('fixed_program_cost');
            $blueprint->timestamps();
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