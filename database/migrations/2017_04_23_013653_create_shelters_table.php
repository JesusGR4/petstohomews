<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSheltersTable extends Migration {

	public function up()
	{
		Schema::create('shelters', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('altitude')->nullable();
			$table->string('latitude')->nullable();
			$table->string('address');
			$table->string('description');
			$table->string('schedule');
			$table->date('end_date')->nullable();
			$table->integer('user_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('shelters');
	}
}