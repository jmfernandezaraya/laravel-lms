<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableSchools3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn('unique_id');
        });*/

        Schema::table("users",function (Blueprint $table) {
            $table->boolean('can_add_course')->default(0);
            $table->dropColumn('can_edit_course');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schools', function (Blueprint $table) {
            //
        });
    }
}
