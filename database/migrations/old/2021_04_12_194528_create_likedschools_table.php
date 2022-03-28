<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikedschoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likedschools', function (Blueprint $table) {
            $table->integer('id', true);
            $table->unsignedBigInteger('school_id')->index('likedschools_school_id_foreign');
            $table->unsignedBigInteger('user_id')->index('likedschools_user_id_foreign');
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
        Schema::dropIfExists('likedschools');
    }
}