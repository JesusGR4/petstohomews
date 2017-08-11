<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('users', function(Blueprint $table) {
			$table->foreign('role_id')->references('id')->on('roles')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('administrators', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('particulars', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('shelters', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('images', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('images', function(Blueprint $table) {
			$table->foreign('animal_id')->references('id')->on('animals')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('animals', function(Blueprint $table) {
			$table->foreign('shelter_id')->references('id')->on('shelters')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('dogs', function(Blueprint $table) {
			$table->foreign('animal_id')->references('id')->on('animals')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('cats', function(Blueprint $table) {
			$table->foreign('animal_id')->references('id')->on('animals')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		Schema::table('users', function(Blueprint $table) {
			$table->dropForeign('users_role_id_foreign');
		});
		Schema::table('administrators', function(Blueprint $table) {
			$table->dropForeign('administrators_user_id_foreign');
		});
		Schema::table('particulars', function(Blueprint $table) {
			$table->dropForeign('particulars_user_id_foreign');
		});
		Schema::table('shelters', function(Blueprint $table) {
			$table->dropForeign('shelters_user_id_foreign');
		});
		Schema::table('images', function(Blueprint $table) {
			$table->dropForeign('images_user_id_foreign');
		});
		Schema::table('images', function(Blueprint $table) {
			$table->dropForeign('images_animal_id_foreign');
		});
		Schema::table('animals', function(Blueprint $table) {
			$table->dropForeign('animals_shelter_id_foreign');
		});
		Schema::table('dogs', function(Blueprint $table) {
			$table->dropForeign('dogs_animal_id_foreign');
		});
		Schema::table('cats', function(Blueprint $table) {
			$table->dropForeign('cats_animal_id_foreign');
		});
	}
}