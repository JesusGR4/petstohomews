<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 06/04/2017
 * Time: 16:11
 */

namespace App\Http\Controllers;


use App\Exceptions\BateriasSevillaException;
use App\Http\Requests\Users\PasswordRecoveryFormRequest;
use App\Providers\CodesServiceProvider;
use App\Repositories\PasswordRepository;


class ForgotPasswordController extends Controller
{

    protected $password;
    public function __construct(PasswordRepository $passwordRepository)
    {
        $this->password = $passwordRepository;
        $this->middleware('guest');

    }

    public function sendResetEmail(PasswordRecoveryFormRequest $request){
        try{

            return $this->password->sendLink($request->only('email'));

        }catch (BateriasSevillaException $e){
            return array('error' => true, 'code' => CodesServiceProvider::SERVER_ERROR_CODE ,
                'message' => $e->getMessage());
        }
    }
}