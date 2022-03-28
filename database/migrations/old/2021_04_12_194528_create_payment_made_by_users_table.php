<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMadeByUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_made_by_users', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('user_id')->index('payment_made_by_users_user_id_foreign');
            $table->string('order_id')->index('payment_made_by_users_order_id_foreign');
            $table->bigInteger('course_id');
            $table->bigInteger('program_id');
            $table->bigInteger('accommodation_id');
            $table->bigInteger('airport_id');
            $table->string('study_mode');
            $table->string('age_selected');
            $table->date('date_selected');
            $table->string('program_duration');
            $table->bigInteger('accommodation_duration');
            $table->tinyInteger('medical_checked')->default(0);
            $table->string('insurance_duration');
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
        Schema::dropIfExists('payment_made_by_users');
    }
}