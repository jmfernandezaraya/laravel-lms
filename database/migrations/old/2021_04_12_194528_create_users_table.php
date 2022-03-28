<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name_en');
            $table->string('last_name_en');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 500);
            $table->string('user_type', 500)->nullable();
            $table->string('remember_token', 500)->nullable();
            $table->string('image', 500)->nullable();
            $table->string('original_image', 500)->nullable();
            $table->string('contact', 500)->nullable();
            $table->bigInteger('liked_school')->default(0);
            $table->string('first_name_ar')->nullable();
            $table->string('email_ar')->nullable();
            $table->string('last_name_ar')->nullable();
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
        Schema::dropIfExists('users');
    }
}