<?php

use Illuminate\Database\Seeder;
use App\Shelter;
use Illuminate\Support\Facades\DB;
class ShelterTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('shelter')->delete();
//        DB::table('shelter')->truncate();
		// UserShelter
		for($i=13;$i<=562;$i++){
            Shelter::create(array(
                'altitude' => $i,
                'latitude' => $i,
                'address' => 'Calle Huertas,'.$i,
                'description' => 'Descripción'.$i,
                'schedule' => 'Lunes a Viernes de 10:00 a 14:00',
                'user_id' => $i
            ));
        }
	}
}