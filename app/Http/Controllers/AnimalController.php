<?php


namespace App\Http\Controllers;
use App\Animal;
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
}