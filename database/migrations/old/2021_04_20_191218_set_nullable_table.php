<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetNullableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_accommodation_under_age', function (Blueprint $table) {
            $table->longText('under_age')->nullable()->change();
            $table->bigInteger('under_age_fees')->nullable()->change();
        });

        Schema::table('course_program_under_age_fees', function (Blueprint $table) {
            $table->longText('under_age')->nullable()->change();
            $table->bigInteger('underage_fee_per_week')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_accommodation_under_age', function (Blueprint $table) {
            //
        });
    }
}
