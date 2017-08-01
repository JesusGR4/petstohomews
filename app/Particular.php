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
        $particular = DB::table('particulars')->where('user_id','=', $user->id)->first();
        $image = DB::table('images')->where('user_id','=', $user->id)->first();
        return array('error'=>false, 'code' => CodesServiceProvider::OK_CODE, 'user'=> $user, 'particular' => $particular, 'image' => $image);
    }
    private static function checkImages($request){
        $result = false;
        $input = $request->input('file');
        if(isset($input)){
            $fileNameArray=explode(".", $request->file('file')->getClientOriginalName());
            $length=count($fileNameArray);
            $extension = strtolower($fileNameArray[$length-1]);
            if($extension !='png' && $extension !='jpg' && $extension !='jpeg'){
                $result = true;
            }
        }

        return $result;
    }
    public static function updateParticular($request){
        if(self::checkImages($request)){
            return array('error' => true, 'code' => CodesServiceProvider::FAILED_VALIDATOR_CODE,
                'message' => trans('validation.extension'));
        }
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        $user->province = $request->input('province');
        $user->city = $request->input('city');
        $particular = Particular::where('user_id','=', $user->id)->first();
        $particular->surname = $request->input('surname');
        $file = $request->file('file');
        if(isset($file)){
            $image = DB::table('images')->where('user_id','=',$user->id)->first();
            if(isset($image)){
                $img = Image_File::find($image->id);
                $path =  'img/';
                $realPath = $path.$img->name;
                unlink($realPath);
                $img->delete();
            }

            $imagefile = $request->file('file');
            $nameImage = 'PetsToHome-'.$user->id.'-'.rand(0,1000).'-'.".jpg";
            $directory = public_path('img');

            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }
            $path = $directory . '/' . $nameImage;
            Image::make($imagefile->getRealPath())->save($path);
            $image = new Image_File();
            $image->name = $nameImage;
            $image->user_id = $user->id;
            $image->save();
        }


        $user->save();
        $particular->save();
        return array('error'=>false, 'code' => CodesServiceProvider::OK_CODE, 'image' => $image);
    }
}