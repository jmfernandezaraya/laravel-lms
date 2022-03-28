<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableVisaOtherFee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visa_forms_other_visa_fee', function (Blueprint $table) {
            $table->dropColumn('other_visa_fee');
            $table->string('other_visa_name')->after('visa_form_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visa_forms_other_visa_fee', function (Blueprint $table) {
            //
        });
    }
}
