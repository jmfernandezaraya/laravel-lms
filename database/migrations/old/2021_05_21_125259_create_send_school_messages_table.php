<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendSchoolMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_school_messages', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('subject');
            $table->longText('attachment');
            $table->longText('message')->nullable();
            $table->boolean('replied_to')->default(0);
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
        Schema::dropIfExists('send_school_messages');
    }
}
