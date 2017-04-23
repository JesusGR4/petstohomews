<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\BateriasSevillaException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\PasswordRecoveryFormRequest;
use App\Providers\CodesServiceProvider;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Lang;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendResetEmail(PasswordRecoveryFormRequest $request){
        try {

            $response = $this->broker()->sendResetLink(
                $request->only('email')
            );

            if ($response == PasswordBroker::INVALID_USER) {
                return array('error' => true, 'code' => CodesServiceProvider::INVALID_EMAIL,
                    'message' => 'El email introducido no existe');
            } elseif ($response == PasswordBroker::RESET_LINK_SENT) {
                return array('code' => CodesServiceProvider::OK_CODE,
                    'message' => 'Mensaje enviado');
            }
        }catch (BateriasSevillaException $e){
            return array('error' => true, 'code' => CodesServiceProvider::SERVER_ERROR_CODE ,
                'message' => $e->getMessage());
        }
    }
}
