<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDogsTable extends Migration {

	public function up()
	{
		Schema::create('dogs', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('size');
			$table->integer('animal_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('dogs');
	}
}