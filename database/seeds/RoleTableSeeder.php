<?php

use Illuminate\Database\Seeder;
use App\Role;
use Illuminate\Support\Facades\DB;
class RoleTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('role')->delete();
//        DB::table('role')->truncate();
		// roleSeed
		Role::create(array(
				'name' => 'administrator'
			));

		// roleSeedParticular
		Role::create(array(
				'name' => 'particular'
			));

		// roleSeedRefuge
		Role::create(array(
				'name' => 'shelter'
			));
	}
}