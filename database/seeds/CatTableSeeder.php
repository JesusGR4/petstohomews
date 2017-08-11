<?php

use Illuminate\Database\Seeder;
use App\Cat;
use Illuminate\Support\Facades\DB;
class CatTableSeeder extends Seeder
{

    public function run(){

        for($i=1; $i<=5; $i++){
            Cat::create(Array(
                'animal_id' => $i
            ));
        }

    }
}