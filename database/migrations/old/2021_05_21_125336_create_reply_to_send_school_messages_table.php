<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReplyToSendSchoolMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reply_to_send_school_messages', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->foreignId('send_school_message_id');
            $table->string('subject');
            $table->longText('attachment')->nullable();
            $table->longText('message');
            $table->foreign('send_school_message_id')->references('id')->on('send_school_messages')->cascadeOnDelete();
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
        Schema::dropIfExists('reply_to_send_school_messages');
    }
}
