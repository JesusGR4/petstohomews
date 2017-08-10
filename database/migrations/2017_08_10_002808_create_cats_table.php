<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCatsTable extends Migration {

	public function up()
	{
		Schema::create('cats', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('animal_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('cats');
	}
}