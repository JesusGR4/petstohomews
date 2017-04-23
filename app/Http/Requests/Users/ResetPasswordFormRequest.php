<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 07/04/2017
 * Time: 12:06
 */

namespace App\Http\Requests\Users;


use App\Providers\CodesServiceProvider;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordFormRequest extends FormRequest
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
            "password"	=>		"required",
            "password_confirmation"	=>		"required | same:password",
            "token"	=>		"required",
        ];
    }


    protected function formatErrors(Validator $validator)
    {
        return array('error' => true, 'code' => CodesServiceProvider::FAILED_VALIDATOR_CODE,
            'message' => $validator->errors()->all());
    }
}