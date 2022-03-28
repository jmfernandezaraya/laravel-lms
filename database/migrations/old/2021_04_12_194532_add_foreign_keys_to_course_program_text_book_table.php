<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCourseProgramTextBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_program_text_book', function (Blueprint $table) {
            $table->foreign('program_id')->references('unique_id')->on('courses_program_en')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_program_text_book', function (Blueprint $table) {
            $table->dropForeign('course_program_text_book_program_id_foreign');
        });
    }
}