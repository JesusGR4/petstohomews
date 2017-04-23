<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 07/04/2017
 * Time: 11:57
 */

namespace App\Http\Controllers;


use App\Exceptions\BateriasSevillaException;
use App\Http\Requests\Users\ResetPasswordFormRequest;
use App\Providers\CodesServiceProvider;
use App\Repositories\PasswordRepository;

class ResetPasswordController extends Controller
{

    protected $password;
    public function __construct(PasswordRepository $passwordRepository){
        $this->password = $passwordRepository;
    }
    public function reset(ResetPasswordFormRequest $request){
        try{

            return $this->password->resetPassword($request);

        }catch (BateriasSevillaException $e){
            return array('error' => true, 'code' => CodesServiceProvider::SERVER_ERROR_CODE ,
                'message' => $e->getMessage());
        }
    }

}