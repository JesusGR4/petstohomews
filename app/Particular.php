<?php

namespace App;

use App\Providers\CodesServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Image as Image_File;
use Intervention\Image\ImageManagerStatic as Image;
class Particular extends Model  {

	protected $table = 'particulars';
	public $timestamps = true;

	public function user()
	{
		return $this->belongsTo('User', 'user_id');
	}

    public static function register($request){
        $user = self::setUser($request);
        self::setParticular($request, $user->id);
        return array('error'=>false, 'code' => CodesServiceProvider::OK_CODE);
    }
    private static function setUser($request){
        $user = new User();
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        $user->province = $request->input('province');
        $user->city = $request->input('city');
        $user->role_id = 2;
        $user->password = bcrypt($request->input('password'));
        $user->save();
        return $user;
    }
    private static function setParticular($request, $userId){
        $particular = new Particular();
        $particular->surname = $request->input('surname');
        $particular->user_id = $userId;
        $particular->save();
    }

    public static function getParticular(){
        $user = Auth::user();
        $particular = DB::table('particularS')->where('user_id','=', $user->id)->first();
        $image = DB::table('images')->where('user_id','=', $user->id)->first();
        return array('error'=>false, 'code' => CodesServiceProvider::OK_CODE, 'user'=> $user, 'particular' => $particular, 'image' => $image);
    }
}