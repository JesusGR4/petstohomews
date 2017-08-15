<?php

namespace App;
use App\Providers\CodesServiceProvider;
use App\Providers\PaginationServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Image as Image_File;
use Illuminate\Support\Facades\Auth;
class Animal extends Model 
{

    protected $table = 'animals';
    public $timestamps = true;

    public function belongsToShelter()
    {
        return $this->belongsTo('Shelter', 'shelter_id');
    }

    public function hasManyImages()
    {
        return $this->hasMany('Image');
    }


    public static function getAnimalsByShelterId($request){
        $animals = DB::table('animals')->where('shelter_id', '=', $request->input('shelter_id'))->get();

        $image = array();
        foreach($animals as $animal) $image[] = DB::table('images')->where('animal_id','=', $animal->id)->first();
        return array(
            'error' => false,

            'code' => CodesServiceProvider::OK_CODE,
            'animals' => $animals,
            'images' => $image

        );
    }

    public static function getAnimalsByShelter($request){
        $animals = self::getAnimalsList($request);
        $shelter = DB::table('shelters')->where('id', '=', $request->input('shelter_id'))->first();
        $user = DB::table('users')->where('id', '=', $shelter->user_id)->first();
        $images = array();
        foreach($animals as $animal){
            $images[] = DB::table('images')->where('animal_id', '=', $animal->id)->first();
        }

        return array(
            'error' => false,
            'code' => CodesServiceProvider::OK_CODE,
            'shelterA' => $user,
            'animals' => $animals,
            'images' => $images
        );
    }

    private static function getAnimalsList($request){

        $animals = DB::table('animals')->where('shelter_id','=',$request['shelter_id'])->skip(($request['currentPage']-1)*PaginationServiceProvider::limit)->take(PaginationServiceProvider::limit)->get();
        return $animals;

    }

    public static function getAnimalById($request){
        $animal = DB::table('animals')->where('id', '=', $request->input('animal_id'))->first();
        $images = Array();
        $images[] = DB::table('images')->where('animal_id', '=', $animal->id)->get();
        return array(
            'error' => false,
            'code' => CodesServiceProvider::OK_CODE,
            'animal' => $animal,
            'images' => $images
        );
    }

    public static function getMyAnimals($request){
        $user = Auth::user();
        $shelter = DB::table('shelters')->where('user_id','=', $user->id)->first();
        $animals = DB::table('animals')->where('shelter_id','=',$shelter->id)->skip(($request['currentPage']-1)*PaginationServiceProvider::limit)->take(PaginationServiceProvider::limit)->get();
        $images = array();
        foreach($animals as $animal){
            $images[] = DB::table('images')->where('animal_id', '=', $animal->id)->first();
        }
        return array(
            'error' => false,
            'code' => CodesServiceProvider::OK_CODE,
            'animals' => $animals,
            'images' => $images
        );
    }
}