<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeleteToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apply_froms', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('add_type_of_visas', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('add_nationalities', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('add_where_to_travel', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('visa_application_centers', function (Blueprint $table) {
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
        Schema::table('apply_forms', function (Blueprint $table) {
            //
        });
    }
}
