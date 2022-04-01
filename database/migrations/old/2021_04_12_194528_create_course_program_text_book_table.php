<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseProgramTextBookFeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_program_text_book', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('program_id')->index('course_program_text_book_program_id_foreign');
            $table->longText('text_book_fee');
            $table->longText('text_book_start_date');
            $table->longText('text_book_end_date');
            $table->longText('text_book_note_en');
            $table->longText('text_book_note_ar')->nullable();
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
        Schema::dropIfExists('course_program_text_book');
    }
}