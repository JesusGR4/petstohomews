<?php
use Illuminate\Database\Seeder;
use App\Animal;
class AnimalTableSeeder extends Seeder
{

    public function run(){

        for($i=0; $i<10; $i++){
            Animal::create(Array(
               'name' => 'animal'.$i,
                'gender' => 'female',
                'breed' => 'Dangerous',
                'age' => 10+$i,
                'medicalHistory' => 'Good pet',
                'shelter_id' => 100+$i
            ));
        }

    }
}