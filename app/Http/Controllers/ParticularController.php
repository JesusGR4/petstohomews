<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 16/04/2017
 * Time: 20:06
 */

namespace App\Http\Controllers;


use App\Exceptions\Pets2HomeException;
use App\Http\Requests\RegisterFormRequest;
use App\Particular;
use App\Providers\CodesServiceProvider;
use Illuminate\Http\Request;

class ParticularController extends Controller
{

    public function __construct()
    {
    }

    public function register(RegisterFormRequest $request){

        try{
            return Particular::register($request);
        }catch(Pets2HomeException $e){
            return array('error' => true, 'code' => CodesServiceProvider::SERVER_ERROR_CODE ,
                'message' => $e->getMessage());
        }
    }

    public function getParticular(Request $request){
        try{
            return Particular::getParticular();
        }catch(Pets2HomeException $e){
            return array('error' => true, 'code' => CodesServiceProvider::SERVER_ERROR_CODE ,
                'message' => $e->getMessage());
        }
    }
}