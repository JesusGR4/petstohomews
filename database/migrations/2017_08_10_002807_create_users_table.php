<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('phone', 9);
			$table->string('email')->unique();
			$table->string('province');
			$table->integer('role_id')->unsigned();
			$table->string('city');
			$table->rememberToken('rememberToken');
			$table->string('password')->nullable();
		});

        Schema::create('password_resets',function(Blueprint $table){
            $table->increments('id');
            $table->string('email');
            $table->timestamps();
            $table->string('token');
        });
	}

	public function down()
	{
        Schema::drop('users');
        Schema::drop('password_resets');
    }
}