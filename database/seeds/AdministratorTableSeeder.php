<?php

use Illuminate\Database\Seeder;
use App\Administrator;
use Illuminate\Support\Facades\DB;
class AdministratorTableSeeder extends Seeder {

	public function run()
	{

//        DB::table('administrator')->truncate();
		// UserAdministrator
		Administrator::create(array(
				'user_id' => 1
			));
	}
}