<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToTableAppliedForVisas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applied_for_visas', function (Blueprint $table) {
            $table->string('nationality')->after('user_id');
            $table->string('travel')->after('user_id');
            $table->string('visa')->after('user_id');
            $table->string('people')->after('user_id');
            $table->string('applyfrom')->after('user_id');
            $table->string('visa_center')->after('user_id');
            $table->json('other_fields')->nullable()->after("visa_center");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('table_applied_for_visas', function (Blueprint $table) {
            //
        });
    }
}
