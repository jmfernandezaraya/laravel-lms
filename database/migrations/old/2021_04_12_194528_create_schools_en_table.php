<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsEnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools_en', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('unique_id');
            $table->string('name');
            $table->string('email')->unique('email');
            $table->string('contact');
            $table->string('emergency_number', 500)->nullable();
            $table->string('branch_name', 500)->nullable();
            $table->string('logo', 500)->nullable();
            $table->string('video', 500)->nullable();
            $table->string('multiple_photos', 500)->nullable();
            $table->string('capacity', 500)->nullable();
            $table->string('facilities', 500)->nullable();
            $table->string('class_size', 500)->nullable();
            $table->string('opened', 500)->nullable();
            $table->string('about', 500)->nullable();
            $table->string('logos', 500)->nullable();
            $table->string('address')->nullable();
            $table->string('city', 500)->nullable();
            $table->string('country', 500)->nullable();
            $table->string('video_url', 500)->nullable();
            $table->bigInteger('viewed_count');
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
        Schema::dropIfExists('schools_en');
    }
}