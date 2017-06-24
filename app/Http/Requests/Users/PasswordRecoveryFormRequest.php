<?php

namespace App\Http\Requests\Users;

use App\Providers\CodesServiceProvider;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class PasswordRecoveryFormRequest extends FormRequest
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
            "email"	=>		"required|email|max:50",
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