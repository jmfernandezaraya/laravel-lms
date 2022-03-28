<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToAppliedForVisass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applied_for_visas', function (Blueprint $table) {
            $table->longText('order_id')->nullable()->after('payment_status');
            $table->decimal('paid_amount')->nullable()->after('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applied_for_visass', function (Blueprint $table) {
            //
        });
    }
}
