<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisaFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_forms', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('appyling_from');
            $table->string('application_center');
            $table->string('nationality');
            $table->string('to_travel');
            $table->string('type_of_visa');
            $table->longText('visa_information');
            $table->string('visa_fee');
            $table->string('insurance_fee');
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
        Schema::dropIfExists('visa_forms');
    }
}
