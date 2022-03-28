<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReplyToSuperAdminCourseMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('super_admin_received_message_student', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->foreignId('received_id');
            $table->foreignId('user_id');
            $table->string('subject');
            $table->longText('attachment')->nullable();
            $table->longText('message');
            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('received_id')->references('id')->on('send_message_to_student_courses')->cascadeOnDelete();
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
        Schema::dropIfExists('reply_to_super_admin_course_messages');
    }
}
