<?php

namespace App;
use App\Providers\CodesServiceProvider;
use App\Providers\PaginationServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Image as Image_File;
use Intervention\Image\ImageManagerStatic as Image_Manager;
use Illuminate\Support\Facades\Auth;

class Animal extends Model 
{

    protected $table = 'animals';
    public $timestamps = true;

    public function belongsToShelter()
    {
        return $this->belongsTo('Shelter', 'shelter_id');
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
        $images = DB::table('images')->where('animal_id', '=', $animal->id)->get();
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

    public static function createAnimal($request){
        if(self::checkImages($request)){
            return array('error' => true, 'code' => CodesServiceProvider::FAILED_VALIDATOR_CODE,
                'message' => trans('validation.extension'));
        }
        $animal = self::setAnimal($request);
        self::setImages($request, $animal->id);
        return array('error'=>false, 'code' => CodesServiceProvider::OK_CODE, 'message' => trans('validation.ordersuccess'));
    }

    private static function setAnimal($request){
        $user = Auth::user();
        $shelter = DB::table('shelters')->where('user_id','=', $user->id)->first();
        $animal = new Animal();
        $animal->shelter_id = $shelter->id;
        $animal->name = $request->input('name');
        $animal->breed = $request->input('breed');
        $animal->age = $request->input('age');
        $animal->gender = $request->input('gender');
        $animal->medicalHistory = $request->input('medicalHistory');
        $animal->type = $request->input('type');
        if($animal->type ==1) $animal->size = $request->input('size');
        $animal->save();
        return $animal;
    }

    private static function setImages($request, $animalId){
        //sitio para subir las imágenes http://localhost/petstohomews/public/img/
        for($i=0; $i<$request->input('length'); $i++){
            $imagefile = $request->file('file'.$i);
            $nameImage = 'PetsToHome-'.$animalId.'-'.rand(0,1000).'-'.".jpg";
            $directory = public_path('img');

            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }
            $path = $directory . '/' . $nameImage;
            Image_Manager::make($imagefile->getRealPath())->save($path);
            //Image es una libreria, hay que instalarla con composer.phar.
            $image = new Image_File();
            $image->name = $nameImage;
            $image->animal_id = $animalId;
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
    public static function deleteAnimal($request){
        $animal = Animal::find($request->input('animal_id'));
        self::deleteImagesFromAnimal($animal->id);
        $animal->delete();
        return array(
            'error' => false,
            'code' => CodesServiceProvider::OK_CODE,
        );
    }
    private static function deleteImagesFromAnimal($user_id){
        $images = DB::table('images')->where('animal_id','=',$user_id)->get();
        foreach($images as $image){
            $img = Image_File::find($image->id);
            $path =  'img/';
            $realPath = $path.$img->name;
            unlink($realPath);
            $img->delete();
        }

    }

}