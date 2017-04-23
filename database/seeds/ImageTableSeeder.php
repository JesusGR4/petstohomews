<?php

use Illuminate\Database\Seeder;
use App\image;
use Illuminate\Support\Facades\DB;
class ImageTableSeeder extends Seeder {

	public function run()
	{

		// AdministratorPhoto
		Image::create(array(
				'name' => 'Pets2Home-1.jpg',
				'user_id' => 1
			));

		// ParticularPhoto
		Image::create(array(
				'name' => 'Pets2Home-2.jpg',
				'user_id' => 2
			));

		// ShelterPhoto
		Image::create(array(
				'name' => 'Pets2Home-3.jpg',
				'user_id' => 15
			));
	}
}