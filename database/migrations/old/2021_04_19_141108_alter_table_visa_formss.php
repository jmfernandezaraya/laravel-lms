<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableVisaFormss extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visa_forms', function (Blueprint $table) {
            $table->bigInteger('applying_from')->unsigned()->change();
            $table->bigInteger('application_center')->unsigned()->change();
            $table->bigInteger('nationality')->unsigned()->change();
            $table->bigInteger('to_travel')->unsigned()->change();
            $table->bigInteger('type_of_visa')->unsigned()->change();
            $table->foreign('applying_from')->references('id')->on('apply_froms')->restrictOnDelete();
            $table->foreign('application_center')->references('id')->on('visa_application_centers')->restrictOnDelete();
            $table->foreign('nationality')->references('id')->on('add_nationalities')->restrictOnDelete();
            $table->foreign('to_travel')->references('id')->on('add_where_to_travel')->restrictOnDelete();
            $table->foreign('type_of_visa')->references('id')->on('add_type_of_visas')->restrictOnDelete();
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
