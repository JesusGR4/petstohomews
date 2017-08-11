<?php
use Illuminate\Database\Seeder;
use App\Dog;
class DogTableSeeder extends Seeder
{

    public function run(){

        for($i=6; $i<=10; $i++){
            Dog::create(Array(
                'size' => 'medium',
                'animal_id' => $i
            ));
        }

    }
}