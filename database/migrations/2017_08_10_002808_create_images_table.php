<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateImagesTable extends Migration {

	public function up()
	{
		Schema::create('images', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->integer('user_id')->unsigned()->nullable();
			$table->integer('animal_id')->unsigned()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('images');
	}
}