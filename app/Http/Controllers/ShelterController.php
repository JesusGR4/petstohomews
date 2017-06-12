<?php


namespace App\Http\Controllers;


use App\Exceptions\Pets2HomeException;
use App\Http\Requests\Shelter\CreateShelterRequest;
use App\Providers\CodesServiceProvider;
use App\Shelter;
use Illuminate\Http\Request;


class ShelterController extends Controller
{

    public function __construct()
    {
    }

    public function getSheltersByProvince(Request $request){
        try{
            return Shelter::getShelterByProvince($request);
        }catch(Pets2HomeException $e){
            return array('error' => true, 'code' => CodesServiceProvider::SERVER_ERROR_CODE ,
                'message' => $e->getMessage());
        }
    }

    public function getSheltersByProvincePaginate(Request $request){
        try{
            return Shelter::getSheltersByProvincePaginate($request);
        }catch(Pets2HomeException $e){
            return array('error' => true, 'code' => CodesServiceProvider::SERVER_ERROR_CODE ,
                'message' => $e->getMessage());
        }
    }

    public function getShelterById(Request $request){
        try{
            return Shelter::getShelterById($request);
        }catch(Pets2HomeException $e){
            return array('error' => true, 'code' => CodesServiceProvider::SERVER_ERROR_CODE ,
                'message' => $e->getMessage());
        }
    }

    public function createShelter(CreateShelterRequest $request){
        try{

            dd($request->all());
        }catch(Pets2HomeException $e){
            return array('error' => true, 'code' => CodesServiceProvider::SERVER_ERROR_CODE ,
                'message' => $e->getMessage());
        }
    }
}