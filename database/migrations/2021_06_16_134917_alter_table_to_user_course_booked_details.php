<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableToCourseApplication extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_applications', function (Blueprint $table) {
            $table->date('accommodation_end_date')->nullable()->after('insurance_duration');
            $table->date('accommodation_start_date')->nullable()->after('insurance_duration');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_applications', function (Blueprint $table) {
            //
        });
    }
}
