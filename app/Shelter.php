<?php

namespace App;
use App\Providers\CodesServiceProvider;
use App\Providers\PaginationServiceProvider;
use App\Services\AcceptEmailService;
use App\Services\RejectEmailService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Image as Image_File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Mail;
class Shelter extends Model  {

	protected $table = 'shelters';
	public $timestamps = true;


    public function user()
	{
		return $this->belongsTo('User', 'user_id');
	}

	private static function checkProvince($province){

        $provincesArray = array("Álava","Ceuta", "Melilla", "Albacete", "Alicante", "Almería", "Asturias", "Ávila", "Badajoz", "Barcelona", "Burgos", "Cáceres", "Cádiz", "Cantabria", "Castellón", "Ciudad Real", "Córdoba", "Cuenca", "Girona", "Granada", "Guadalajara", "Guipúzcoa", "Huelva", "Huesca", "Islas Baleares", "Jaén", "La Coruña", "La Rioja", "Las Palmas", "León", "Lleida", "Lugo", "Madrid", "Málaga", "Murcia", "Navarra", "Ourense", "Palencia", "Pontevedra", "Salamanca", "Santa Cruz de Tenerife", "Segovia", "Sevilla", "Soria", "Tarragona", "Teruel", "Toledo", "Valencia", "Valladolid", "Vizcaya", "Zamora", "Zaragoza");
        return in_array($province, $provincesArray);
	}
	private static function checkNull($attribute){
        return is_null($attribute);
    }
    public static function getShelterByProvince(Request $request){
        if(!self::checkProvince($request->input('province'))){
            return array(
                'error' => true,
                'code' => 404,
                'message' => trans('validation.not-found')
            );
        }
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
        if(self::checkNull($request->input('province'))){
            return array(
                'error' => true,
                'code' => 404,
                'message' => trans('validation.not-found')
            );
        }elseif(!self::checkProvince($request->input('province'))){
            return array(
                'error' => true,
                'code' => 404,
                'message' => trans('validation.not-found')
            );
        }
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

    private static function checkId($shelter_id){
        $result = false;
        if($shelter_id ==0 || is_nan($shelter_id)){
            $result = true;
        }
        return $result;
    }
    public static function getShelterById(Request $request){
        $shelter_id = $request['shelter_id'];
        if(self::checkNull($shelter_id)){
            return array(
                'error' => true,
                'code' => 404,
                'message' => trans('validation.not-found')
            );
        }elseif(self::checkId($shelter_id)){
            return array(
                'error' => true,
                'code' => 404,
                'message' => trans('validation.not-found')
            );
        }
        $shelter = DB::table('shelters')->join('users','users.id','=','shelters.user_id')->where('shelters.id','=', $shelter_id)
            ->select('users.name as user_name','users.id as user_id','users.phone as user_phone','users.email as user_email','shelters.longitude as shelter_longitude','shelters.latitude as shelter_latitude','shelters.address as shelter_address', 'shelters.description as description','shelters.schedule as shelter_schedule','shelters.id as shelter_id', 'users.city as user_city')->first();
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

        $shelters = DB::table('shelters')->join('users','users.id','=','shelters.user_id')->where('shelters.status','=', 1)
            ->select('users.id as user_id','shelters.id as shelter_id','users.name as user_name','users.created_at as created','users.phone as user_phone','users.email as user_email','shelters.longitude as shelter_longitude','shelters.latitude as shelter_latitude','shelters.address as shelter_address', 'shelters.description as description','shelters.schedule as shelter_schedule','users.province as shelter_province','users.city as shelter_city')->skip(($request->input('currentPage')-1)*PaginationServiceProvider::limit)->take(PaginationServiceProvider::limit)->get();
        return array(
            'error' => false,
            'code' => CodesServiceProvider::OK_CODE,
            'totalItems' => count($shelters),
            'shelters' => $shelters
        );
    }

    public static function acceptShelter(Request $request){
        $shelter_id = $request->input('shelter_id');
        if(self::checkShelter($shelter_id)){
            return array(
                'error' => true,
                'code' => 404,
                'message' => trans('validation.not-found')
            );
        }elseif(self::checkNull($shelter_id)){
            return array(
                'error' => true,
                'code' => 404,
                'message' => trans('validation.not-found')
            );
        }elseif(self::checkId($shelter_id)){
            return array(
                'error' => true,
                'code' => 404,
                'message' => trans('validation.not-found')
            );
        }else{
            $shelter = Shelter::find($shelter_id);
            $user = User::find($shelter->user_id);
            $randomPassword = self::randomPassword();
            $user->password = bcrypt($randomPassword);
            $shelter->status = 0;
            $shelter->save();
            $user->save();
            self::acceptEmail($user->email, $randomPassword);
            return array(
                'error' => false,
                'code' => CodesServiceProvider::OK_CODE,
            );
        }
    }
    private static function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
    public static function rejectShelter(Request $request){
            $shelter_id = $request->input('shelter_id');
            if(self::checkShelter($shelter_id)){
                return array(
                    'error' => true,
                    'code' => 404,
                    'message' => trans('validation.not-found')
                );
            }elseif(self::checkNull($shelter_id)){
            return array(
                'error' => true,
                'code' => 404,
                'message' => trans('validation.not-found')
            );
        }elseif(self::checkId($shelter_id)){
            return array(
                'error' => true,
                'code' => 404,
                'message' => trans('validation.not-found')
            );
        }else{
                $shelter = Shelter::find($shelter_id);
                $user = User::find($shelter->user_id);
                self::deleteImagesFromShelter($user->id);
                $shelter->delete();
                $email = $user->email;

                self::deleteUser($user->id);
                self::rejectEmail($email, $request->input('reason'));
                return array(
                    'error' => false,
                    'code' => CodesServiceProvider::OK_CODE,
                );
            }
    }

    private static function checkShelter($shelter_id){
        $result = false;
        $shelter = DB::table('shelters')->where('id','=', $shelter_id)->get();
        if(count($shelter)==0){
            $result = true;
        }
        return $result;
    }

    private static function deleteImagesFromShelter($user_id){
        $images = DB::table('images')->where('user_id','=',$user_id)->get();
        foreach($images as $image){
            $img = Image_File::find($image->id);
            $path =  'img/';
            $realPath = $path.$img->name;
            unlink($realPath);
            $img->delete();
        }

    }

    private static function deleteUser($user_id){

        $user = User::find($user_id);
        $user->delete();
    }

    private static function rejectEmail($email, $reason){

        Mail::to($email)->send(new RejectEmailService($reason));
}

    private static function acceptEmail($email, $password){
        Mail::to($email)->send(new AcceptEmailService($password));
    }
}