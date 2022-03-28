<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('review', 255);
            $table->integer('rating')->nullable();
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->string('author_type');
            $table->string('author_id', 200);
            $table->string('created_at', 200)->nullable();
            $table->string('updated_at', 200)->nullable();
            $table->softDeletes();
            $table->unsignedBigInteger('school_id')->nullable()->index('reviews_school_id_foreign');
            $table->index(['author_type', 'author_id']);
            $table->index(['model_type', 'model_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}