<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisaFormBuildersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_form_builders', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('visa_form_id')->unsigned();
            $table->longText('form_builder_value')->nullable();
            $table->foreign('visa_form_id')->references('id')->on('visa_forms')->cascadeOnDelete();
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
        Schema::dropIfExists('visa_form_builders');
    }
}
