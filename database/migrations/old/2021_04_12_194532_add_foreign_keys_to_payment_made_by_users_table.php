<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPaymentMadeByUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_made_by_users', function (Blueprint $table) {
            $table->foreign('order_id')->references('cart_id')->on('transaction')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_made_by_users', function (Blueprint $table) {
            $table->dropForeign('payment_made_by_users_order_id_foreign');
            $table->dropForeign('payment_made_by_users_user_id_foreign');
        });
    }
}
