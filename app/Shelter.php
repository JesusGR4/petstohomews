<?php

namespace App;
use App\Providers\CodesServiceProvider;
use App\Providers\PaginationServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Image as Image_File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;
class Shelter extends Model  {

	protected $table = 'shelters';
	public $timestamps = true;

	public function user()
	{
		return $this->belongsTo('User', 'user_id');
	}

    public static function getShelterByProvince(Request $request){

        $shelters = DB::table('shelters')->join('users','users.id','=','shelters.user_id')->where('users.province','=', $request->input('province'))->select('users.*','shelters.description as description', 'shelters.id as shelter_id')->get();

        $result= array();
        //TODO: Mostrar el número de animales por casa de acogida
        /*foreach($shelters as $shelter){
            $numberOfPets
        }*/
        return array(
            'error' => false,
            'code' => CodesServiceProvider::OK_CODE,
            'shelters' => $shelters
        );
    }

    public static function getSheltersByProvincePaginate(Request $request){
        $shelters = self::getSheltersList($request['province'], $request['currentPage']);
        return array(
            'error' => false,
            'code' => CodesServiceProvider::OK_CODE,
            'shelters' => $shelters
        );
    }

    private static function getSheltersList($province, $currentPage){
        $shelters = DB::table('shelters')->where('shelters.status','=',0)->join('users','users.id','=','shelters.user_id')->where('users.province','=', $province)->select('users.*','shelters.description as description', 'shelters.id as shelter_id')->skip(($currentPage-1)*PaginationServiceProvider::limit)->take(PaginationServiceProvider::limit)->get();
        return $shelters;
    }

    public static function getShelterById(Request $request){
        $shelter_id = $request['shelter_id'];
        $shelter = DB::table('shelters')->join('users','users.id','=','shelters.user_id')->where('shelters.id','=', $shelter_id)
            ->select('users.name as user_name','users.phone as user_phone','users.email as user_email','users.city as user_city','shelters.altitude as shelter_longitude','shelters.latitude as shelter_latitude','shelters.address as shelter_address', 'shelters.description as description','shelters.schedule as shelter_schedule')->first();
        return array(
            'error' => false,
            'code' => CodesServiceProvider::OK_CODE,
            'shelter' => $shelter
        );
    }

    public static function createShelter(Request $request){

        if(self::checkImages($request)){
            return array('error' => true, 'code' => CodesServiceProvider::FAILED_VALIDATOR_CODE,
                'message' => trans('validation.extension'));
        }
        $user = self::setUser($request);
        self::setShelter($request, $user->id);
        self::setImages($request, $user->id);
        return array('error'=>false, 'code' => CodesServiceProvider::OK_CODE, 'message' => trans('validation.ordersuccess'));
    }

    private static function setUser($request){
        $user = new User();
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        $user->province = $request->input('province');
        $user->city = $request->input('city');
        $user->role_id = 3;
        $user->password = null;
        $user->save();
        return $user;
    }
    private static function setShelter($request, $userId){
        $shelter = new Shelter();
        $shelter->latitude = $request->input('latitude');
        $shelter->longitude = $request->input('longitude');
        $shelter->address = $request->input('address');
        $shelter->schedule = $request->input('schedule');
        $shelter->description = $request->input('description');
        $shelter->status = 1;
        $shelter->user_id = $userId;
        $shelter->save();
    }

    private static function setImages($request, $shelterId){
        //sitio para subir las imágenes http://localhost/petstohomews/public/img/
        for($i=0; $i<$request->input('length'); $i++){
            $imagefile = $request->file('file'.$i);
            $nameImage = 'PetsToHome-'.$shelterId.'-'.rand(0,1000).'-'.".jpg";
            $directory = public_path('img');

            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }
            $path = $directory . '/' . $nameImage;
            Image::make($imagefile->getRealPath())->save($path);
            //Image es una libreria, hay que instalarla con composer.phar.
            $image = new Image_File();
            $image->name = $nameImage;
            $image->user_id = $shelterId;
            $image->save();
        }


    }

    private static function checkImages($request){
        $result = false;
        for($i=0; $i<$request->input('length'); $i++) {
            $fileNameArray=explode(".", $request->file('file'.$i)->getClientOriginalName());
            $length=count($fileNameArray);
            $extension = strtolower($fileNameArray[$length-1]);
            if($extension !='png' && $extension !='jpg' && $extension !='jpeg'){
                $result = true;
                break;
            }
        }
        return $result;
    }

    public static function getPendingShelters($request){

    }
}