<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableSchools extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schools_en', function (Blueprint $table) {
            $table->string('name_ar');
            $table->string('branch_name_ar', 500)->nullable();
            $table->string('facilities_ar', 500)->nullable();
            $table->string('class_size_ar', 500)->nullable();
            $table->string('address_ar')->nullable();
            $table->string('city_ar', 500)->nullable();
            $table->string('country_ar', 500)->nullable();
            $table->string('about_ar', 500)->nullable();
            $table->bigInteger('viewed_count')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schools_en', function (Blueprint $table) {
            //
        });
    }
}
