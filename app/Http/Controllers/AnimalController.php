<?php


namespace App\Http\Controllers;
use App\Animal;
use App\Http\Requests\Animal\CreateAnimalRequest;
use Illuminate\Http\Request;
use App\Exceptions\Pets2HomeException;
class AnimalController extends Controller
{

    public function __construct(){


    }

    public function getAnimalsByShelterId(Request $request){
        try{
            return Animal::getAnimalsByShelterId($request);
        }catch(Pets2HomeException $e){
            return array('error' => true, 'code' => CodesServiceProvider::SERVER_ERROR_CODE ,
                'message' => $e->getMessage());
        }
}

    public function getAnimalsByShelter(Request $request){
        try{
            return Animal::getAnimalsByShelter($request);
        }catch(Pets2HomeException $e){
            return array('error' => true, 'code' => CodesServiceProvider::SERVER_ERROR_CODE ,
                'message' => $e->getMessage());
        }
    }

    public function getAnimalById(Request $request){
        try{
            return Animal::getAnimalById($request);
        }catch(Pets2HomeException $e){
            return array('error' => true, 'code' => CodesServiceProvider::SERVER_ERROR_CODE ,
                'message' => $e->getMessage());
        }
    }

    public function getMyAnimals(Request $request){
        try{
            return Animal::getMyAnimals($request);
        }catch(Pets2HomeException $e){
            return array('error' => true, 'code' => CodesServiceProvider::SERVER_ERROR_CODE ,
                'message' => $e->getMessage());
        }
    }

    public function createAnimal(CreateAnimalRequest $request){
        try{
            return Animal::createAnimal($request);
        }catch(Pets2HomeException $e){
            return array('error' => true, 'code' => CodesServiceProvider::SERVER_ERROR_CODE ,
                'message' => $e->getMessage());
        }
    }

    public function deleteAnimal(Request $request){
        try{
            return Animal::deleteAnimal($request);
        }catch(Pets2HomeException $e){
            return array('error' => true, 'code' => CodesServiceProvider::SERVER_ERROR_CODE ,
                'message' => $e->getMessage());
        }
    }
}