<?php

namespace App\Http\Requests\Shelter;

use App\Providers\CodesServiceProvider;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;


class CreateShelterRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
//            "name"	            =>	    "required",
//            "shelter.phone"	            =>	    "required",
//            "shelter.email"	            =>	    "required|email|unique:users",
//            "shelter.province"	            =>	    "required",
//            "shelter.city"	            =>	    "required",
//            "shelter.longitude"	            =>	    "required",
//            "shelter.latitude"	            =>	    "required",
//            "shelter.address"	            =>	    "required",
//            "shelter.description"	            =>	    "required",
//            "shelter.schedule"	            =>	    "required",
        ];
    }


    protected function formatErrors(Validator $validator)
    {

        $messages = array();
        foreach($validator->errors()->all() as $error){
            array_push($messages, trans($error));
        }

        return array('error' => true, 'code' => CodesServiceProvider::FAILED_VALIDATOR_CODE,
            'message' => $messages);
    }
}