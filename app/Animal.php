<?php

namespace App;
use App\Providers\CodesServiceProvider;
use App\Providers\PaginationServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Image as Image_File;
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

    public function hasManyDogs()
    {
        return $this->hasMany('Dog');
    }

    public function hasManyCats()
    {
        return $this->hasMany('Cat');
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
}