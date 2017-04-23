<?php

namespace App\Http\Requests;

use App\Providers\CodesServiceProvider;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
class RegisterFormRequest extends FormRequest
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
            "name"	            =>	    "required",
            "surname"	            =>	    "required",
            "phone"	            =>	    "required",
            "email"	            =>	    "required|email|unique:users",
            "province"	            =>	    "required",
            "city"	            =>	    "required",
            "password"	            =>	    "required",
            "confirm_password"	            =>	    "required|same:password"
        ];
    }


    protected function formatErrors(Validator $validator)
    {
        return array('error' => true, 'code' => CodesServiceProvider::FAILED_VALIDATOR_CODE,
            'message' => $validator->errors()->all());
    }
}