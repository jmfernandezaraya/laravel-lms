<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCalculators extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calculators', function(Blueprint $blueprint){
           $blueprint->decimal('program_cost', 50, 2)->default(0)->change();
            $blueprint->decimal('program_registration_fee', 50, 2)->default(0)->change();
            $blueprint->decimal('text_book_fee', 50, 2)->default(0)->change();
            $blueprint->decimal('summer_fee', 50, 2)->default(0)->change();
            $blueprint->decimal('under_age_fee', 50, 2)->default(0)->change();
            $blueprint->decimal('courier_fee', 50, 2)->default(0)->change();
            $blueprint->decimal('discount_fee', 50, 2)->default(0)->change();
            $blueprint->decimal('fixed_program_cost', 50, 2)->default(0)->change();
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
