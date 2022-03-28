<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableVisaForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_forms_other_visa_fee', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('visa_form_id')->unsigned();
            $table->foreign('visa_form_id')->references('id')->on('visa_forms')->cascadeOnDelete();
            $table->double('other_visa_fee');
            $table->double('other_visa_price');
        });

        Schema::create('visa_forms_visa_services_fee', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('visa_form_id')->unsigned();
            $table->foreign('visa_form_id')->references('id')->on('visa_forms')->cascadeOnDelete();
            $table->double('visa_service_fee');
            $table->double('tax_fee');
            $table->bigInteger('travelers_number_start');
            $table->bigInteger('travelers_number_end');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visa_forms', function (Blueprint $table) {
            //
        });
    }
}
