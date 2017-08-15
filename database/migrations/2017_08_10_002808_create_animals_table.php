<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAnimalsTable extends Migration {

	public function up()
	{
		Schema::create('animals', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('gender');
			$table->string('breed')->nullable();
			$table->tinyInteger('age');
			$table->string('medicalHistory');
			$table->integer('shelter_id')->unsigned();
            $table->integer('type');
            $table->string('size')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('animals');
	}
}