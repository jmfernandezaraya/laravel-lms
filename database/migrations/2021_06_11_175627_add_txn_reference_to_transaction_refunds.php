<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTxnReferenceToTransactionRefunds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_refunds', function (Blueprint $table) {
            $table->string('txn_reference')->nullable()->after('amount_added');
            $table->string('details')->nullable()->after('txn_reference');
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
        Schema::table('transaction_refunds', function (Blueprint $table) {
            //
        });
    }
}
