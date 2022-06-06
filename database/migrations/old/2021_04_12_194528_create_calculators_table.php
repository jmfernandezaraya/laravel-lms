<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalculatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calculators', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->string('calc_id', 200);
            $table->double('program_cost');
            $table->double('program_registration_fee');
            $table->double('text_book_fee');
            $table->double('summer_fee');
            $table->decimal('peak_time_fee', 10)->nullable()->default(0.00);
            $table->double('under_age_fee');
            $table->double('courier_fee');
            $table->double('discount_fee');
            $table->double('total');
            $table->double('fixed_program_cost');
            $table->decimal('accommodation_fee', 10)->default(0.00);
            $table->decimal('placement_fee', 10)->default(0.00);
            $table->decimal('accommodation_special_diet_fee', 10)->default(0.00);
            $table->decimal('accommodation_deposit', 10)->default(0.00);
            $table->decimal('accommodation_summer_fee', 10)->default(0.00);
            $table->decimal('accommodation_christmas_fee', 10)->default(0.00);
            $table->decimal('accommodation_under_age_fee', 10)->default(0.00);
            $table->decimal('accommodation_discount', 10)->default(0.00);
            $table->decimal('accommodation_peak_time_fee', 10)->default(0.00);
            $table->decimal('airport_pickup_fee', 10)->default(0.00);
            $table->decimal('medical_insurance_fee', 10)->default(0.00);
            $table->decimal('custodian_fee', 10)->default(0.00);
            $table->decimal('airport_total', 10)->default(0.00);
            $table->double('accommodation_total', 10, 2);
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
        Schema::dropIfExists('calculators');
    }
}