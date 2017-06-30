<?php


namespace App\Services;


use App\Providers\CodesServiceProvider;
use App\Repositories\PasswordRepository;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordService extends UserService  implements PasswordRepository
{

    public function sendLink($credentials)
    {
        $user = self::getUserByEmail($credentials);

        if(is_null($user)){
            return array('error'=>true, 'code' => CodesServiceProvider::INVALID_EMAIL, 'message' => trans('validation.invalid-email'));
        }

        $token = self::createToken($user);
        self::toEmail($token, $user->email);
        return array('error'=>false, 'code' => CodesServiceProvider::OK_CODE);
    }

    public function resetPassword($request){
        $row = self::getUserByEmailAndToken($request->input('email'), $request->input('token'));
        if(is_null($row)){
            return array('error'=>true, 'code' => CodesServiceProvider::INVALID_EMAIL, 'message' => trans('validation.invalid-email'));
        }
        $user = self::getUserByEmail($request->input('email'));
        $user->password = bcrypt($request->input('password'));
        $user->remember_token = Str::random(60);
        $user->save();
        return array('error'=>false, 'code' => CodesServiceProvider::OK_CODE);
    }

    private static function createToken($user){
        $token = hash_hmac('sha256', Str::random(40), 'p3ts2h0m3');
        DB::table('password_resets')->insertGetId(['token' => $token, 'email' => $user->email]);
        return $token;
    }

    private static function toEmail($token, $email){

        Mail::to($email)->send(new EmailService($token));
    }


}