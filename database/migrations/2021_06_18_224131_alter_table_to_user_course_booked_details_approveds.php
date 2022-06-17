<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableToCourseApplicationApproves extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('course_applications_approveds');
        Schema::create('course_applications_approveds', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\CourseApplication::class);
            $table->boolean('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_applications_approveds', function (Blueprint $table) {
            //
        });
    }
}
