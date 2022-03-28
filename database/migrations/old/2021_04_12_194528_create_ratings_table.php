<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rating');
            $table->string('ratingable_type');
            $table->unsignedBigInteger('ratingable_id');
            $table->string('author_type');
            $table->unsignedBigInteger('author_id');
            $table->tinyInteger('approved')->default(0);
            $table->timestamps();
            $table->string('comments')->nullable();
            $table->index(['author_type', 'author_id']);
            $table->index(['ratingable_type', 'ratingable_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratings');
    }
}