<?php

use Illuminate\Database\Seeder;
use App\Particular;
use Illuminate\Support\Facades\DB;
class ParticularTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('particular')->delete();
//        DB::table('particular')->truncate();
		// UserParticular
		for($i=2;$i<=13;$i++){
            Particular::create(array(
                'surname' => 'Apellido'.$i,
                'user_id' => $i
            ));
        }
	}
}