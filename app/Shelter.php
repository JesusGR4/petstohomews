<?php

namespace App;
use App\Providers\CodesServiceProvider;
use App\Providers\PaginationServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $shelters = DB::table('shelters')->join('users','users.id','=','shelters.user_id')->where('users.province','=', $province)->select('users.*','shelters.description as description', 'shelters.id as shelter_id')->skip(($currentPage-1)*PaginationServiceProvider::limit)->take(PaginationServiceProvider::limit)->get();
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
}