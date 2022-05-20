<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableAlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_program_under_age_fees', function(Blueprint $blueprint) {
            $blueprint->boolean('can_edit_by_school_admin')->default(0);
        });
        Schema::table('course_programs', function(Blueprint $blueprint) {
            $blueprint->boolean('can_edit_by_school_admin')->default(0);
        });
        Schema::table('course_accommodations_en', function(Blueprint $blueprint) {
            $blueprint->boolean('can_edit_by_school_admin')->default(0);
        });
        Schema::table('course_accommodation_under_age', function(Blueprint $blueprint) {
            $blueprint->boolean('can_edit_by_school_admin')->default(0);
        });
        Schema::table('course_medical_fees', function(Blueprint $blueprint) {
            $blueprint->boolean('can_edit_by_school_admin')->default(0);
        });
        Schema::table('course_program_text_book', function(Blueprint $blueprint) {
            $blueprint->boolean('can_edit_by_school_admin')->default(0);
        });

        Schema::table('airport_fees', function(Blueprint $blueprint) {
            $blueprint->boolean('can_edit_by_school_admin')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
