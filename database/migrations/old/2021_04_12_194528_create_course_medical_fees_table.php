<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseMedicalFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_medical_fees', function (Blueprint $table) {
            $table->bigIncrements('unique_id');
            $table->unsignedBigInteger('course_unique_id')->index('course_medical_fees_course_id_foreign');
            $table->decimal('medical_fees_per_week');
            $table->date('medical_start_date');
            $table->date('medical_end_date');
            $table->longText('medical_insurance_note_en');
            $table->longText('medical_insurance_note_ar')->nullable();
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
        Schema::dropIfExists('course_medical_fees');
    }
}