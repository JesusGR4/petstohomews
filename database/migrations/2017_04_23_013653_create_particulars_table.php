<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateParticularsTable extends Migration {

	public function up()
	{
		Schema::create('particulars', function(Blueprint $table) {
			$table->increments('id');
			$table->string('surname');
			$table->integer('user_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('particulars');
	}
}