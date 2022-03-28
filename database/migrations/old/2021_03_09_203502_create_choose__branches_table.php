<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChooseBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('choose_branches_en', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->bigInteger('unique_id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('choose_branches_ar', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->bigInteger('unique_id');
            $table->string('name');
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
        Schema::dropIfExists('choose__branches');
    }
}