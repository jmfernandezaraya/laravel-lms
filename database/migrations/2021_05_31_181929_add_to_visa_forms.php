<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToVisaForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visa_forms', function (Blueprint $table) {
            $table->longText('visa_information_en')->after('visa_information');
            $table->longText('visa_information_ar')->after('visa_information_en');
            $table->dropColumn('visa_information');
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
