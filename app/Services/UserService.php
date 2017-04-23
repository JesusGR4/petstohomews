<?php
namespace App\Services;
use App\Repositories\UserRepository;
use App\User;
use App\Providers\CodesServiceProvider;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;

class UserService implements UserRepository
{
    // Initialize the model
    private $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     *  Get all users
     */

    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * Get User by email
     */

    public function getUserByEmail($email)
    {
        return User::where('email', '=', $email)->first();
    }

    /**
     * Login
     */

    public function login($request)
    {
        $credentials = $request->only('email', 'password');
        if (! $token = JWTAuth::attempt($credentials)) {
            return array(
                'error' => true,
                'code' => CodesServiceProvider::INVALID_TOKEN,
                'message' => 'invalid_credentials'
            );
        }
        $user = self::getUserByEmail($request->input('email'));
        return array(
            'error' => false,
            'code' => CodesServiceProvider::OK_CODE,
            'token' => compact('token'),
            'data' => $user
        );
    }

    public function getUserByEmailAndToken($email, $token){
        return DB::table('password_resets')->where('token','=',$token)->where('email','=', $email)->first();
    }

}