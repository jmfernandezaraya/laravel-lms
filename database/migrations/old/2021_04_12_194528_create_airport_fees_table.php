<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAirportFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airport_fees', function (Blueprint $table)
        {
            $table->bigInteger('unique_id', true);
            $table->unsignedBigInteger('course_unique_id')->index('airport_fees_course_unique_id_foreign');
            $table->string('name_en', 500)->nullable();
            $table->string('name_ar', 500)->nullable();
            $table->string('service_name_en', 500);
            $table->string('service_name_ar', 500)->nullable();
            $table->decimal('service_fee', 10);
            $table->string('week_selected_fee', 200);
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
        Schema::dropIfExists('airport_fees');
    }
}