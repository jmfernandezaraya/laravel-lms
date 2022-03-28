<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Schools extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		Schema::create('schools', function(Blueprint $table){			
			$table->increments('id');
			$table->string('name');
			$table->string('email');
			$table->string('contact');
			$table->string('images')->nullable();
			$table->string('city')->nullable();
			$table->string('address')->nullable();
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
        //
    }
}
