<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder {

	public function run()
	{
		Model::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('administrators')->truncate();
        DB::table('images')->truncate();
        DB::table('particulars')->truncate();
        DB::table('password_resets')->truncate();
        DB::table('roles')->truncate();
        DB::table('shelters')->truncate();
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->call('RoleTableSeeder');
        $this->command->info('Role table seeded!');

        $this->call('UserTableSeeder');
        $this->command->info('User table seeded!');

        $this->call('ParticularTableSeeder');
        $this->command->info('Particular table seeded!');

        $this->call('AdministratorTableSeeder');
        $this->command->info('Administrator table seeded!');

        $this->call('ShelterTableSeeder');
        $this->command->info('Shelter table seeded!');

        $this->call('ImageTableSeeder');
        $this->command->info('image table seeded!');

	}
}