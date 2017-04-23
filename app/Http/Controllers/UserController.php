<?php


namespace App\Http\Controllers;

use App\Exceptions\BateriasSevillaException;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Http\Requests\Users\LoginRequest;
use App\Providers\CodesServiceProvider;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{

    private $user;

    public function __construct(UserRepository $userRepository)
    {
        $this->user = $userRepository;
    }

    public function login(LoginRequest $request){
        try {
            return $this->user->login($request);
        } catch (JWTException $e) {
            return array(
                'error' => 'true',
                'code' => CodesServiceProvider::COULD_NOT_CREATE_TOKEN,
                'message' => 'could_not_create_token'
            );
        }
    }

    public function refreshToken(Request $request){
        try{
            $newToken = JWTAuth::refresh($request->only('token')['token']);
            return array(
                'error' => false,
                'code' => CodesServiceProvider::OK_CODE,
                'token' => $newToken
            );
        }catch (TokenBlacklistedException $e){
            return array(
                'error' => true,
                'code' => CodesServiceProvider::BLACKLISTED_TOKEN,
                'message' => 'Este token ya no está en uso'
            );
        }catch (TokenExpiredException $e){
            return array(
                'error' => true,
                'code' => CodesServiceProvider::EXPIRED_TOKEN,
                'message' => 'Este token ha expirado'
            );
        }
    }

    public function logout(){
        try{
            $error = !JWTAuth::invalidate(JWTAuth::getToken());
            if(!$error){
                $code = CodesServiceProvider::OK_CODE;
                $message = 'Has salido del sistema';
            }else{
                $code = CodesServiceProvider::SERVER_ERROR_CODE;
                $message = 'Error en la operación';
            }

            return array(
                'error' => $error,
                'code' => $code,
                'message' => $message
            );
        }catch (TokenBlacklistedException $e){
            return array(
                'error' => true,
                'code' => CodesServiceProvider::BLACKLISTED_TOKEN,
                'message' => 'Este token ya no está en uso'
            );
        }catch (TokenExpiredException $e){
            return array(
                'error' => true,
                'code' => CodesServiceProvider::EXPIRED_TOKEN,
                'message' => 'Este token ha expirado'
            );
        }
    }


}